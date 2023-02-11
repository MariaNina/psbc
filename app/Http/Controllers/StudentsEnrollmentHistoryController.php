<?php

namespace App\Http\Controllers;

use App\Models\ApplicationStatusView;
use App\Models\AssessmentsTbl;
use App\Models\EnrollmentTbl;
use App\Models\Grade;
use App\Models\LevelsTbl;
use App\Models\StudentsTbl;
use App\Models\TermsTbl;
use App\Utilities\AccessRoute;
use App\Utilities\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UsersTbl;
use App\Utilities\AuditTrail;
use Yajra\DataTables\DataTables;

class StudentsEnrollmentHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $user_id = session('user')->id;
        $uer_role = session('user')->role;
        if ($request->ajax()) {

            $EnrollmentHistoryTbl = ApplicationStatusView::select();

            if($uer_role == "Student"){
              $EnrollmentHistoryTbl = $EnrollmentHistoryTbl->where('user_id', $user_id);
            }

            return DataTables::of($EnrollmentHistoryTbl)
            ->addIndexColumn()
                ->addColumn('action', function ($EnrollmentHistoryTbl) {
                    $button = '';
                    // $is_active = ($EnrollmentHistoryTbl->is_active == TRUE) ? 'deactivate' :'activate';
                    if($EnrollmentHistoryTbl->STATUS == 'Enrolled'){

                        $button .= '<span class="actionCust" title="view student assessment form" ><a class="" href="/assessmentForm?i=' . base64_encode($EnrollmentHistoryTbl->assessment_id) . '"><i class="fas fa-print"></i></a></span>';
                    }

                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);
        }

        $data['title'] = 'Enrollment History';
        $data['permissions'] = AccessRoute::user_permissions($user_id);
        $data['school_year_id'] = Helpers::currentSchoolYear('id');
        $data['school_year'] = Helpers::currentSchoolYear('school_years');
        $data['levels'] = LevelsTbl::all();
        $data['terms'] = TermsTbl::where('is_active', 1)->get();
        $data['user'] = UsersTbl::find(session('user')->id);
        return view('dashboard.enrollment_history',$data);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $length = 12)
    {
        $user = UsersTbl::findOrFail(session('user')->id);
        $student_id = $user->student->id;
        // $grade = Grade::where([['student_id','=',$student_id],['status','<>','Passed']])->count();
        
        // if($grade >0){
        //     return response()->json(['msg' => 'Please complete first your existing subject requirements','status' => 'error']);
        // }
        if($request->subjects != ''){
        
            $app_no = $this->createApplicationNo($request->student_department);
            $student = StudentsTbl::where('user_id',session('user')->id)->first();

            if(ApplicationStatusView::select('id')->whereIn('STATUS',['For Approval','For Assessment','For Payment'])->where('student_id',$student->id)->count() > 0){
                return response()->json(['msg' => 'Has an existing enrollment','status' => 'error']);
            }else{
            $enrollment = new EnrollmentTbl();
            $enrollment->student_id = $student->id;
            $enrollment->application_no = $app_no;
            // $enrollment->section_id = $request->section;
            $enrollment->term_id = $request->term;
            $enrollment->level_id = $request->student_level;
            $enrollment->student_type = 'Old';
            $enrollment->student_department = $request->student_department;
            $enrollment->branch_id = $request->branch;
            $enrollment->school_year_id = Helpers::currentSchoolYear('id');
            $enrollment->curriculum_id = $request->curriculum;
            // $enrollment->remarks = $request->remarks;
            $enrollment->subject_ids = json_encode($request->subjects);
            $enrollment->is_approved = 0;
            if($enrollment->save()){
                //log to audit trail
                $new_data = $enrollment;
                $action_taken = 'Create';
                $description = 'New Student Enrollment';
                AuditTrail::logAuditTrail( $action_taken , $description , $new_data);
                //end log
           }
            
            // $assessment = new AssessmentsTbl();
            // $assessment->student_id  = $student->id;
            // // $assessment->subject_ids = json_encode($request->subjects);
            // $assessment->student_department = $request->student_department;
            // $assessment->status = 'pending';
            // $assessment->is_active = 0;
            // $assessment->enrollment_id = $enrollment->id;
            // $assessment->save();

            return response()->json(['msg' => 'Successfully Saved','status' => 'success']);
            }
        }else{
            return response()->json(['msg' => 'Subjects cannot be empty','status' => 'error']);
        }
        
    }
    private function createApplicationNo($stud_dept)
    {
        /**create a switch statement to check the student dept and 
         assign a value (ELEM,JHS,SHS,COL,GS) that we will use for 
         the application_no format **/
         
       switch($stud_dept){

           case('Elementary'):
            $dept = 'ELEM'; //elementary
           break;

           case('JHS'):
            $dept = 'JHS'; //junior high school
           break;

           case('SHS'):
            $dept = 'SHS'; //senior high school
           break;

           case('College'):
            $dept = 'COL'; //college
           break;

           case('Graduate Studies'):
            $dept = 'GS'; //graduate studies
           break;

           default:
            $dept = 'NA';
       }

       $year = Helpers::currentSchoolYear('school_years');
       $school_year_id = Helpers::currentSchoolYear('id');

       $students = EnrollmentTbl::where(array('school_year_id' => $school_year_id, 'student_department' => $stud_dept))->get(); //select all rows with same school year and student dept
       $studentCount = $students->count(); //count all rows

       if($studentCount > 0){ //check if theres an existing application 
        $series = str_pad(($studentCount+1), 4, 0, STR_PAD_LEFT); //creates series
       }else{
        $series = '0001'; //if theres no existing application
       }

       //Combine them to create a format like this e.g. ELEM-2021-2022-0001
       $application_no = $dept.'-'.$year.'-'.$series; 

       //return the value
       return $application_no;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
