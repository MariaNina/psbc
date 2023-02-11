<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSummaryView;
use App\Models\CutOff;
use App\Models\DeductionList;
use App\Models\HolidaysSettings;
use App\Models\PayslipHistory;
use App\Models\Salary;
use App\Models\StaffsTbl;
use App\Utilities\AccessRoute;
use Carbon\Carbon;
use DateInterval;
use DateTimeZone;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables;

class SalarySettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('authenticated')->except('index');

    }

    public function index(Request $request)
    {
        //
        if ($request->ajax()) {

            $Salary =
                StaffsTbl::select(
                    DB::raw("CONCAT(staffs_tbls.last_name,' ',staffs_tbls.first_name) as staff_name"),
                    "salaries.id as salary_id",
                    "salaries.salary_amount",
                    "salaries.salary_classification",
                    "salaries.special_allowance",
                    "salaries.employment_status",
                    "salaries.encoded_by",
                    "salaries.is_active")
                    ->leftJoin('salaries', 'salaries.staff_id', '=', 'staffs_tbls.id')
                    ->where('salaries.salary_amount','!=',null);

            return Datatables::of($Salary)
                ->addIndexColumn()
                ->addColumn('action', function ($Salary) {

                    $is_active = ($Salary->is_active == TRUE) ? 'deactivate' : 'activate';

                    //button update
                    $button = '<span class="actionCust editData" title="update salary" data-id="' . md5($Salary->salary_id) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    $button .= '<span class="actionCust ' . $is_active . '"  title="' . $is_active . ' curriculum" data-id="' . md5($Salary->salary_id) . '" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>';


                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);
        }
        $permissions = AccessRoute::user_permissions(session('user')->id);
        return view('dashboard.staff.salary_settings',compact('permissions'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        //
        $data['getDataById'] = Salary::where(DB::raw('md5(id)'), $id)->first();
        $data['employee'] = StaffsTbl::where('id', $data['getDataById']->staff_id)->first();

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
        $nowInManila = Carbon::now(new DateTimeZone('Asia/Manila'));
        $update = Salary::where(DB::raw('md5(id)'), $id);
        $data['salary_amount'] = ($request->amount_salary != null) ? $request->amount_salary : 0 ;
        $data['salary_classification'] =$request->salary_class;
        $data['employment_status'] =$request->employment_status;
        $data['special_allowance'] = ($request->special_allowance != null) ? $request->special_allowance : 0 ;
        $data['encoded_by'] = session('user')->full_name;
        $data['updated_at'] = $nowInManila;
        $update->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        //
        $nowInManila = Carbon::now(new DateTimeZone('Asia/Manila'));
        $deactivate = Salary::where(DB::raw('md5(id)'), $id);
        $data['is_active'] = $request->is_active;
        $data['encoded_by'] = session('user')->full_name;
        $data['updated_at'] = $nowInManila;
        $deactivate->update($data);
    }

    public function getPayslip(){
        $data['permissions'] = AccessRoute::user_permissions(session('user')->id);
        if(isset(session('user')->staff_id)){
            $data['cutOff'] = CutOff::all()->sortByDesc('pay_day');
            $data['staffs'] = StaffsTbl::all()->sortBy('last_name');
            return view('dashboard.payslipAll',$data);
        }
    }
    public function getAllPayslip(Request $request){
        $data['permissions'] = AccessRoute::user_permissions(session('user')->id);
        $data['Staff'] = StaffsTbl::select('staffs_tbls.*')->orderBy('bio_id')
        ->where('Department','!=','College')
        ->get();
        $data['cutoff'] = CutOff::where('id',$request->date_id)->first();
        
        //count Holydays
        $data['holidays'] = HolidaysSettings::all()->whereBetween('holiday_date',[$data['cutoff']->start_date,$data['cutoff']->end_date])
            ->where('is_active',1)->count();
        //get difference
        $startDate = strtotime($data['cutoff']->start_date);
        $endDate = strtotime($data['cutoff']->end_date);
        $date1 = date('Y-m-d D',$startDate);
        $date2 = date('Y-m-d D',$endDate);
        $date1 = date_create($date1);
        $date2 = date_create($date2);
        $data['count_cutoff_date'] = date_diff($date1,$date2,True);
        $data['count_cutoff_date']->d+=1;
        $data['count_cutoff_date']->days =$data['count_cutoff_date']->d;
        $sundays = intval($data['count_cutoff_date']->days  / 7) + ($date1->format('N') + $data['count_cutoff_date']->days  % 7 >= 7);
        $sats = intval($data['count_cutoff_date']->days  / 7) + ($date1->format('N') + $data['count_cutoff_date']->days  % 7 >= 6);
        $data['count_cutoff_date']->weekdays =$data['count_cutoff_date']->days - ($sundays+$sats);
        $i =0;
        foreach($data['Staff'] as $employee){
            $data['salary'][] = Salary::where('staff_id',$employee->id)
                ->where('salary_classification','daily')
                ->where('is_active',1)->first();
                if($data['salary'][$i]===null){
                // $data['salary'][$i] = json_decode('{"staff_id":"'.$employee->id.'","salary_amount":0,
                //     "special_allowance":0,
                // }');
                $data['salary'][$i] = json_decode('{"staff_id":'.$employee->id.',"salary_amount":0,"special_allowance":0}');
                
                }
            $data['attendance'][] = AttendanceSummaryView::all('bio_id','punch_date','restday')
                ->where('bio_id',$employee->bio_id)->where('restday','!=','Rest Day')
                ->whereBetween('punch_date',[$data['cutoff']->start_date,$data['cutoff']->end_date])
                ->count();
            $data['deductions'][] = DeductionList::where('staff_id',$employee->id)->first();
            if($data['deductions'][$i]===null){
                $data['deductions'][$i] = json_decode('{"staff_id":"'.$employee->id.'","sss":"0",
                    "tuition_fee":0,"canteen":0,"cash_advance":0,"others":0,"late_undertime":0
                }');
            }
            //save data to payslip history
            try{
              
            $PayslipHistory = new PayslipHistory();
            $PayslipHistory->staff_cutoff = $employee->id. $data['cutoff']->id;
            $PayslipHistory->staff_id = $employee->id;
            $PayslipHistory->cutoff_id = $data['cutoff']->id;
            $PayslipHistory->basic_pay =  $data['count_cutoff_date']->weekdays *$data['salary'][$i]->salary_amount;
            $PayslipHistory->daily_rate = $data['salary'][$i]->salary_amount;
            $PayslipHistory->required_days = $data['count_cutoff_date']->weekdays;
            $PayslipHistory->semi_monthly_pay =$data['count_cutoff_date']->weekdays *$data['salary'][$i]->salary_amount;
            $PayslipHistory->special_allowance = $data['salary'][$i]->special_allowance;
            $PayslipHistory->absence =($data['count_cutoff_date']->weekdays - $data['attendance'][$i] - $data['holidays'])*$PayslipHistory->daily_rate;
            if($data['deductions'][$i]!==null){
            $PayslipHistory->canteen = $data['deductions'][$i]->canteen;
            $PayslipHistory->tuition_fee = $data['deductions'][$i]->tuition_fee;
            $PayslipHistory->sss = $data['deductions'][$i]->sss;
            $PayslipHistory->cash_advance = $data['deductions'][$i]->cash_advance;
            $PayslipHistory->others = $data['deductions'][$i]->others;
            $PayslipHistory->late_undertime = $data['deductions'][$i]->late_undertime;
            }
            else{
            $PayslipHistory->canteen = 0;
            $PayslipHistory->tuition_fee = 0;
            $PayslipHistory->sss = 0;
            $PayslipHistory->cash_advance = 0;
            $PayslipHistory->others = 0;
            $PayslipHistory->late_undertime = 0;
            }
            $PayslipHistory->saveOrFail();
              

            }catch(Exception  $e){

            }
            $i++;
        }
        return $data;
    }
    public function getAllCollegePayslip(Request $request){
        
        $data['payslipHistory'] = PayslipHistory::select('payslip_histories.*','staffs_tbls.bio_id','staffs_tbls.first_name','staffs_tbls.last_name','staffs_tbls.Department','staffs_tbls.position')
        ->leftJoin('staffs_tbls','staffs_tbls.id','=','payslip_histories.staff_id')
        ->where('payslip_histories.cutoff_id',$request->date_id)
        ->whereIn('staffs_tbls.Department',['College','Graduate Studies'])
        ->get();
        $data['cutoff'] = CutOff::where('id',$request->date_id)->first();
        //count Holydays
        $data['holidays'] = HolidaysSettings::all()->whereBetween('holiday_date',[$data['cutoff']->start_date,$data['cutoff']->end_date])
            ->where('is_active',1)->count();
        return $data;
    }

    public function payslipSummary(Request $request){
        if ($request->ajax()) {
          
           $PayslipHistory = PayslipHistory::select('payslip_histories.*',
        DB::raw("CONCAT(staffs_tbls.last_name, ', ',staffs_tbls.first_name) as employee_name"),
        'cut_offs.id as cutoff_id','cut_offs.pay_day as payday')
        ->join('staffs_tbls', 'staffs_tbls.id', '=', 'payslip_histories.staff_id')
        ->join('cut_offs', 'cut_offs.id', '=', 'payslip_histories.cutoff_id')
        ->where('cut_offs.pay_day',explode(',',$request->payday))
        ->orderBy('payday')->orderBy('bio_id')->get();

        return DataTables::of($PayslipHistory)
        ->addIndexColumn()
        ->addColumn('gross_pay', function ($PayslipHistory) {
            return $PayslipHistory->semi_monthly_pay+$PayslipHistory->special_allowance;
        })
        ->addColumn('total_deduction', function($PayslipHistory){
            return $PayslipHistory->late_undertime+$PayslipHistory->absence+$PayslipHistory->canteen+$PayslipHistory->tuition_fee+$PayslipHistory->sss+$PayslipHistory->cash_advance+$PayslipHistory->others;

        })
        ->addColumn('net_pay', function($PayslipHistory){
            $total_deduction = $PayslipHistory->late_undertime+$PayslipHistory->absence+$PayslipHistory->canteen+$PayslipHistory->tuition_fee+$PayslipHistory->sss+$PayslipHistory->cash_advance+$PayslipHistory->others;
            $net_pay = $PayslipHistory->semi_monthly_pay - $total_deduction;
            return $net_pay;
            
        })
        ->addColumn('signature', function($PayslipHistory){
            return "";
        })
        ->rawColumns(['gross_pay'])
        ->make(true);
            // ->addIndexColumn()
            //     ->addColumn('action', function ($PayslipHistory) {

          
            //     })
            //     ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
            //     ->make(true);
        }
        $data['cutOff'] = CutOff::all()->sortByDesc('pay_day');
        $data['permissions'] = AccessRoute::user_permissions(session('user')->id);
        return view('dashboard.payslipSummary',$data);
    }
  
      public function viewPayslip()
    {
        $data['permissions'] = AccessRoute::user_permissions(session('user')->id);
        if (isset(session('user')->staff_id)) {
            $data['cutOff'] = CutOff::all()->sortByDesc('pay_day');
        }

        return view('dashboard.view_payslip', $data);
    }

    public function getSinglePayslip(Request $request)
    {
        $id = session('user')->staff_id;

        $user = StaffsTbl::where('id', $id)
            ->first(['id', 'user_id', 'first_name', 'middle_name', 'last_name', 'extension_name', 'position', 'Department', 'bio_id']);

        $payslipHistory = PayslipHistory::where('staff_id', $id)
            ->join('cut_offs', 'payslip_histories.cutoff_id', '=', 'cut_offs.id')
            ->where('cutoff_id', $request->cutOffDate)
            ->first(['payslip_histories.*', 'cut_offs.*']);

        return response()->json(['user' => $user,
            'payslip' => $payslipHistory,
            'now' => now('Asia/Manila')->toDateString()]);
    }

    public function viewCollegePayslip()
    {
        # code...
        if (isset(session('user')->staff_id)) {
            $data['cutOff'] = CutOff::all()->sortByDesc('pay_day');
            $data['staffs'] = StaffsTbl::all()->whereIn('Department',['College','Graduate Studies'])->sortBy('last_name');
        }
        $data['permissions'] = AccessRoute::user_permissions(session('user')->id);
        return view('dashboard.payslipCollege',$data);
    }


}
