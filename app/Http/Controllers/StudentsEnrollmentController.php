<?php

namespace App\Http\Controllers;

use App\Models\ApplicationStatusView;
use App\Models\AssessmentsTbl;
use App\Models\BranchCollegesProgramsMajorsTbl;
use App\Models\BranchTbl;
use App\Models\CurriculumSubjectsTbl;
use App\Models\CurriculumTbl;
use App\Models\DocumentsTbl;
use App\Models\EnrollmentTbl;
use App\Models\Grade;
use App\Models\GuardianTbl;
use App\Models\LevelsTbl;
use App\Models\ProgramMajorsTbl;
use App\Models\SchoolYearTbl;
use App\Models\SectionsTbl;
use App\Models\StudentsTbl;
use App\Models\TermsTbl;
use App\Models\UsersTbl;
use App\Utilities\AccessRoute;
use App\Utilities\AuditTrail;
use App\Utilities\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Yajra\DataTables\DataTables;

class StudentsEnrollmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('authenticated')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @param string $branch
     * @param string $department
     * @param string $strand
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Request $request, $branch = 'All', $department = 'All', $strand = 'All')
    {
        //
        if ($request->ajax()) {

            $EnrollmentTbl = [];

            DB::statement(DB::raw('set @rownum=0'));
            // No Filter
            if ($branch === 'All' && $department === 'All' && $strand === 'All') {
                $EnrollmentTbl = EnrollmentTbl::select(
                    DB::raw('@rownum :=@rownum+1 as rowNum'),
                    "enrollment_tbls.id",
                    "assessments_tbls.id AS assessment_id",
                    "enrollment_tbls.student_id AS e_student_id",
                    "enrollment_tbls.application_no",
                    "enrollment_tbls.student_department",
                    "enrollment_tbls.is_approved",
                    "students_tbls.lrn",
                    "students_tbls.student_type",
                    "students_tbls.contact_number",
                    "students_tbls.address",
                    "students_tbls.first_name",
                    "students_tbls.middle_name",
                    "students_tbls.last_name",
                    "students_tbls.email",
                    "programs_tbls.program_name",
                    "majors_tbls.major_name",
                    "levels_tbls.level_name",
                    "sections_tbls.section_label",
                    "terms_tbls.term_name",
                    "school_year_tbls.school_years",
                    "application_status_view.STATUS as app_status")
                    ->join('application_status_view', 'enrollment_tbls.application_no', '=', 'application_status_view.application_no')
                    ->join('students_tbls', 'enrollment_tbls.student_id', '=', 'students_tbls.id')
                    ->leftJoin('curriculum_tbls', 'enrollment_tbls.curriculum_id', '=', 'curriculum_tbls.id')
                    ->leftJoin('program_majors_tbls', 'curriculum_tbls.program_major_id', '=', 'program_majors_tbls.id')
                    ->leftJoin('programs_tbls', 'program_majors_tbls.program_id', '=', 'programs_tbls.id')
                    ->leftJoin('majors_tbls', 'program_majors_tbls.major_id', '=', 'majors_tbls.id')
                    ->leftJoin('levels_tbls', 'enrollment_tbls.level_id', '=', 'levels_tbls.id')
                    ->leftJoin('sections_tbls', 'enrollment_tbls.section_id', '=', 'sections_tbls.id')
                    ->leftJoin('terms_tbls', 'enrollment_tbls.term_id', '=', 'terms_tbls.id')
                    ->leftJoin('school_year_tbls', 'enrollment_tbls.school_year_id', '=', 'school_year_tbls.id')
                    ->leftJoin('assessments_tbls', 'assessments_tbls.enrollment_id', '=', 'enrollment_tbls.id');
            }

            if ($branch !== 'All' && $strand === 'All' && $department === 'All') {
                // Filter by Branch
                $EnrollmentTbl = EnrollmentTbl::select(
                    DB::raw('@rownum :=@rownum+1 as rowNum'),
                    "enrollment_tbls.id",
                    "assessments_tbls.id AS assessment_id",
                    "enrollment_tbls.student_id AS e_student_id",
                    "enrollment_tbls.application_no",
                    "enrollment_tbls.student_department",
                    "enrollment_tbls.is_approved",
                    "students_tbls.lrn",
                    "students_tbls.student_type",
                    "students_tbls.contact_number",
                    "students_tbls.address",
                    "students_tbls.first_name",
                    "students_tbls.middle_name",
                    "students_tbls.last_name",
                    "students_tbls.email",
                    "programs_tbls.program_name",
                    "majors_tbls.major_name",
                    "levels_tbls.level_name",
                    "sections_tbls.section_label",
                    "terms_tbls.term_name",
                    "school_year_tbls.school_years",
                    'branch_tbls.branch_name',
                    "application_status_view.STATUS as app_status")
                    ->join('branch_tbls', 'enrollment_tbls.branch_id', '=', 'branch_tbls.id')
                    ->join('application_status_view', 'enrollment_tbls.application_no', '=', 'application_status_view.application_no')
                    ->leftJoin('students_tbls', 'enrollment_tbls.student_id', '=', 'students_tbls.id')
                    ->leftJoin('curriculum_tbls', 'enrollment_tbls.curriculum_id', '=', 'curriculum_tbls.id')
                    ->leftJoin('program_majors_tbls', 'curriculum_tbls.program_major_id', '=', 'program_majors_tbls.id')
                    ->leftJoin('programs_tbls', 'program_majors_tbls.program_id', '=', 'programs_tbls.id')
                    ->leftJoin('majors_tbls', 'program_majors_tbls.major_id', '=', 'majors_tbls.id')
                    ->leftJoin('levels_tbls', 'enrollment_tbls.level_id', '=', 'levels_tbls.id')
                    ->leftJoin('sections_tbls', 'enrollment_tbls.section_id', '=', 'sections_tbls.id')
                    ->leftJoin('terms_tbls', 'enrollment_tbls.term_id', '=', 'terms_tbls.id')
                    ->leftJoin('school_year_tbls', 'enrollment_tbls.school_year_id', '=', 'school_year_tbls.id')
                    ->leftJoin('assessments_tbls', 'assessments_tbls.enrollment_id', '=', 'enrollment_tbls.id')
                    ->where('branch_tbls.branch_name', $branch);
            }

            if ($branch === 'All' && $strand === 'All' && $department !== 'All') {
                // Filter by Department
                $EnrollmentTbl = EnrollmentTbl::select(
                    DB::raw('@rownum :=@rownum+1 as rowNum'),
                    "enrollment_tbls.id",
                    "assessments_tbls.id AS assessment_id",
                    "enrollment_tbls.student_id AS e_student_id",
                    "enrollment_tbls.application_no",
                    "enrollment_tbls.student_department",
                    "enrollment_tbls.is_approved",
                    "students_tbls.lrn",
                    "students_tbls.student_type",
                    "students_tbls.contact_number",
                    "students_tbls.address",
                    "students_tbls.first_name",
                    "students_tbls.middle_name",
                    "students_tbls.last_name",
                    "students_tbls.email",
                    "programs_tbls.program_name",
                    "majors_tbls.major_name",
                    "levels_tbls.level_name",
                    "sections_tbls.section_label",
                    "terms_tbls.term_name",
                    "school_year_tbls.school_years",
                    'branch_tbls.branch_name',
                    "application_status_view.STATUS as app_status")
                    ->join('branch_tbls', 'enrollment_tbls.branch_id', '=', 'branch_tbls.id')
                    ->join('application_status_view', 'enrollment_tbls.application_no', '=', 'application_status_view.application_no')
                    ->leftJoin('students_tbls', 'enrollment_tbls.student_id', '=', 'students_tbls.id')
                    ->leftJoin('curriculum_tbls', 'enrollment_tbls.curriculum_id', '=', 'curriculum_tbls.id')
                    ->leftJoin('program_majors_tbls', 'curriculum_tbls.program_major_id', '=', 'program_majors_tbls.id')
                    ->leftJoin('programs_tbls', 'program_majors_tbls.program_id', '=', 'programs_tbls.id')
                    ->leftJoin('majors_tbls', 'program_majors_tbls.major_id', '=', 'majors_tbls.id')
                    ->leftJoin('levels_tbls', 'enrollment_tbls.level_id', '=', 'levels_tbls.id')
                    ->leftJoin('sections_tbls', 'enrollment_tbls.section_id', '=', 'sections_tbls.id')
                    ->leftJoin('terms_tbls', 'enrollment_tbls.term_id', '=', 'terms_tbls.id')
                    ->leftJoin('school_year_tbls', 'enrollment_tbls.school_year_id', '=', 'school_year_tbls.id')
                    ->leftJoin('assessments_tbls', 'assessments_tbls.enrollment_id', '=', 'enrollment_tbls.id')
                    ->where('enrollment_tbls.student_department', $department);
            }

            if ($branch !== 'All' && $department !== 'All' && $strand === 'All') {
                // Filter by branch and department
                $EnrollmentTbl = EnrollmentTbl::select(
                    DB::raw('@rownum :=@rownum+1 as rowNum'),
                    "enrollment_tbls.id",
                    "assessments_tbls.id AS assessment_id",
                    "enrollment_tbls.student_id AS e_student_id",
                    "enrollment_tbls.application_no",
                    "enrollment_tbls.student_department",
                    "enrollment_tbls.is_approved",
                    "students_tbls.lrn",
                    "students_tbls.student_type",
                    "students_tbls.contact_number",
                    "students_tbls.address",
                    "students_tbls.first_name",
                    "students_tbls.middle_name",
                    "students_tbls.last_name",
                    "students_tbls.email",
                    "programs_tbls.program_name",
                    "majors_tbls.major_name",
                    "levels_tbls.level_name",
                    "sections_tbls.section_label",
                    "terms_tbls.term_name",
                    "school_year_tbls.school_years",
                    'branch_tbls.branch_name',
                    "application_status_view.STATUS as app_status")
                    ->join('branch_tbls', 'enrollment_tbls.branch_id', '=', 'branch_tbls.id')
                    ->join('application_status_view', 'enrollment_tbls.application_no', '=', 'application_status_view.application_no')
                    ->leftJoin('students_tbls', 'enrollment_tbls.student_id', '=', 'students_tbls.id')
                    ->leftJoin('curriculum_tbls', 'enrollment_tbls.curriculum_id', '=', 'curriculum_tbls.id')
                    ->leftJoin('program_majors_tbls', 'curriculum_tbls.program_major_id', '=', 'program_majors_tbls.id')
                    ->leftJoin('programs_tbls', 'program_majors_tbls.program_id', '=', 'programs_tbls.id')
                    ->leftJoin('majors_tbls', 'program_majors_tbls.major_id', '=', 'majors_tbls.id')
                    ->leftJoin('levels_tbls', 'enrollment_tbls.level_id', '=', 'levels_tbls.id')
                    ->leftJoin('sections_tbls', 'enrollment_tbls.section_id', '=', 'sections_tbls.id')
                    ->leftJoin('terms_tbls', 'enrollment_tbls.term_id', '=', 'terms_tbls.id')
                    ->leftJoin('school_year_tbls', 'enrollment_tbls.school_year_id', '=', 'school_year_tbls.id')
                    ->leftJoin('assessments_tbls', 'assessments_tbls.enrollment_id', '=', 'enrollment_tbls.id')
                    ->where('branch_tbls.branch_name', $branch)
                    ->where('enrollment_tbls.student_department', $department);
            }

            if ($strand !== 'All' && $branch === 'All' && ($department !== 'All' && $department !== 'Elementary' && $department !== 'JHS')) {
                // Filter by department & strand
                $EnrollmentTbl = EnrollmentTbl::select(
                    DB::raw('@rownum :=@rownum+1 as rowNum'),
                    "enrollment_tbls.id",
                    "assessments_tbls.id AS assessment_id",
                    "enrollment_tbls.student_id AS e_student_id",
                    "enrollment_tbls.application_no",
                    "enrollment_tbls.student_department",
                    "enrollment_tbls.is_approved",
                    "students_tbls.lrn",
                    "students_tbls.student_type",
                    "students_tbls.contact_number",
                    "students_tbls.address",
                    "students_tbls.first_name",
                    "students_tbls.middle_name",
                    "students_tbls.last_name",
                    "students_tbls.email",
                    "programs_tbls.program_name",
                    "majors_tbls.major_name",
                    "levels_tbls.level_name",
                    "sections_tbls.section_label",
                    "terms_tbls.term_name",
                    "school_year_tbls.school_years",
                    'branch_tbls.branch_name',
                    'program_majors_tbls.description',
                    "application_status_view.STATUS as app_status")
                    ->join('branch_tbls', 'enrollment_tbls.branch_id', '=', 'branch_tbls.id')
                    ->join('application_status_view', 'enrollment_tbls.application_no', '=', 'application_status_view.application_no')
                    ->leftJoin('students_tbls', 'enrollment_tbls.student_id', '=', 'students_tbls.id')
                    ->leftJoin('curriculum_tbls', 'enrollment_tbls.curriculum_id', '=', 'curriculum_tbls.id')
                    ->leftJoin('program_majors_tbls', 'curriculum_tbls.program_major_id', '=', 'program_majors_tbls.id')
                    ->leftJoin('programs_tbls', 'program_majors_tbls.program_id', '=', 'programs_tbls.id')
                    ->leftJoin('majors_tbls', 'program_majors_tbls.major_id', '=', 'majors_tbls.id')
                    ->leftJoin('levels_tbls', 'enrollment_tbls.level_id', '=', 'levels_tbls.id')
                    ->leftJoin('sections_tbls', 'enrollment_tbls.section_id', '=', 'sections_tbls.id')
                    ->leftJoin('terms_tbls', 'enrollment_tbls.term_id', '=', 'terms_tbls.id')
                    ->leftJoin('school_year_tbls', 'enrollment_tbls.school_year_id', '=', 'school_year_tbls.id')
                    ->leftJoin('assessments_tbls', 'assessments_tbls.enrollment_id', '=', 'enrollment_tbls.id')
                    ->where('program_majors_tbls.description', $strand)
                    ->where('enrollment_tbls.student_department', $department);
            }

            if (($strand !== 'All' && $branch !== 'All') && ($department !== 'All' && $department !== 'Elementary' && $department !== 'JHS')) {
                // Filter by branch, department & strand
                $EnrollmentTbl = EnrollmentTbl::select(
                    DB::raw('@rownum :=@rownum+1 as rowNum'),
                    "enrollment_tbls.id",
                    "assessments_tbls.id AS assessment_id",
                    "enrollment_tbls.student_id AS e_student_id",
                    "enrollment_tbls.application_no",
                    "enrollment_tbls.student_department",
                    "enrollment_tbls.is_approved",
                    "students_tbls.lrn",
                    "students_tbls.student_type",
                    "students_tbls.contact_number",
                    "students_tbls.address",
                    "students_tbls.first_name",
                    "students_tbls.middle_name",
                    "students_tbls.last_name",
                    "students_tbls.email",
                    "programs_tbls.program_name",
                    "majors_tbls.major_name",
                    "levels_tbls.level_name",
                    "sections_tbls.section_label",
                    "terms_tbls.term_name",
                    "school_year_tbls.school_years",
                    'branch_tbls.branch_name',
                    'program_majors_tbls.description',
                    "application_status_view.STATUS as app_status")
                    ->join('branch_tbls', 'enrollment_tbls.branch_id', '=', 'branch_tbls.id')
                    ->join('application_status_view', 'enrollment_tbls.application_no', '=', 'application_status_view.application_no')
                    ->leftJoin('students_tbls', 'enrollment_tbls.student_id', '=', 'students_tbls.id')
                    ->leftJoin('curriculum_tbls', 'enrollment_tbls.curriculum_id', '=', 'curriculum_tbls.id')
                    ->leftJoin('program_majors_tbls', 'curriculum_tbls.program_major_id', '=', 'program_majors_tbls.id')
                    ->leftJoin('programs_tbls', 'program_majors_tbls.program_id', '=', 'programs_tbls.id')
                    ->leftJoin('majors_tbls', 'program_majors_tbls.major_id', '=', 'majors_tbls.id')
                    ->leftJoin('levels_tbls', 'enrollment_tbls.level_id', '=', 'levels_tbls.id')
                    ->leftJoin('sections_tbls', 'enrollment_tbls.section_id', '=', 'sections_tbls.id')
                    ->leftJoin('terms_tbls', 'enrollment_tbls.term_id', '=', 'terms_tbls.id')
                    ->leftJoin('school_year_tbls', 'enrollment_tbls.school_year_id', '=', 'school_year_tbls.id')
                    ->leftJoin('assessments_tbls', 'assessments_tbls.enrollment_id', '=', 'enrollment_tbls.id')
                    ->where('branch_tbls.branch_name', $branch)
                    ->where('enrollment_tbls.student_department', $department)
                    ->where('program_majors_tbls.description', $strand);
            }

            return DataTables::of($EnrollmentTbl)
                ->addIndexColumn()
                ->addColumn('action', function ($EnrollmentTbl) {

                    $button = '';
                    $is_approved = ($EnrollmentTbl->is_approved == 1) ? 'deactivate' : 'activate';

                    if ($EnrollmentTbl->app_status == 'Enrolled') {

                        $button .= '<span class="actionCust" title="view student assessment form" ><a class="" href="/assessmentForm?i=' . base64_encode($EnrollmentTbl->assessment_id) . '"><i class="fas fa-print"></i></a></span>';
                    }

                    $button .= '<span class="actionCust viewDocument" title="view student documents" data-id="' . $EnrollmentTbl->e_student_id . '"><a class=""><i class="fas fa-edit"></i></a></span>';
                    //button update
                    // $button .= '<span class="actionCust editData" title="update student details" data-id="' . md5($EnrollmentTbl->id) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    $button .= '<span class="actionCust ' . $is_approved . '"  title="' . $is_approved . ' students application" data-id="' . md5($EnrollmentTbl->id) . '" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>';


                    return $button; // Return Button
                })
                ->addColumn('No', function ($EnrollmentTbl) {
                    return $EnrollmentTbl->rowNum; // Return Row NUmber
                })
                ->rawColumns(['No', 'action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);
        }
        $current_school_id = Helpers::currentSchoolYear('id');//place here selected school year
        $current_school_year = Helpers::currentSchoolYear('school_years');//place here selected school year
        $enrollees = EnrollmentTbl::select('student_id')->where('school_year_id', $current_school_id);
        $data['permissions'] = AccessRoute::user_permissions(session('user')->id);
        $data['terms'] = TermsTbl::where('is_active', 1)->get();
        // $data['students'] = StudentsTbl::whereNotIn('id', $enrollees)->get();
         $data['students'] = StudentsTbl::all();
        // $data['levels'] = LevelsTbl::where(array('student_dept' => $student_department,'is_active'=> 1))->get();
        $data['branches'] = BranchTbl::all();
        $data['school_year'] = $current_school_year;
        $data['school_year_id'] = $current_school_id;
        $data['school_years'] = SchoolYearTbl::all();
        $stud_dept = $request->stud_dept;
        $stud_level = $request->stud_level;
        $branch_id = $request->branch_id;
        $school_year = SchoolYearTbl::latest('school_years')->where('is_active', 1)->first()->id;
        $data['levels'] = LevelsTbl::where(array('student_dept' => $stud_dept, 'is_active' => 1))->get();

        return view('dashboard.students_enrollment', $data);
    }

    public function getCurriculumStrandByDepartment(Request $request)
    {
        $department = $request->department;
        $school_year = SchoolYearTbl::latest('school_years')->where('is_active', 1)->first()->id;
        if ($department !== 'All' && $department !== 'JHS' && $department !== 'Elementary') {

            $curr = ProgramMajorsTbl::select(
                'program_majors_tbls.id as program_major_id',
                'programs_tbls.id as program_id',
                'program_majors_tbls.description as description',
                'program_majors_tbls.student_department as student_department',
                'programs_tbls.program_code as program_code',
                'programs_tbls.program_name as program_name')
                ->join('programs_tbls', 'program_majors_tbls.program_id', '=', 'programs_tbls.id')
                ->where('programs_tbls.is_active', 1)
                ->where('student_department', $department)
                ->get();

            return response()->json($curr);
        } else {
            return response()->json([]);
        }
    }

    public function create()
    {
        //
    }

    public function store(Request $request, $length = 12)
    {
        if ($request->subjects != '') {
            $app_no = $this->createApplicationNo($request->student_department);
            $enrollment = new EnrollmentTbl();
            $enrollment->student_id = $request->student;
            $enrollment->application_no = $app_no;
            $enrollment->section_id = $request->section;
            $enrollment->term_id = $request->term;
            $enrollment->level_id = $request->student_level;
            $enrollment->student_type = 'Old';
            $enrollment->student_department = $request->student_department;
            $enrollment->branch_id = $request->branch;
            $enrollment->school_year_id = $request->school_years;
            $enrollment->curriculum_id = $request->curriculum;
            $enrollment->remarks = $request->remarks;
            $enrollment->subject_ids = json_encode($request->subjects);
            $enrollment->is_approved = 1;
            if($enrollment->save()){
                //log to audit trail
                $new_data = $enrollment;
                $action_taken = 'Create';
                $description = 'Add Student to Enrollment';
                AuditTrail::logAuditTrail( $action_taken , $description , $new_data);
                //end log
           }

            // $is_grade_exist = Grade::where('enrollment_id',$request->enrollment_id);

            // if($is_grade_exist->count() > 0){
            // $grade = Grade::where('enrollment_id',$request->enrollment_id);
            // $data['student_id'] =$request->student;
            // $data['enrollment_id'] = $enrollment->id;
            // $grade->update($data);
            // }else{
            // $grade = new Grade;
            // $grade->student_id =$request->student;
            // $grade->enrollment_id = $enrollment->id;
            // $grade->save();
            // }


            $assessment = new AssessmentsTbl();
            $assessment->student_id = $request->student;
            // $assessment->subject_ids = json_encode($request->subjects);
            $assessment->student_department = $request->student_department;
            $assessment->status = 'pending';
            $assessment->is_active = 0;
            $assessment->enrollment_id = $enrollment->id;
            if($assessment->save()){
                //log to audit trail
                $new_data = $assessment;
                $action_taken = 'Create';
                $description = 'Add Student to Assessment';
                AuditTrail::logAuditTrail( $action_taken , $description , $new_data);
                //end log
           }

            return response()->json(['msg' => 'Successfully Saved', 'status' => 'success']);
        } else {
            return response()->json(['msg' => 'Subjects cannot be empty', 'status' => 'error']);
        }

    }

    private function createApplicationNo($stud_dept)
    {
        /**create a switch statement to check the student dept and
         * assign a value (ELEM,JHS,SHS,COL,GS) that we will use for
         * the application_no format **/

        switch ($stud_dept) {

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

        if ($studentCount > 0) { //check if theres an existing application
            $series = str_pad(($studentCount + 1), 4, 0, STR_PAD_LEFT); //creates series
        } else {
            $series = '0001'; //if theres no existing application
        }

        //Combine them to create a format like this e.g. ELEM-2021-2022-0001
        $application_no = $dept . '-' . $year . '-' . $series;

        //return the value
        return $application_no;
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
    public function getStudentData(Request $request)
    {
        //
        $id = $request->id;
        $data['student_details'] = StudentsTbl::select('students_tbls.*', 'guardian_tbls.first_name AS g_first_name', 'guardian_tbls.middle_name AS g_middle_name', 'guardian_tbls.last_name AS g_last_name', 'guardian_tbls.address AS g_address', 'guardian_tbls.contact_number AS g_contact_number', 'users_tbls.user_name')
            ->leftJoin('guardian_tbls', 'guardian_tbls.id', '=', 'students_tbls.guardian_id')
            ->leftJoin('users_tbls', 'users_tbls.id', '=', 'students_tbls.user_id')
            ->where('students_tbls.id', $id)->get();

        $enrollment = EnrollmentTbl::select('enrollment_tbls.*',)
            ->where('enrollment_tbls.student_id', $id)->orderBy('id', 'desc');
        $enrollment_id = $enrollment->first()->id;
        $curriculum_id = $enrollment->first()->curriculum_id;
        $branch_id = $enrollment->first()->branch_id;
        $level_id = $enrollment->first()->level_id;
        $student_department = $enrollment->first()->student_department;
        $school_year = $enrollment->first()->school_year_id;
        $data['levels'] = LevelsTbl::where(array('student_dept' => $student_department, 'is_active' => 1))->get();
        $data['curriculums'] = BranchCollegesProgramsMajorsTbl::select(
            "curriculum_tbls.id as id",
            "programs_tbls.program_name as pname",
            "majors_tbls.major_name as mname")
            ->leftJoin('program_majors_tbls', 'branch_colleges_programs_majors_tbls.program_major_id', '=', 'program_majors_tbls.id')
            ->leftJoin('programs_tbls', 'program_majors_tbls.program_id', '=', 'programs_tbls.id')
            ->leftJoin('majors_tbls', 'program_majors_tbls.major_id', '=', 'majors_tbls.id')
            ->leftJoin('curriculum_tbls', 'curriculum_tbls.program_major_id', '=', 'program_majors_tbls.id')
            ->where('branch_colleges_programs_majors_tbls.branch_id', $branch_id)
            ->where('curriculum_tbls.school_year_id', $school_year)
            ->where('curriculum_tbls.level_id', $level_id)
            ->where('curriculum_tbls.student_department', $student_department)
            ->where('curriculum_tbls.is_active', 1)->get();

        $data['sections'] = SectionsTbl::where(array('branch_id' => $branch_id, 'level_id' => $level_id, 'is_active' => 1))->get();
        $data['levels'] = LevelsTbl::where(array('student_dept' => $student_department, 'is_active' => 1))->get();
        $data['terms'] = TermsTbl::where('is_active', 1)->get();
        $data['branches'] = BranchTbl::all();
        $data['school_years'] = SchoolYearTbl::where('is_active', 1)->get();
        $data['subjects'] = $this->getSubjectByCur($curriculum_id, $enrollment_id);
        $data['enrollment'] = $enrollment->get();
        $data['docs'] = $this->getDocuments($id);
        $data['app_stats'] = ApplicationStatusView::where('id', $enrollment_id)->get();
        return $data;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $length = 12)
    {
        //
        if ($request->subjects != '') {
            $guardian = GuardianTbl::find($request->guardian_id);
            $guardian->first_name = $request->g_first_name;
            $guardian->middle_name = $request->g_middle_name;
            $guardian->last_name = $request->g_last_name;
            $guardian->address = $request->g_address;
            $guardian->contact_number = $request->g_contact_number;
            $guardian->save();

            if ($request->student_department == 'College') {
                $other_details = [
                    'student_department' => $request->student_department,
                    'college_shs_track' => $request->college_shs_track,
                    'last_school_attended' => $request->last_school_attended,
                    'year_graduated' => $request->year_graduated,
                ];
            } elseif ($request->student_department == 'Graduate Studies') {
                $other_details = [
                    'student_department' => $request->student_department,
                    'under_grad_program_taken' => $request->under_grad_program_taken,
                    'last_school_attended' => $request->last_school_attended,
                    'year_graduated' => $request->year_graduated,
                ];
            } else {
                $other_details = [
                    'last_school_attended' => $request->last_school_attended,
                    'year_graduated' => $request->year_graduated,
                ];
            }
            $student = StudentsTbl::find($request->student_id);

            $student->first_name = $request->first_name;
            // $student->user_id = $user_id;
            $student->middle_name = $request->middle_name;
            $student->last_name = $request->last_name;
            $student->suffix_name = $request->suffix_name;
            $student->student_type = $request->student_type;
            $student->lrn = $request->lrn;
            $student->birth_day = $request->birth_day;
            $student->birth_place = $request->birth_place;
            $student->gender = $request->gender;
            $student->citizenship = $request->citizenship;
            $student->civil_status = $request->civil_status;
            $student->address = $request->address;
            $student->religion = $request->religion;
            $student->contact_number = $request->contact_number;
            $student->other_details = json_encode($other_details);
            $student->save();

            $enrollment = EnrollmentTbl::find($request->enrollment_id);
            $enrollment->section_id = $request->section;
            $enrollment->term_id = $request->term;
            $enrollment->level_id = $request->student_level;
            $enrollment->student_type = $request->student_type;
            $enrollment->student_department = $request->student_department;
            $enrollment->branch_id = $request->branch;
            $enrollment->school_year_id = $request->school_years;
            $enrollment->curriculum_id = $request->curriculum;
            $enrollment->remarks = $request->remarks;
            $enrollment->subject_ids = json_encode($request->subjects);
            $enrollment->is_approved = $request->status;
            $enrollment->save();

            // $is_grade_exist = Grade::where('enrollment_id',$request->enrollment_id);

            // if($is_grade_exist->count() > 0){
            // $grade = Grade::where('enrollment_id',$request->enrollment_id);
            // $data['student_id'] =$student->id;
            // $data['enrollment_id'] = $enrollment->id;
            // $grade->update($data);
            // }else{
            // $grade = new Grade;
            // $grade->student_id =$student->id;
            // $grade->enrollment_id = $enrollment->id;
            // $grade->save();
            // }

            $is_assessment_exist = AssessmentsTbl::where('enrollment_id', $request->enrollment_id);

            if ($request->status == 2) {
                $data['status'] = "rejected";
            }
            if ($request->status == 1) {
                $data['status'] = "pending";
            }

            if ($is_assessment_exist->count() > 0) {

                $data['student_id'] = $request->student_id;
                // $data['subject_ids'] = json_encode($request->subjects);
                $data['student_department'] = $request->student_department;
                $data['is_active'] = 0;
                $assessment = AssessmentsTbl::where('enrollment_id', $request->enrollment_id)->update($data);

            } else {

                $assessment = new AssessmentsTbl();
                $assessment->student_id = $request->student_id;
                // $assessment->subject_ids = json_encode($request->subjects);
                $assessment->student_department = $request->student_department;
                $assessment->is_active = 0;
                $assessment->enrollment_id = $request->enrollment_id;
                $assessment->save();
            }
            return response()->json(['msg' => 'Successfully Saved', 'status' => 'success']);
        } else {
            return response()->json(['msg' => 'Subjects cannot be empty', 'status' => 'error']);
        }
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
        $deactivate = EnrollmentTbl::where(DB::raw('md5(id)'), $id);
        $data['is_approved'] = $request->is_approved;
        $deactivate->update($data);
    }

    public function getDocuments($id)
    {
        $stud_id = $id;
        $documents = DocumentsTbl::select('documents_tbls.*', 'document_type_tbls.document_name')
            ->leftJoin('document_type_tbls', 'document_type_tbls.id', '=', 'documents_tbls.document_type_id')
            ->where('documents_tbls.student_id', $stud_id)->get();
        $html = '<h5>Documents</h5>
                    <ul>';
        foreach ($documents as $row) {
            if($row->document_file != ""){
            $destinationPath = asset('storage/student_docs/'.$row->document_file);
            $html .= '<li>
                        <td><a href="' . $destinationPath . '" target="_blank">' . $row->document_name . '</a></td>
                      </li>';
            }
        }
        $html .= '</ul>';
        return $html;
    }

    public function getSubjectByCur($cur_id, $enrollment_id)
    {
        $cur_id = $cur_id;
        $subject_ids = [];

        $assessment = EnrollmentTbl::select('subject_ids',)
            ->where('id', $enrollment_id);
        if ($assessment->count() > 0) {
            $subject_ids = json_decode($assessment->first()->subject_ids);
        }
        $subjects = CurriculumSubjectsTbl::select('curriculum_subjects_tbls.id',
            'curriculum_subjects_tbls.subject_id',
            'subject_tbls.lect_unit',
            'subject_tbls.lab_unit',
            'subject_tbls.subject_code',
            'subject_tbls.subject_name',
            DB::raw("CONCAT(subject_tbls_2.subject_code,' - ',subject_tbls_2.subject_name) AS preReqSubjectName"),
            "curriculum_subjects_tbls.id")
            ->leftJoin('subject_tbls', 'curriculum_subjects_tbls.subject_id', '=', 'subject_tbls.id')
            ->leftJoin('subject_tbls AS subject_tbls_2', 'curriculum_subjects_tbls.prerequisite_subject_id', '=', 'subject_tbls_2.id')
            ->where('curriculum_subjects_tbls.is_active', 1)
            ->where('curriculum_subjects_tbls.curriculum_id', $cur_id)->get();

        $html = '<table id="subject-list" class="table table-bordered">
                <thead>
                <tr>
                    <th>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="subject-list-select-all">
                            <label class="custom-control-label" for="subject-list-select-all"></label>
                        </div>
                    </th>
                    <th>Code</th>
                    <th>Subjects</th>
                    <th>Pre-Req</th>
                    <th>Lec</th>
                    <th>Lab</th>
                </thead>
                <tbody>';
        foreach ($subjects as $row) {
            if ($subject_ids != null) {
                $is_checked = in_array($row->subject_id, $subject_ids) ? "checked" : "";
            } else {
                $is_checked = '';
            }
            $html .= '<tr>
                        <td><div class="custom-control custom-checkbox">
                        <input value="' . $row->subject_id . '" name="subjects[]" type="checkbox" class="custom-control-input" id="customCheck' . $row->subject_id . '" data-id="' . $row->subject_id . '" ' . $is_checked . '>
                        <label class="custom-control-label" for="customCheck' . $row->subject_id . '"></label> </td>
                        <td>' . $row->subject_code . '</td>
                        <td>' . $row->subject_name . '</td>
                        <td>' . $row->preReqSubjectName . '</td>
                        <td>' . $row->lect_unit . '</td>
                        <td>' . $row->lab_unit . '</td>
                      </tr>';
        }
        $html .= '</tbody>
                </table>';
        return $html;
    }

    public function getSubjectByCurAjaxAdd(Request $request)
    {
        $cur_id = $request->curriculum;


        $subjects = CurriculumSubjectsTbl::select('curriculum_subjects_tbls.id',
            'curriculum_subjects_tbls.subject_id',
            'subject_tbls.lect_unit',
            'subject_tbls.lab_unit',
            'subject_tbls.subject_code',
            'subject_tbls.subject_name',
            DB::raw("CONCAT(subject_tbls_2.subject_code,' - ',subject_tbls_2.subject_name) AS preReqSubjectName"),
            "curriculum_subjects_tbls.id")
            ->leftJoin('subject_tbls', 'curriculum_subjects_tbls.subject_id', '=', 'subject_tbls.id')
            ->leftJoin('subject_tbls AS subject_tbls_2', 'curriculum_subjects_tbls.prerequisite_subject_id', '=', 'subject_tbls_2.id')
            ->where('curriculum_subjects_tbls.is_active', 1)
            ->where('curriculum_subjects_tbls.curriculum_id', $cur_id)->get();

        $html = '<table id="subject-list-add" class="table table-bordered">
                <thead>
                <tr>
                    <th>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input-add" id="subject-list-add-select-all">

                        </div>
                    </th>
                    <th>Code</th>
                    <th>Subjects</th>
                    <th>Pre-Req</th>
                    <th>Lec</th>
                    <th>Lab</th>
                </thead>
                <tbody>';
        foreach ($subjects as $row) {

            $html .= '<tr>
                        <td><div class="custom-control custom-checkbox">
                        <input value="' . $row->subject_id . '" name="subjects[]" type="checkbox" class="custom-control-input-add" id="customCheck' . $row->subject_id . '" data-id="' . $row->subject_id . '" >

                        <td>' . $row->subject_code . '</td>
                        <td>' . $row->subject_name . '</td>
                        <td>' . $row->preReqSubjectName . '</td>
                        <td>' . $row->lect_unit . '</td>
                        <td>' . $row->lab_unit . '</td>
                      </tr>';
        }
        $html .= '</tbody>
                </table>';
        return $html;
    }

    public function getSubjectByCurAjax(Request $request)
    {
        $enrollment_id = 0;
        $cur_id = $request->curriculum;
        $enrollment_id = $request->enrollment_id;
        $subject_ids = [];

        $assessment = EnrollmentTbl::select('subject_ids',)
            ->where('id', $enrollment_id);
        if ($assessment->count() > 0) {
            $subject_ids = json_decode($assessment->first()->subject_ids);
        }
        $subjects = CurriculumSubjectsTbl::select('curriculum_subjects_tbls.id',
            'curriculum_subjects_tbls.subject_id',
            'subject_tbls.lect_unit',
            'subject_tbls.lab_unit',
            'subject_tbls.subject_code',
            'subject_tbls.subject_name',
            DB::raw("CONCAT(subject_tbls_2.subject_code,' - ',subject_tbls_2.subject_name) AS preReqSubjectName"),
            "curriculum_subjects_tbls.id")
            ->leftJoin('subject_tbls', 'curriculum_subjects_tbls.subject_id', '=', 'subject_tbls.id')
            ->leftJoin('subject_tbls AS subject_tbls_2', 'curriculum_subjects_tbls.prerequisite_subject_id', '=', 'subject_tbls_2.id')
            ->where('curriculum_subjects_tbls.is_active', 1)
            ->where('curriculum_subjects_tbls.curriculum_id', $cur_id)->get();

        $html = '<table id="subject-list" class="table table-bordered">
                <thead>
                <tr>
                    <th>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="subject-list-select-all">
                            <label class="custom-control-label" for="subject-list-select-all"></label>
                        </div>
                    </th>
                    <th>Code</th>
                    <th>Subjects</th>
                    <th>Pre-Req</th>
                    <th>Lec</th>
                    <th>Lab</th>
                </thead>
                <tbody>';
        foreach ($subjects as $row) {
            if ($subject_ids != null) {
                $is_checked = in_array($row->subject_id, $subject_ids) ? "checked" : "";
            } else {
                $is_checked = '';
            }
            $html .= '<tr>
                        <td><div class="custom-control custom-checkbox">
                        <input value="' . $row->subject_id . '" name="subjects[]" type="checkbox" class="custom-control-input" id="customCheck' . $row->subject_id . '" data-id="' . $row->subject_id . '" ' . $is_checked . '>
                        <label class="custom-control-label" for="customCheck' . $row->subject_id . '"></label> </td>
                        <td>' . $row->subject_code . '</td>
                        <td>' . $row->subject_name . '</td>
                        <td>' . $row->preReqSubjectName . '</td>
                        <td>' . $row->lect_unit . '</td>
                        <td>' . $row->lab_unit . '</td>
                      </tr>';
        }
        $html .= '</tbody>
                </table>';
        return $html;
    }

    public function getSectionByBranchAndLevel(Request $request)
    {
        $branch_id = $request->branch;
        $level_id = $request->stud_level;
        $data['sections'] = SectionsTbl::where(array('branch_id' => $branch_id, 'level_id' => $level_id, 'is_active' => 1))->get();
        return $data;
    }

    //  Student Subjects
    public function schedule()
    {
        // Permissions
        $permissions = AccessRoute::user_permissions(session('user')->id);

        $user = \App\Models\StudentsTbl::where('user_id', session('user')->id)
            ->with(['enrollments.section.schedules.subject:id,subject_name,subject_code,subject_description', 'enrollments.section.schedules.room', 'enrollments.section.schedules.instructor:id,first_name,middle_name,last_name'])
            ->first();

        return view('dashboard.student.schedule', compact('permissions', 'user'));
    }

}
