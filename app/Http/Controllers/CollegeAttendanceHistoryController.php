<?php

namespace App\Http\Controllers;

use App\Models\CollegeAttendanceHistory;
use App\Models\CutOff;
use App\Models\DeductionList;
use App\Models\PayslipHistory;
use App\Models\Salary;
use App\Models\StaffsTbl;
use App\Models\TimeSettings;
use App\Utilities\AccessRoute;
use App\Utilities\AuditTrail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class CollegeAttendanceHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {

            $StaffsTbl = StaffsTbl::whereIn('Department',['College','Graduate Studies']);

            return DataTables::of($StaffsTbl)
                ->addIndexColumn()
                ->addColumn('action', function ($StaffsTbl) {

                    $is_active = ($StaffsTbl->isActive == 1) ? 'deactivate' : 'activate';

                    //button update
                    $button = '<span class="actionCust editData" title="update branch college" data-id="' .$StaffsTbl->id. '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    $button .= '<span class="actionCust ' . $is_active . '"  title="' . $is_active . ' branch_college" data-id="' . md5($StaffsTbl->id) . '" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>';

                    return $button; // Return Button
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $cutoffs = CutOff::where('is_active',1)->orderByDesc('updated_at')->get();
        $permissions = AccessRoute::user_permissions(session('user')->id);
        return view('dashboard.college_attendance_histories',compact('permissions','cutoffs'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        //
        $data['getDataById'] = CollegeAttendanceHistory::where([['staff_id', $id],['cutoff_id',$request->cutoff]])->get();
        $data['staffDetails'] = StaffsTbl::where('id', $id)->first();
        $data['salaryDetails'] = Salary::where('staff_id', $id)->first();
        $data['cutoffDetails'] = CutOff::where('id',$request->cutoff)->first();
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $attendance_date = $request->attendance_date;
        $salary_amount = $request->salary_amount;
        $hours = $request->work_hours;
        $rate = $request->rate;
        $cutoff_id = $request->cutoff_id;
        $staff_id = $id;
        $total_rate = 0;
        $total_hours = 0;
        $special_allowance = 0;
        $canteen = 0;
        $tuition_fee = 0;
        $sss = 0;
        $cash_advance = 0;
        $others = 0;
        $required_time = 0;
        $basic_pay = 0;
        $absence = 0;
        // $deduction = DeductionList::select(DB::raw('(sss + tuition_fee + canteen + cash_advance + others) as total_deduction'))->where('staff_id',$staff_id)->first();
        $deduction = DeductionList::where('staff_id',$staff_id)->first();
        if(!empty($deduction)){
            $canteen = $deduction->canteen;
            $tuition_fee = $deduction->tuition_fee;
            $sss = $deduction->sss;
            $cash_advance = $deduction->cash_advance;
            $others = $deduction->others;

        }
        $salary = Salary::where('staff_id',$staff_id)->first();
        if(!empty($salary->special_allowance)){
            $special_allowance = $salary->special_allowance;
        }

        $time_setting = TimeSettings::where('staff_id',$staff_id)->first();
        if(!empty($time_setting)){
            $required_time = $time_setting->required_time;
            $basic_pay = $required_time * $salary_amount;
        }
        for($i = 0; $i < count($attendance_date);$i++){
     
            CollegeAttendanceHistory::updateOrCreate(
                ['staff_id' =>  $staff_id, 'cutoff_id' => $cutoff_id, 'attendance_date' => $attendance_date[$i]],
                ['hours' => $hours[$i],'rate' => $rate[$i]]
            );
            $total_rate += $rate[$i];
            $total_hours += $hours[$i];
        }

        $absence_time = $required_time - $total_hours;
        if($absence_time > 0){
            $absence = $absence_time * $salary_amount;
        }
        if($total_rate > $basic_pay){
           $over_rate = $total_rate - $basic_pay;
           $special_allowance += $over_rate;
        }
        $data = PayslipHistory::updateOrCreate(
            ['staff_cutoff' =>  $staff_id.$cutoff_id, 'staff_id' => $staff_id, 'cutoff_id' => $cutoff_id],
            ['basic_pay' => $basic_pay,
            'daily_rate' => $salary_amount,
            'required_days' => $required_time,
            'semi_monthly_pay' => $basic_pay,
            'special_allowance' => $special_allowance,
            'late_undertime' => 0,
            'absence' => $absence,
            'canteen' =>  $canteen,
            'tuition_fee' => $tuition_fee,
            'sss' => $sss,
            'cash_advance' => $cash_advance,
            'others' => $others,
            ]

        );

        //log to audit trail
        $new_data = $data;
        $action_taken = 'Add/Update';
        $description = 'Add/Update Attendance';
        AuditTrail::logAuditTrail( $action_taken , $description , $new_data);
        //end log
    }

}
