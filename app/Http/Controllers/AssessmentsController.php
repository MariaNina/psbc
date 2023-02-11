<?php

namespace App\Http\Controllers;

use App\Models\AssessmentsTbl;
use App\Models\BranchTbl;
use App\Models\CurriculumTbl;
use App\Models\DiscountsTbl;
use App\Models\EnrollmentTbl;
use App\Models\FeesTbl;
use App\Models\LevelsTbl;
use App\Models\PaymentHistoryTbl;
use App\Models\SubjectTbl;
use App\Utilities\AccessRoute;
use App\Utilities\Helpers;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class AssessmentsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param string $level
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    // public function index(Request $request, $level = 'All',$branch = 'All')
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $level = $request->level;
            $branch = $request->branch;
            $program = $request->program;


            $AssessTbl = AssessmentsTbl::select("assessments_tbls.*",
                "students_tbls.first_name",
                "students_tbls.middle_name",
                 "students_tbls.last_name",
                    "enrollment_tbls.application_no", "enrollment_tbls.subject_ids as subject_ids",
                    "branch_tbls.branch_name",
                    "program_majors_tbls.description")
                    ->withSum('payment_history as total_payment_amount', 'payment_amount')
                    ->leftJoin('students_tbls', 'assessments_tbls.student_id', '=', 'students_tbls.id')
                    ->leftJoin('enrollment_tbls', 'assessments_tbls.enrollment_id', '=', 'enrollment_tbls.id')
                    ->leftJoin('branch_tbls', 'enrollment_tbls.branch_id', '=', 'branch_tbls.id')
                    ->leftJoin('curriculum_tbls', 'enrollment_tbls.curriculum_id', '=', 'curriculum_tbls.id')
                    ->leftJoin('program_majors_tbls', 'curriculum_tbls.program_major_id', '=', 'program_majors_tbls.id');

            if($level != 'All') {
                $AssessTbl = $AssessTbl->with('enrollment.level')
                    ->whereHas('enrollment.level', function ($query) use ($level) {
                        $query->where('id', intval($level));
                    });
            }

            if($branch != 'All'){
                $AssessTbl = $AssessTbl->where('enrollment_tbls.branch_id',$branch);
            }

            if($program != 'All'){
                $AssessTbl = $AssessTbl->where(function($query) use ($program)  {
                    if (!empty($program)) {
                        $query->Where('curriculum_tbls.program_major_id', $program);
                    }
                });
            }
            return DataTables::of($AssessTbl)
                ->addIndexColumn()
                ->filterColumn('student_fullname', function($AssessTbl, $keyword) {
                    $AssessTbl->where('last_name', 'like', "%{$keyword}%")
                        ->orWhere('first_name', 'like', "%{$keyword}%")
                        ->orWhere('middle_name', 'like', "%{$keyword}%"); // you can implement any logic you want here
                })
                ->orderColumn('student_fullname', function ($query, $order) {
                    $query->orderBy('students_tbls.last_name', $order);
                })
                ->addColumn('student_fullname', function ($AssessTbl) {

                    $user_fullname = $AssessTbl->last_name.', '.$AssessTbl->first_name.' '.$AssessTbl->middle_name;
                    return $user_fullname; // Return Date
                })
                 ->addColumn('balance', function ($AssessTbl) {

                    $balance = ($AssessTbl->fee_amount - $AssessTbl->total_payment_amount);
                    $balance = number_format((float)$balance, 2, '.', '');
                    return '₱'.$balance; // Return balance
                })
                ->addColumn('action', function ($AssessTbl) {
                    $button = '';
                    // $is_active = ($AssessTbl->is_active == TRUE) ? 'deactivate' :'activate';
                    if ($AssessTbl->status != 'rejected') {
                        //button update

                        if ($AssessTbl->fees != NULL) {
                            $button .= '<span class="actionCust payFee" title="pay" data-id="' . $AssessTbl->id . '"><a class="edit-btn"><i class="fas fa-money-bill"></i></a></span>';

                            $button .= '<br/><br/><span class="actionCust editData" title="update assessment" data-id="' . $AssessTbl->id . '"><a class="edit-btn"><i class="fas fa-edit"></i></a></span>';
                        }else{
                            $button .= '<span class="actionCust editData" title="update assessment" data-id="' . $AssessTbl->id . '"><a class="edit-btn"><i class="fas fa-edit"></i></a></span>';
                        }
                    }

                    //button deactivate activate
                    //   $button .='<span class="actionCust '.$is_active.'"  title="'.$is_active.' branch" data-id="'.md5($AssessTbl->id).'" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>' ;

                    return $button; // Return Button
                })
                ->addColumn('total_units', function ($AssessTbl) {
                    $units = SubjectTbl::select(DB::raw('SUM(lect_unit) as total'),
                        DB::raw('SUM(lab_unit) as total2'))
                        ->whereIn('id', json_decode($AssessTbl->subject_ids))->get();
                    return $units[0]->total + $units[0]->total2;
                })
                ->rawColumns(['total_units', 'balance', 'action','student_fullname']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);
        }

        $data['title'] = 'Assessments';
        $data['permissions'] = AccessRoute::user_permissions(session('user')->id);
        $school_year_id = Helpers::currentSchoolYear('id');
        $data['levels'] = LevelsTbl::all();
        $data['branches'] = BranchTbl::all();
        $data['applications'] = EnrollmentTbl::select('id', 'application_no')->where('school_year_id', $school_year_id)
            ->where('is_approved', 1)->get();

        $res = null;

        $res = AssessmentsTbl::withSum('payment_history', 'payment_amount')
            ->addSelect([
                'total_balance' => PaymentHistoryTbl::whereColumn('assessments_id', 'assessments_tbls.id')
                    ->selectRaw('(assessments_tbls.fee_amount - sum(payment_amount)) as total_balance')
            ])
            ->where('is_active', 1)
            ->get();

        $data['balance'] = 0;
        foreach ($res as $result) {
            if (is_null($result->payment_history_sum_payment_amount)) {
                $data['balance'] = $data['balance'] + $result->fee_amount;
            } else {
                $data['balance'] = $data['balance'] + $result->total_balance; // Total Utang
            }
        }

        return view('dashboard.assessments', $data);
    }

    public function getTotalBalances(Request $request)
    {
        $level = $request->level;
        $branch = $request->branch;
        $program = $request->program;

        $res = null;
        // Filtered by Grade level
        if ($level != 'All') {
            $res = AssessmentsTbl::with(['enrollment.level'])
                ->whereHas('enrollment.level', function ($query) use ($level) {
                    $query->where('id', intval($level));
                })
                ->addSelect([
                    'total_balance' => PaymentHistoryTbl::whereColumn('assessments_id', 'assessments_tbls.id')
                        ->selectRaw('(assessments_tbls.fee_amount - sum(payment_amount)) as total_balance')
                ])
                ->withSum('payment_history', 'payment_amount')
                ->where('is_active', 1);
                // ->get();
        } else {
            $res = AssessmentsTbl::withSum('payment_history', 'payment_amount')
                ->addSelect([
                    'total_balance' => PaymentHistoryTbl::whereColumn('assessments_id', 'assessments_tbls.id')
                        ->selectRaw('(assessments_tbls.fee_amount - sum(payment_amount)) as total_balance')
                ])
                ->where('is_active', 1);
                // ->get();
        }
        if ($branch != 'All') {
            $res =  $res->with(['enrollment.branch'])
            ->whereHas('enrollment.branch', function ($query) use ($branch) {
                $query->where('id', intval($branch));
            });
            // ->get();
        }

         if ($program != 'All') {
            $res =  $res->with(['enrollment.program_majors'])
            ->whereHas('enrollment.program_majors', function ($query) use ($program) {
                $query->where('program_major_id', intval($program));
            });
            // ->get();
        }

        $balance = 0;
        foreach ($res->get() as $result) {

            if (is_null($result->payment_history_sum_payment_amount)) {
                $balance = $balance + $result->fee_amount;
            } else {
                $balance = $balance + $result->total_balance; // Total Utang
            }

        }
        return response()->json(['balance' => $balance]);

    }


    public function getPrograms(Request $request)
    {
        $level = $request->level;

        $programs = CurriculumTbl::select("program_majors_tbls.id","program_majors_tbls.description")->where('level_id',$level)
        ->join('program_majors_tbls','curriculum_tbls.program_major_id','=','program_majors_tbls.id')->distinct('program_majors_tbls.id')->get();
        return response()->json(['programs' => $programs]);

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
        $assessment_id = $id;
        $student_details = AssessmentsTbl::select("assessments_tbls.student_id",
            "assessments_tbls.student_department",
            "assessments_tbls.enrollment_id",
            "assessments_tbls.fees",
            "assessments_tbls.other_fees",
            "assessments_tbls.discounts",
            "enrollment_tbls.application_no",
            "enrollment_tbls.subject_ids",
            DB::raw("CONCAT(students_tbls.first_name,' ',students_tbls.middle_name,' ',students_tbls.last_name) AS studentName"),
            DB::raw("CONCAT(programs_tbls.program_name,' ',majors_tbls.major_name) AS programMajor"))
            ->leftJoin('students_tbls', 'assessments_tbls.student_id', '=', 'students_tbls.id')
            ->leftJoin('enrollment_tbls', 'assessments_tbls.enrollment_id', '=', 'enrollment_tbls.id')
            ->leftJoin('curriculum_tbls', 'enrollment_tbls.curriculum_id', '=', 'curriculum_tbls.id')
            ->leftJoin('program_majors_tbls', 'curriculum_tbls.program_major_id', '=', 'program_majors_tbls.id')
            ->leftJoin('programs_tbls', 'program_majors_tbls.program_id', '=', 'programs_tbls.id')
            ->leftJoin('majors_tbls', 'program_majors_tbls.major_id', '=', 'majors_tbls.id')
            ->where('assessments_tbls.id', $assessment_id)->first();
        // ->where(DB::raw('md5(assessments_tbls.id)'), $assessment_id)->first();
        // $type = "Discountable Fee";
        $dept = $student_details->student_department;
        $sub_ids = json_decode($student_details->subject_ids);

        $data['lect_units'] = SubjectTbl::select(DB::raw('SUM(lect_unit) AS total_lect_unit'))
            ->whereIn('id', $sub_ids)->get();

        $data['lab_units'] = SubjectTbl::select(DB::raw('SUM(lab_unit) AS total_lab_unit'))
            ->whereIn('id', $sub_ids)->get();

        $data['fees'] = FeesTbl::select('fees_tbls.*')
            ->where('fee_type', "Discountable Fee")
            ->where('student_department', $dept)
            ->where('is_active', 1)->get();

        $data['lec_amount'] = FeesTbl::select('fee_amount')
            ->where('fee_type', "Lec Unit")
            ->where('student_department', $dept)
            ->where('is_active', 1)->first();

        $data['lab_amount'] = FeesTbl::select('fee_amount')
            ->where('fee_type', "Lab Unit")
            ->where('student_department', $dept)
            ->where('is_active', 1)->first();

        $data['other_fees'] = FeesTbl::select('fees_tbls.*')
            ->where('fee_type', "Others")
            ->where('student_department', $dept)
            ->where('is_active', 1)->get();
        $data['student_details'] = $student_details;

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

        $data = AssessmentsTbl::find($id);

        $fee_types = $request->fee_type;
        $fee_amount = $request->fee_amount;
        $other_fee_types = $request->other_fee_type;
        $other_fee_amount = $request->other_fee_amount;
        $discount_types = $request->discount_type;
        $discount_amounts = $request->discount_amount;

        $total_fees = 0;
        $total_other_fees = 0;
        $total_discount = 0;

        if (!empty($fee_types)) {
            $fees = array();
            $i = 0;
            foreach ($fee_types as $fee_type):

                $fees[$i]['fee_type'] = $fee_types[$i];
                $fees[$i]['fee_amount'] = $fee_amount[$i];
                $total_fees += $fee_amount[$i]; // add to total fees
                $i++;
            endforeach;
            $data->fees = json_encode($fees);
        } else {
            $data->fees = NULL;
        }

        if (!empty($other_fee_types)) {
            $other_fees = array();
            $n = 0;
            foreach ($other_fee_types as $fee_type):
                $other_fees[$n]['other_fee_types'] = $other_fee_types[$n];
                $other_fees[$n]['other_fee_amount'] = $other_fee_amount[$n];
                $total_other_fees += $other_fee_amount[$n]; // add to total other_fees
                $n++;
            endforeach;
            $data->other_fees = json_encode($other_fees);
        } else {
            $data->other_fees = NULL;
        }
        if (!empty($discount_types)) {
            $the_discount = array();
            $i = 0;
            foreach ($discount_types as $discount_type):
                $the_discount[$i]['discount_type'] = $discount_types[$i];
                $the_discount[$i]['discount_amount'] = $discount_amounts[$i];
                $total_discount += $discount_amounts[$i];
                $i++;
            endforeach;
            $data->discounts = json_encode($the_discount);

            $total_fees = $total_fees - $total_discount;
        } else {
            $data->discounts = NULL;
        }
        $data->fee_amount = ($total_fees + $total_other_fees);
        $data->student_id = $request->student_id;
        $data->status = 'pending';
        $data->is_active = 1;
        $data->save();
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

    public function getStudentDetailsByEnrollmentId(Request $request)
    {
        $app_no = $request->app_no;
        $student_details = EnrollmentTbl::select("enrollment_tbls.student_id",
            "enrollment_tbls.student_department",
            DB::raw("CONCAT(students_tbls.first_name,' ',students_tbls.middle_name,' ',students_tbls.last_name) AS studentName"),
            DB::raw("CONCAT(programs_tbls.program_name,' ',majors_tbls.major_name) AS programMajor"))
            ->leftJoin('students_tbls', 'enrollment_tbls.student_id', '=', 'students_tbls.id')
            ->leftJoin('curriculum_tbls', 'enrollment_tbls.curriculum_id', '=', 'curriculum_tbls.id')
            ->leftJoin('program_majors_tbls', 'curriculum_tbls.program_major_id', '=', 'program_majors_tbls.id')
            ->leftJoin('programs_tbls', 'program_majors_tbls.program_id', '=', 'programs_tbls.id')
            ->leftJoin('majors_tbls', 'program_majors_tbls.major_id', '=', 'majors_tbls.id')
            ->where('enrollment_tbls.id', $app_no)->first();

        return $student_details;
    }

    public function getFeesByDepartment(Request $request)
    {
        $type = $request->assessment_type;
        $dept = $request->student_department;

        $data['fees'] = FeesTbl::select('fees_tbls.*')
            ->where('fee_type', $type)
            ->where('student_department', $dept)
            ->where('is_active', 1)->get();

        return $data;
    }

    public function getFeeAmount(Request $request)
    {
        $dept = $request->student_department;
        $val = $request->val;

        $data = FeesTbl::select('fees_tbls.fee_amount')
            ->where('fee_name', $val)
            ->where('student_department', $dept)
            ->where('is_active', 1)->first();

        return $data;
    }

    public function getDiscountsByDepartment(Request $request)
    {
        $dept = $request->student_department;

        $data['discs'] = DiscountsTbl::select('discounts_tbls.*')
            ->where('student_department', $dept)
            ->where('is_active', 1)->get();

        return $data;
    }

    public function getDiscountAmount(Request $request)
    {
        $dept = $request->student_department;
        $val = $request->val;

        $data = DiscountsTbl::select('discounts_tbls.amount', 'discounts_tbls.discount_type')
            ->where('discount_name', $val)
            ->where('student_department', $dept)
            ->where('is_active', 1)->first();

        return $data;
    }
}
