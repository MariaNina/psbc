<?php

namespace App\Http\Controllers;

use App\Models\TimeSettings;
use App\Utilities\AccessRoute;
use DateTimeZone;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\UsersTbl;
use App\Models\BranchTbl;
use App\Models\PageTbl;
use App\Models\RoleTbl;
use App\Models\StaffsTbl;
use App\Mail\UserDetailsMail;
use App\Models\Permissions;
use App\Models\Salary;
use App\Models\StudentsTbl;
use App\Utilities\AuditTrail;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('authenticated')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $user_id = auth()->user()->id;

        if ($request->ajax()) {

            $UserTbl = UsersTbl::select(
                "users_tbls.id as userId",
                "users_tbls.full_name as full_name",
                "users_tbls.user_name as user_name",
                "branch_tbls.branch_name as branch_name",
                "users_tbls.email as email",
                "role_tbls.role_name as role_name",
                "users_tbls.is_active as isActive"
            )
                ->join('branch_tbls', 'users_tbls.branch_id', '=', 'branch_tbls.id')
                ->join('role_tbls', 'users_tbls.role_id', '=', 'role_tbls.id')

                ->where(function ($query) use ($user_id) {
                    if ($user_id !== 1) {
                        $query->where('branch_id', session('user')->branch_id);
                    }
                });

            return DataTables::of($UserTbl)
                ->addIndexColumn()
                ->addColumn('action', function ($UserTbl) {

                    $is_active = ($UserTbl->isActive == TRUE) ? 'deactivate' : 'activate';

                    //button update
                    $button = '<span class="actionCust editData" title="update user" data-id="' . md5($UserTbl->userId) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    $button .= '<span class="actionCust ' . $is_active . '"  title="' . $is_active . 'user" data-id="' . md5($UserTbl->userId) . '" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>';


                    $button .= '<span class="actionCust reset-password-btn" title="Reset Password" data-id="' . md5($UserTbl->userId) . '" ><a href="#!"><i class="fas fa-key text-primary"></i></a></span>';

                    // //button update
                    // $button .= '<span class="actionCust userPermission" title="user permission" data-id="' . $UserTbl->userId . '">
                    // <a href="#!" href="#" role="button" data-toggle="modal" data-target="#userPermissionModal"><i class="fas fa-user-cog"></i></a>
                    // </span>';


                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);
        }

        $branches = BranchTbl::where(function ($query) use ($user_id) {
            if ($user_id === 1) {
                $query->where('id', session('user')->branch_id);
            }
        })->get();

        $title = "Users";
        $roles = RoleTbl::all();
        $pages = PageTbl::all();
        $one = UsersTbl::all()->sortByDesc("id")->first();
        $permissions = AccessRoute::user_permissions($user_id);

        return view('dashboard.user', compact('branches', 'roles', 'title', 'pages', 'one', 'permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $length = 12)
    {
        //
        $request->validate([
            'firstName' => ['required', 'min:2'],
            'lastName' => ['max:100', 'string', 'min:2'],
            'username' => ['min:8', 'max:100'],
            'email' => ['email']
        ]);

        try {
            DB::beginTransaction();

            $fullName = $request->firstName . " " . $request->middleName . " " . $request->lastName;
            $characters = sha1(md5($fullName . "123456"));
            $characterLength = strlen($characters);
            $randomStr = '';
            for ($i = 0; $i < $length; $i++) {
                $randomStr = $characters[rand(0, $characterLength - 1)];
            }

            $nowInManila = Carbon::now(new DateTimeZone('Asia/Manila'));

            $salt = md5($randomStr);
            $password = sha1("PSBCNumber1", TRUE);
            $hashed_password = password_hash($password, PASSWORD_BCRYPT, [$salt]);
            $User = new UsersTbl;
            $User->branch_id = $request->branchName;
            $User->full_name = $fullName;
            $User->user_name = $request->username;
            $User->password = $hashed_password;
            $User->salt = $salt;
            $User->email = $request->email;
            $User->role_id = $request->roleName;
            $User->is_active = 1;
            $User->joined_at = $nowInManila;
            $User->save();

            foreach ($request->permission as $page) {
                $per = new Permissions;
                $per->user_id = $User->id;
                $per->page_id = $page;
                $per->save();
            }

            $Staff = new StaffsTbl;
            $Staff->user_id = $User->id;
            $Staff->first_name = $request->firstName;
            $Staff->middle_name = $request->middleName;
            $Staff->last_name = $request->lastName;
            $Staff->save();

            $Salary = new Salary();
            $Salary->staff_id = $Staff->id;
            $Salary->salary_amount = 0;
            $Salary->salary_classification = "daily";
            $Salary->special_allowance = 0;
            $Salary->employment_status = "regular";
            $Salary->is_active = 1;
            $Salary->encoded_by = session('user')->full_name;
            $Salary->created_at = $nowInManila;
            $Salary->updated_at = $nowInManila;
            $Salary->save();

            // Time Settings
            TimeSettings::create([
                'staff_id' => $Staff->id,
                'morning_in' => NULL,
                'morning_out' => NULL,
                'afternoon_in' => NULL,
                'afternoon_out' => NULL,
                'days' => NULL,
                'required_time' => NULL
            ]);

            DB::commit();
        } catch (\Exception $e) {

            DB::rollBack();
        }

        //log to audit trail
        $new_data = $User;
        $action_taken = 'Create';
        $description = 'New user added';
        AuditTrail::logAuditTrail($action_taken, $description, $new_data);
        //end log

        Mail::to($User->email)->send(new UserDetailsMail("PSBCNumber1"));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data['getDataById'] = UsersTbl::where(DB::raw('md5(id)'), $id)->get();
        $data["roles"] = RoleTbl::all();
        $data["branches"] = BranchTbl::all();
        $data["staffs"] = ($data['getDataById'][0]->role_id != 3) ? StaffsTbl::all() : StudentsTbl::all();
        $data['pages'] = PageTbl::all();
        $data["permissions"] = Permissions::select("page_id")->where(DB::raw('md5(user_id)'), $id)->get();
        // $data["permissions"] = Permissions::select("permissions.*",
        //     "page_tbls.id as id", "page_tbls.page_name as page_name")
        //     ->join("page_tbls", "permissions.page_id", "=", "page_tbls.id")->get();
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'firstName' => ['required', 'min:2'],
            'lastName' => ['max:100', 'string', 'min:2'],
            'username' => ['min:8', 'max:100'],
            'email' => ['email']
        ]);

        $fullName = $request->firstName . " " . $request->middleName . " " . $request->lastName;
        $update = UsersTbl::where(DB::raw('md5(id)'), $id);
        $data['role_id'] = $request->roleName;
        $data['branch_id'] = $request->branchName;
        $data['user_name'] = $request->username;
        $data['email'] = $request->email;
        $data['full_name'] = $fullName;
        $update->update($data);
        $update2 = "";
        if ($data['role_id'] != 3) {
            $update2 = StaffsTbl::where(DB::raw('md5(user_id)'), $id);
        } else {
            $update2 = StudentsTbl::where(DB::raw('md5(user_id)'), $id);
        }
        $data2['first_name'] = $request->firstName;
        $data2['middle_name'] = $request->middleName;
        $data2['last_name'] = $request->lastName;
        $update2->update($data2);

        DB::table('permissions')->where(DB::raw('md5(user_id)'), $id)->delete();
        if ($data['role_id'] != 3) {
            foreach ($request->editPermission as $page) {
                $per = new Permissions;
                $per->user_id = $request->id;
                $per->page_id = $page;
                $per->save();
            }
        }
        return response()->json(['success' => 'Users successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        $deactivate = UsersTbl::where(DB::raw('md5(id)'), $id);
        $data['is_active'] = $request->is_active;
        $deactivate->update($data);
    }

    public function updateUsersPermission(Request $request, $id)
    {
        // Additional Security
        // Ensure that the authenticated user is role admin before giving access
        $user_auth = UsersTbl::with('role')->findOrFail(session('user')->id);

        abort_if(($user_auth->role->role_name !== "Super Admin"), 403); // return status of 403 forbidden

        $user = UsersTbl::findOrFail($id);

        $user->pages()->sync($request->pageId); // update many to many relationship

        return response()->json(['msg' => 'Permission updated']); // response of success message
    }

    public function resetPassword(Request $request)
    {
        $id = $request->id;

        $user = UsersTbl::where(DB::raw('md5(id)'), $id)->first();

        $fullName = $user->first_name . " " . $user->middle_name . " " . $user->last_name;
        $characters = sha1(md5($fullName . "123456"));
        $characterLength = strlen($characters);
        $randomStr = '';
        for ($i = 0; $i < 12; $i++) {
            $randomStr = $characters[rand(0, $characterLength - 1)];
        }
        $salt = md5($randomStr);
        $password = sha1("PSBCNumber1", TRUE);
        $hashed_password = password_hash($password, PASSWORD_BCRYPT, [$salt]);

        try {
            $user->update([
                'password' => $hashed_password
            ]);

            return response(['msg' => 'Password has been successfully reset']);
        } catch (\Exception $e) {
            return response(['msg' => 'Something went wrong, please try again later']);
        }
    }
}
