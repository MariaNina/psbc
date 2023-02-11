<?php

namespace App\Http\Controllers;

use App\Models\CollegeAttendanceHistory;
use App\Models\CutOff;
use App\Models\Salary;
use App\Models\StaffsTbl;
use App\Utilities\AccessRoute;
use Illuminate\Http\Request;

class CollegeAttendanceView extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // 
        $cutoffs = CutOff::where('is_active',1)->orderByDesc('updated_at')->get();
        $permissions = AccessRoute::user_permissions(session('user')->id);
        return view('dashboard.college_attendance_view',compact('permissions','cutoffs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $id = session('user')->staff_id;
        $staffDetails = StaffsTbl::where('id', $id)->first();
        if(in_array($staffDetails->Department,['College','Graduate Studies'])){
            $data['getDataById'] = CollegeAttendanceHistory::where([['staff_id', $id],['cutoff_id',$request->cutoff]])->get();
            $data['staffDetails'] = $staffDetails;
            $data['salaryDetails'] = Salary::where('staff_id', $id)->first();
            $data['cutoffDetails'] = CutOff::where('id',$request->cutoff)->first();
            return $data;
        }
    }


}

