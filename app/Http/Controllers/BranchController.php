<?php

namespace App\Http\Controllers;

use App\Models\BranchTbl;
use App\Utilities\AccessRoute;
use App\Utilities\AuditTrail;
use Exception;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class BranchController extends Controller
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

            $BranchTbl = BranchTbl::select();

            return DataTables::of($BranchTbl)
                ->addIndexColumn()
                ->addColumn('action', function ($BranchTbl) {

                    // $is_active = ($BranchTbl->is_active == TRUE) ? 'deactivate' :'activate';

                    //button update
                    $button = '<span class="actionCust editData" title="update branch" data-id="' . md5($BranchTbl->id) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    //   $button .='<span class="actionCust '.$is_active.'"  title="'.$is_active.' branch" data-id="'.md5($BranchTbl->id).'" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>' ;

                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);
        }

        $title = 'Branches';

        $permissions = AccessRoute::user_permissions(session('user')->id);


        return view('dashboard.branch', compact('title', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'branch_name' => ['required', 'max:10', 'min:3'],
            'branch_address' => ['required', 'max:100', 'min:5'],
            'branch_desc' => ['max:100'],
            'branch_email' => ['required', 'max:30'],
            'branch_contact' => ['required', 'max:11', 'min:7'],
            'branch_tel' => ['required', 'max:30'],
        ]);
    
        $branch = BranchTbl::where('branch_name',$request->branch_name);

        if($branch->doesntExist()){

            $branch = new BranchTbl;
            $branch->branch_name = $request->branch_name;
            $branch->branch_address = $request->branch_address;
            $branch->description = $request->branch_desc;
            $branch->email = strtolower($request->branch_email);
            $branch->mobile_no = $request->branch_contact;
            $branch->telephone_no = $request->branch_tel;

            if($branch->save()){

                //log to audit trail
                $new_data = $branch;
                $action_taken = 'Create';
                $description = 'Created New Branch';
                AuditTrail::logAuditTrail( $action_taken , $description , $new_data);
                //end log

                return response()->json(['message' => 'New Branch successfully created', 'status' => 'success']);
            }
           
        }else{
            return response()->json(['message' => 'Branch Name Already Exist!', 'status' => 'error']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $getDataById = BranchTbl::where(DB::raw('md5(id)'), $id)->get();
        return $getDataById;

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
            'branch_name' => ['required', 'max:10', 'min:3'],
            'branch_address' => ['required', 'max:100', 'min:5'],
            'branch_desc' => ['max:100'],
            'branch_email' => ['required', 'max:30'],
            'branch_contact' => ['required', 'max:11', 'min:7'],
        ]);

        $branch_name = $request->branch_name;
        $branch_address = $request->branch_address;
        $description = $request->branch_desc;
        $email = strtolower($request->branch_email);
        $mobile_no = $request->branch_contact;
        $telephone_no = $request->branch_tel;

        $check = BranchTbl::where('branch_name', $request->branch_name)->first();

        try{

            if(md5($check->id) <> $id){
                return response()->json(['message' => 'Branch Name Already Exist!', 'status' => 'error']);
            }
            if((md5($check->id) == $id) && 
                (strtoupper($check->branch_name) == strtoupper($branch_name)) && 
                (strtoupper($check->branch_address) == strtoupper($branch_address)) &&
                (strtoupper($check->description) == strtoupper($description)) &&
                (strtoupper($check->email) == strtoupper($email)) &&
                ($check->mobile_no == $mobile_no) &&
                ($check->telephone_no == $telephone_no)
            ){
                return response()->json(['message' => 'No Changes Made!', 'status' => 'error']);
            }
            
            $old_data = $check;
            
            $branch = BranchTbl::where(DB::raw('md5(id)'),$id)->first();

            $branch->branch_name = $branch_name;
            $branch->branch_address = $branch_address;
            $branch->description = $description;
            $branch->email = $email;
            $branch->mobile_no = $mobile_no;
            $branch->telephone_no = $telephone_no;

            if($branch->save()){

                    //log to audit trail
                    $new_data = $branch;
                    $action_taken = 'Update';
                    $description = 'Updated Branch '.$branch->branch_name;
                    AuditTrail::logAuditTrail( $action_taken , $description , $new_data, $old_data);
                    //end log
    
                return response()->json(['message' => 'Branch successfully updated', 'status' => 'success']);
            }
            
        }catch(Exception $e){

            return response()->json(['message' => 'Failed to update!'.$e, 'status' => 'error']);
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
}
