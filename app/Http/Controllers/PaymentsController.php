<?php

namespace App\Http\Controllers;

use App\Mail\UserDetailsMail;
use App\Models\AssessmentsTbl;
use App\Models\BranchTbl;
use App\Models\EnrollmentTbl;
use App\Models\Grade;
use App\Models\LevelsTbl;
use App\Models\PaymentHistoryTbl;
use App\Models\StudentsTbl;
use App\Utilities\AccessRoute;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UsersTbl;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\DataTables;

class PaymentsController extends Controller
{
    public function index(Request $request)
    {
        //
        $user_id = session('user')->id;

        if ($request->ajax()) {

            $PaymentTbl = PaymentHistoryTbl::select("payment_history_tbls.*"
                , "users_tbls.full_name as full_name", 'branch_tbls.branch_name',
                'assessments_tbls.student_department as department')
                ->leftJoin('students_tbls', 'payment_history_tbls.student_id', '=', 'students_tbls.id')
                ->leftJoin('branch_tbls', 'payment_history_tbls.branch_id', '=', 'branch_tbls.id')
                ->leftJoin('assessments_tbls', 'payment_history_tbls.assessments_id', '=', 'assessments_tbls.id')
                ->leftJoin('users_tbls', 'students_tbls.user_id', '=', 'users_tbls.id')
                ->latest('created_at');

            if (session('user')->role == "Student") {
                $PaymentTbl->where('users_tbls.id', $user_id);
            }
            return DataTables::of($PaymentTbl)
                //->setRowId('payment_history_tbls.id as id')
                ->addIndexColumn()
                ->addColumn('action', function ($PaymentTbl) {

                    //button update
                    if (session('user')->role != "Student") {
                        $button = '<span class="actionCust deleteData" title="delete payment" data-id="' . $PaymentTbl->id . '"><a class="delete-btn"><i class="fa fa-trash"></i></a></span>';


                        return $button; // Return Button
                    } else {
                        $button = 'No Action Needed';


                        return $button; // Return Button
                    }
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);
        }
        if (session('user')->role == "Student") {
            $data['total_fee'] = AssessmentsTbl::select("id", "fee_amount", "student_id")->where('student_id', session('user')->student_id)->first();
            if ($data['total_fee'] != null) {
                $data['total_paid'] = PaymentHistoryTbl::select(DB::raw("SUM(payment_amount) as total_payment"))
                    ->where('is_approved', 1)
                    ->where('assessments_id', $data['total_fee']->id)->first();
                $data['balance'] = html_entity_decode("&#8369;") . number_format($data['total_fee']->fee_amount - $data['total_paid']->total_payment, 0, ".", ",") . ".00";
            } else {
                $data['balance'] = "No Assessment Record";
            }

        }

        $data['title'] = 'Payments';
        $data['permissions'] = AccessRoute::user_permissions($user_id);


        $totalIncome = PaymentHistoryTbl::select(DB::raw('@rownum :=@rownum+1 as rowNum'), "payment_history_tbls.*"
            , "users_tbls.full_name as full_name", 'branch_tbls.branch_name',
            'assessments_tbls.student_department as department')
            ->leftJoin('students_tbls', 'payment_history_tbls.student_id', '=', 'students_tbls.id')
            ->leftJoin('branch_tbls', 'payment_history_tbls.branch_id', '=', 'branch_tbls.id')
            ->leftJoin('assessments_tbls', 'payment_history_tbls.assessments_id', '=', 'assessments_tbls.id')
            ->leftJoin('users_tbls', 'students_tbls.user_id', '=', 'users_tbls.id')
            ->latest('created_at')
            ->sum('payment_amount');

        // $totalIncome = PaymentHistoryTbl::select(DB::raw('@rownum :=@rownum+1 as rowNum'), "payment_history_tbls.*"
        //     , "users_tbls.full_name as full_name", 'branch_tbls.branch_name',
        //     'assessments_tbls.student_department as department')
        //     ->leftJoin('students_tbls', 'payment_history_tbls.student_id', '=', 'students_tbls.id')
        //     ->leftJoin('branch_tbls', 'payment_history_tbls.branch_id', '=', 'branch_tbls.id')
        //     ->leftJoin('assessments_tbls', 'payment_history_tbls.assessments_id', '=', 'assessments_tbls.id')
        //     ->leftJoin('users_tbls', 'students_tbls.user_id', '=', 'users_tbls.id')
        //     ->when($date, function ($query, $date) {
        //         $query->whereDate('payment_history_tbls.created_at', $date);
        //     })
        //     ->when($level, function ($query, $level) {
        //         $query->whereHas('assessment.enrollment', function ($query) use ($level) {
        //             $query->where('level_id', $level);
        //         });
        //     })
        //     ->latest('updated_at')
        //     ->sum('payment_amount');

        $data['totalIncome'] = number_format(($totalIncome), 2, '.', ',');

        // $school_year_id = Helpers::currentSchoolYear('id');
        // $data['levels'] = LevelsTbl::all();
        // $data['applications'] = EnrollmentTbl::select('id','application_no')->where('school_year_id', $school_year_id)
        // ->where('is_approved', 1)->get();

        $data['levels'] = LevelsTbl::all();

        return view('dashboard.payments', $data);
    }

    public function filterPayments(Request $request, $dateToFilter = 'none', $level = '')
    {
        //
        $user_id = session('user')->id;

        $date = null;
        $levelFilter = null;

        if ($dateToFilter !== 'none') {
            $date = Carbon::parse($dateToFilter)->toDateString();
        }

        if ($level != '') {
            $levelFilter = $level;
        }


        if ($request->ajax()) {

            $PaymentTbl = PaymentHistoryTbl::select("payment_history_tbls.*"
                , "users_tbls.full_name as full_name", 'branch_tbls.branch_name',
                'assessments_tbls.student_department as department')
                ->leftJoin('students_tbls', 'payment_history_tbls.student_id', '=', 'students_tbls.id')
                ->leftJoin('branch_tbls', 'payment_history_tbls.branch_id', '=', 'branch_tbls.id')
                ->leftJoin('assessments_tbls', 'payment_history_tbls.assessments_id', '=', 'assessments_tbls.id')
                ->leftJoin('users_tbls', 'students_tbls.user_id', '=', 'users_tbls.id')
                ->when($date, function ($query, $date) {
                    $query->whereDate('payment_history_tbls.created_at', $date);
                })
                ->when($levelFilter, function ($query, $levelFilter) {
                    $query->whereHas('assessment.enrollment', function ($query) use ($levelFilter) {
                        $query->where('enrollment_tbls.level_id', $levelFilter);
                    });
                })
                ->latest('payment_history_tbls.created_at');

            if (session('user')->role == "Student") {
                $PaymentTbl->where('users_tbls.id', $user_id);
            }
            return DataTables::of($PaymentTbl)
                ->addIndexColumn()
                //->setRowId('payment_history_tbls.id as id')
                ->addColumn('action', function ($PaymentTbl) {

                    //button update
                    if (session('user')->role != "Student") {
                        $button = '<span class="actionCust deleteData" title="delete payment" data-id="' . $PaymentTbl->id . '"><a class="delete-btn"><i class="fa fa-trash"></i></a></span>';


                        return $button; // Return Button
                    } else {
                        $button = 'No Action Needed';


                        return $button; // Return Button
                    }
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);
        }

        if (session('user')->role == "Student") {
            $data['total_fee'] = AssessmentsTbl::select("id", "fee_amount", "student_id")->where('student_id', session('user')->student_id)->first();
            if ($data['total_fee'] != null) {
                $data['total_paid'] = PaymentHistoryTbl::select(DB::raw("SUM(payment_amount) as total_payment"))
                    ->where('is_approved', 1)
                    ->where('assessments_id', $data['total_fee']->id)->first();
                $data['balance'] = html_entity_decode("&#8369;") . number_format($data['total_fee']->fee_amount - $data['total_paid']->total_payment, 0, ".", ",") . ".00";
            } else {
                $data['balance'] = "No Assessment Record";
            }

        }

        $data['title'] = 'Payments';
        $data['permissions'] = AccessRoute::user_permissions($user_id);

        /*
        $totalIncome = PaymentHistoryTbl::select(DB::raw('@rownum :=@rownum+1 as rowNum'), "payment_history_tbls.*"
            , "users_tbls.full_name as full_name", 'branch_tbls.branch_name',
            'assessments_tbls.student_department as department')
            ->leftJoin('students_tbls', 'payment_history_tbls.student_id', '=', 'students_tbls.id')
            ->leftJoin('branch_tbls', 'payment_history_tbls.branch_id', '=', 'branch_tbls.id')
            ->leftJoin('assessments_tbls', 'payment_history_tbls.assessments_id', '=', 'assessments_tbls.id')
            ->leftJoin('users_tbls', 'students_tbls.user_id', '=', 'users_tbls.id')
            ->latest('created_at')
            ->sum('payment_amount');*/

        $totalIncome = PaymentHistoryTbl::select("payment_history_tbls.*"
            , "users_tbls.full_name as full_name", 'branch_tbls.branch_name',
            'assessments_tbls.student_department as department')
            ->leftJoin('students_tbls', 'payment_history_tbls.student_id', '=', 'students_tbls.id')
            ->leftJoin('branch_tbls', 'payment_history_tbls.branch_id', '=', 'branch_tbls.id')
            ->leftJoin('assessments_tbls', 'payment_history_tbls.assessments_id', '=', 'assessments_tbls.id')
            ->leftJoin('users_tbls', 'students_tbls.user_id', '=', 'users_tbls.id')
            ->when($date, function ($query, $date) {
                $query->whereDate('payment_history_tbls.created_at', $date);
            })
            ->when($level, function ($query, $level) {
                $query->whereHas('assessment.enrollment', function ($query) use ($level) {
                    $query->where('level_id', $level);
                });
            })
            ->latest('updated_at')
            ->sum('payment_amount');

        $data['totalIncome'] = number_format(($totalIncome), 2, '.', ',');

        // $school_year_id = Helpers::currentSchoolYear('id');
        // $data['levels'] = LevelsTbl::all();
        // $data['applications'] = EnrollmentTbl::select('id','application_no')->where('school_year_id', $school_year_id)
        // ->where('is_approved', 1)->get();

        $data['levels'] = LevelsTbl::all();

        return view('dashboard.payments', $data);
    }

    public function getTotalIncome(Request $request)
    {
        $level = $request->input('level');
        $date = $request->input('date');

        $totalIncome = PaymentHistoryTbl::select("payment_history_tbls.*"
            , "users_tbls.full_name as full_name", 'branch_tbls.branch_name',
            'assessments_tbls.student_department as department')
            ->leftJoin('students_tbls', 'payment_history_tbls.student_id', '=', 'students_tbls.id')
            ->leftJoin('branch_tbls', 'payment_history_tbls.branch_id', '=', 'branch_tbls.id')
            ->leftJoin('assessments_tbls', 'payment_history_tbls.assessments_id', '=', 'assessments_tbls.id')
            ->leftJoin('users_tbls', 'students_tbls.user_id', '=', 'users_tbls.id')
            ->when($date, function ($query, $date) {
                $query->whereDate('payment_history_tbls.created_at', $date);
            })
            ->when($level, function ($query, $level) {
                $query->whereHas('assessment.enrollment', function ($query) use ($level) {
                    $query->where('enrollment_tbls.level_id', $level);
                });
            })
            ->latest('updated_at')
            ->sum('payment_amount');


        /*
          $totalIncome = PaymentHistoryTbl::select(DB::raw('@rownum :=@rownum+1 as rowNum'), "payment_history_tbls.*"
                , "users_tbls.full_name as full_name", 'branch_tbls.branch_name',
                'assessments_tbls.student_department as department')
                ->leftJoin('students_tbls', 'payment_history_tbls.student_id', '=', 'students_tbls.id')
                ->leftJoin('branch_tbls', 'payment_history_tbls.branch_id', '=', 'branch_tbls.id')
                ->leftJoin('assessments_tbls', 'payment_history_tbls.assessments_id', '=', 'assessments_tbls.id')
                ->leftJoin('users_tbls', 'students_tbls.user_id', '=', 'users_tbls.id')
                ->latest('updated_at')
                ->sum('payment_amount');
        */
        $totalIncome = number_format(($totalIncome), 2, '.', ',');

        return response(['totalIncome' => $totalIncome, 'date' => $date]);
    }


    public function edit($id)
    {
        //
        $assessment_id = $id;
        $data['assessments_details'] = AssessmentsTbl::select('assessments_tbls.*',
            'students_tbls.user_id')
            ->leftJoin('students_tbls', 'assessments_tbls.student_id', '=', 'students_tbls.id')
            ->where('assessments_tbls.id', $assessment_id)->first();
        $data['payments'] = PaymentHistoryTbl::select(DB::raw("SUM(payment_amount) as total_payment"))
            ->where('is_approved', 1)
            ->where('assessments_id', $assessment_id)->first();
        $getBranch_id = EnrollmentTbl::select('branch_id', 'id')->where('id', $data['assessments_details']->enrollment_id)->first();
        $data['branch_id'] = BranchTbl::select('branch_tbls.*')->where('id', $getBranch_id->branch_id)->first();
        return $data;
    }

    public function destroy(Request $request, $id)
    {
        //
        DB::table('payment_history_tbls')
            ->where('id', $id)->delete();

    }

    public function savePayments(Request $request, $length = 12)
    {
        //
        $payment_amount = $request->payment_amount;
        $available_balance = $request->payment_available_balance;

        if ($available_balance >= 0 && $payment_amount >= 0) {

            $payment = new PaymentHistoryTbl();
            $payment->student_id = $request->student_id;
            $payment->branch_id = $request->branch_id;
            $payment->assessments_id = $request->assessment_id;
            $payment->payment_method = $request->payment_type;
            $payment->payment_amount = $request->payment_amount;
            $payment->or_number = $request->or_number;
            $payment->payment_type = $request->payment_for;
            $payment->is_approved = 1;
            $payment->is_active = 1;
            $payment->encoded_by = $request->created_by;
            $payment->created_at = $request->payment_date;
            if ($payment->save()) {

                $total_bal = ($available_balance - $payment_amount);

                if ($total_bal == 0) {
                    $assessment = AssessmentsTbl::find($request->assessment_id);
                    $assessment->status = 'Paid';
                    $assessment->save();
                }


                if ($request->user_id == '') {

                    $student = StudentsTbl::find($request->student_id);

                    $fullName = $student->first_name . " " . $student->middle_name . " " . $student->last_name;
                    $characters = sha1(md5($fullName . "123456"));
                    $characterLength = strlen($characters);
                    $randomStr = '';
                    for ($i = 0; $i < $length; $i++) {
                        $randomStr = $characters[rand(0, $characterLength - 1)];
                    }
                    $salt = md5($randomStr);
                    $password = sha1("PSBCNumber1", TRUE);
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT, [$salt]);
                    if ($student->lrn != '') {
                        $uname = $student->lrn;
                    } else {
                        $uname = $fullName;
                    }

                    //save in users table
                    $user = new UsersTbl();
                    $user->branch_id = 1;
                    $user->full_name = $fullName;
                    $user->user_name = $uname;
                    $user->password = $hashed_password;
                    $user->salt = $salt;
                    $user->email = $student->email;
                    $user->role_id = 3; //default student role
                    $user->is_active = 1;
                    Mail::to($user->email)->send(new UserDetailsMail("PSBCNumber1"));
                    if ($user->save()) {
                        $student_ = StudentsTbl::find($request->student_id);
                        $student_->user_id = $user->id;
                        $student_->save();
                    }
                }

                $is_grade_exist = Grade::where('enrollment_id', $request->enrollment_id);

                if ($is_grade_exist->count() > 0) {

                } else {
                    $get_subject_ids = EnrollmentTbl::where('id', $request->enrollment_id)->first();
                    $subjects = json_decode($get_subject_ids->subject_ids);
                    if ($subjects != '') {
                        for ($ii = 0; $ii < sizeof($subjects); $ii++) {
                            $grades = new Grade();
                            $grades->student_id = $request->student_id;
                            $grades->enrollment_id = $request->enrollment_id;
                            $grades->subject_id = trim($subjects[$ii]);
                            $grades->grade = '0';
                            $grades->status = 'ongoing';
                            $grades->save();
                            echo $ii;
                        }
                    }
                }
            }


        }
    }
}
