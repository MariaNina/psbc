<?php

namespace App\Http\Controllers;

use DateTimeZone;
use Carbon\Carbon;
use App\Models\Salary;
use App\Models\UsersTbl;
use App\Models\StaffsTbl;
use App\Models\SubjectTbl;
use App\Utilities\Filepond;
use App\Models\TimeSettings;
use Illuminate\Http\Request;
use App\Utilities\AccessRoute;
use App\Utilities\AuditTrail;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class StaffController extends Controller
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
        if ($request->ajax()) {

            $StaffTbl = StaffsTbl::select("staffs_tbls.*",
        "subject_tbls.subject_name as subject_name")
        ->leftjoin("subject_tbls","staffs_tbls.major_in","subject_tbls.id");

            return DataTables::of($StaffTbl)
                ->addIndexColumn()
                ->filterColumn('user_fullname', function($StaffTbl, $keyword) {
                    $StaffTbl->where('last_name', 'like', "%{$keyword}%")
                        ->orWhere('first_name', 'like', "%{$keyword}%")
                        ->orWhere('middle_name', 'like', "%{$keyword}%")
                        ->orWhere('extension_name', 'like', "%{$keyword}%"); // you can implement any logic you want here
                })
                ->orderColumn('user_fullname', function ($query, $order) {
                    $query->orderBy('staffs_tbls.last_name', $order);
                })
                ->addColumn('user_fullname', function ($StaffTbl) {

                    $user_fullname = $StaffTbl->last_name.', '.$StaffTbl->first_name.' '.$StaffTbl->middle_name[0].' '.$StaffTbl->extension_name;
                    return $user_fullname; // Return Date
                })
                ->addColumn('action', function ($StaffTbl) {

                    $is_active = ($StaffTbl->is_active == TRUE) ? 'deactivate' : 'activate';

                    //button QRCode
                     $button = '<span id="qrcode-data"  class="actionCust qrcode-employee" title="Generate QRCode" data-id="' .$StaffTbl->id . '"><a class=""><i class="fas fa-qrcode"></i></a></span>';

                    //button update
                    $button .= '<span class="actionCust editData" title="update term" data-id="' . md5($StaffTbl->id) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    // $button .='<span class="actionCust '.$is_active.'"  title="'.$is_active.' term" data-id="'.md5($StaffTbl->id).'" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>' ;


                    return $button; // Return Button
                })
                ->addColumn('images', function ($StaffTbl) {
                    $name = $StaffTbl->first_name . $StaffTbl->last_name;
                    $image = $StaffTbl->image; // Return Row NUmber
                    $avatar = $name[0];

                    if (file_exists(asset('storage/' . $image))) { //check if image is empty
                        $destinationPath = asset('storage/' . $image);
                    } else {
                        $destinationPath = asset('/uploads/avatars/' . $avatar . '.svg');
                    }

                    $img = '<img class="img-profile rounded-circle"
                        src="' . $destinationPath . '" width="50px" height="50px" >';

                    return $img;
                })
                ->rawColumns(['user_fullname', 'images', 'action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);

        }
        $data['title'] = "Employees";
        $data['majors'] = SubjectTbl::all();
        $data['permissions'] = AccessRoute::user_permissions(session('user')->id);

        return view('dashboard.employee', $data);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function partialValue($userId, $firstName, $middleName, $lastName)
    {
        //
        $Staff = new StaffsTbl;
        $Staff->user_id = $userId;
        $Staff->first_name = $firstName;
        $Staff->middle_name = $middleName;
        $Staff->last_name = $lastName;
        if($Staff->save()){
            //log to audit trail
            $new_data = $Staff;
            $action_taken = 'Create';
            $description = 'Add New Staff';
            AuditTrail::logAuditTrail( $action_taken , $description , $new_data);
            //end log
       }
    }

    public function show(Request $request,$id)
    {
        //
        // $data['student'] = StudentsTbl::select(
        //     DB::raw("CONCAT(students_tbls.last_name,', ',students_tbls.first_name,' ',students_tbls.middle_name) AS name"),
        //     "students_tbls.lrn as lrn","students_tbls.image as img"
        // )->where('id',$id)->first();
        $data['name'] = StaffsTbl::select(DB::raw("CONCAT(staffs_tbls.last_name,' ',staffs_tbls.first_name,' ',staffs_tbls.middle_name) as name"))->where('id',$id)->first();
        $data['lrn'] = StaffsTbl::select("staffs_tbls.csc_id")->where('id',$id)->first();
        $data['img'] = StaffsTbl::select("staffs_tbls.image")->where('id',$id)->first();
        $data['department']= StaffsTbl::select("staffs_tbls.Department")->where('id',$id)->first();
        return $data;
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
        $data['getDataById'] = StaffsTbl::where(DB::raw('md5(id)'), $id)->get();
        $data['subjects'] = SubjectTbl::all();
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *w
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $data['image'] = "";
        $update = StaffsTbl::where(DB::raw('md5(id)'), $id);
        $staffName = $request->firstName . $request->lastName;
        $data['first_name'] = $request->firstName;
        $data['middle_name'] = $request->middleName;
        $data['last_name'] = $request->lastName;
        $data['extension_name'] = $request->extensionName;
        $data['csc_id'] = $request->cscNumber;
        $data['staff_type'] = $request->employmentType;
        $data['position'] = $request->position;
        $data['Department'] = $request->department;
        $data['major_in'] = $request->majorIn;
        $data['licence_number'] = $request->licenseNumber;
        $data['is_masteral'] = $request->isMasteral;
        $data['birth_day'] = $request->birthday;
        $data['birth_place'] = $request->birthPlace;
        $data['gender'] = $request->gender;
        $data['civil_status'] = $request->civilStatus;
        $data['height_m'] = $request->height;
        $data['weight_kg'] = $request->weight;
        $data['blood_type'] = $request->bloodType;
        $data['gsis'] = $request->gsis;
        $data['pagibig'] = $request->pagibig;
        $data['sss'] = $request->sss;
        $data['tin'] = $request->tin;
        $data['phil_health'] = $request->philHealth;
        $data['agency_employee_no'] = $request->agencyNumber;
        $data['citizenship'] = $request->citizenship;
        $data['address'] = $request->address;
        $data['zip_code'] = $request->zipCode;
        $data['telephone_number'] = $request->telNumber;
        $data['mobile_number'] = $request->mobileNumber;
        $data['bio_id'] = $request->bio_id;
        if ($request->hasFile('staffImage')) { //check if it has file
            $image = $request->file('staffImage'); //get file
            $image_name = $staffName . '.' . $image->getClientOriginalExtension(); //create a unique file name
            $destinationPath = storage_path('app/public/avatars_img'); //path to save image 'url/public/uploads/...'
            $path ='/avatars_img/';
            Filepond::deleteFileWhenFound(storage_path('app/public/avatars_img/').$image_name);
            $image->move($destinationPath, $image_name); //move and save file to folder
            $data['image'] = $path.$image_name; //declare to save in database
        } else {
            $pic = $update->get("image");
            $data['image'] = $pic[0]->image;
        }
        $update->update($data);
        $staffId = StaffsTbl::select('id')->where(DB::raw('md5(id)'),$id)->first();
        //insert in slary settings if not exists
        $nowInManila = Carbon::now(new DateTimeZone('Asia/Manila'));
        $Salary = Salary::firstOrNew(array('staff_id'=> $staffId->id));
        if($Salary->salary_amount ==0)
        {
        $Salary->salary_amount = 0;
        $Salary->salary_classification = "daily";
        $Salary->employment_status = "regular";
        $Salary->is_active = 1;
        $Salary->encoded_by = session('user')->full_name;
        $Salary->created_at = $nowInManila;
        $Salary->updated_at = $nowInManila;
        $Salary->save();
        }

        // Add Staff on TimeSettings if Not Exist
        $doesExist = TimeSettings::where(DB::raw('md5(staff_id)'), $id)->exists();

        if(!$doesExist) {
            TimeSettings::create([
                'staff_id' => $staffId->id,
                'morning_in' => NULL,
                'morning_out' => NULL,
                'afternoon_in' => NULL,
                'afternoon_out' => NULL,
                'days' => NULL,
                'required_time' => NULL
            ]);
        }

       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    //select all teachers
    // public function getAllTeachers()
    // {
    //     $teachers = StaffsTbl::select("id","last_name","first_name","staff_type")->where("staff_type","Academic")->orderBy("last_name")->get();
        
    //     return response()->json($teachers);
    // }

}
