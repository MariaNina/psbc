<?php

namespace App\Http\Controllers;

use App\Models\AboutSettings;
use App\Models\BranchCollegesProgramsMajorsTbl;
use App\Models\BranchTbl;
use App\Models\CampusPhotos;
use App\Models\CurriculumTbl;
use App\Models\DocumentsTbl;
use App\Models\DocumentTypeTbl;
use App\Models\EnrollmentTbl;
use App\Models\GuardianTbl;
use App\Models\HomeSettings;
use App\Models\LevelsTbl;
use App\Models\SchoolYearTbl;
use App\Models\StudentsTbl;
use Illuminate\Http\Request;
use App\Models\UsersTbl;
use App\Utilities\AuditTrail;
use App\Utilities\Filepond;
use App\Utilities\Helpers;
use Illuminate\Http\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EnrollmentController extends Controller
{

    /**
     * Display app listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['school_year'] = Helpers::currentSchoolYear('school_years');//place here selected school year
        $data['home'] = HomeSettings::first();
        $data['about'] = AboutSettings::first();
        $data['campus_photos'] = CampusPhotos::all();
        $data['branches'] = BranchTbl::all();


        if($data['home']->is_maintenance == true) {
            return view('ui.maintenance');
        }

        return view('landing.enrollment',$data);
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
    public function store(Request $request , $length = 12)
    {
        $app_no = $this->createApplicationNo($request->student_department);
        // $fullName = $request->first_name." ".$request->middle_name." ".$request->last_name;
        // $characters = sha1(md5($fullName . "123456"));
        // $characterLength = strlen($characters);
        // $randomStr = '';
        // for ($i = 0; $i < $length; $i++) {
        //     $randomStr = $characters[rand(0, $characterLength - 1)];
        // }
        // $salt = md5($randomStr);
        // $password = sha1("PSBCNumber1", TRUE);
        // $hashed_password = password_hash($password, PASSWORD_BCRYPT, [$salt]);
        // if($request->lrn != ''){
        //     $uname = $request->lrn;
        // }else{
        //     $uname = $app_no;
        // }
        //  //save in users table
        //  $user = New UsersTbl();
        //  $user->branch_id = $request->school_branch;
        //  $user->full_name = $fullName;
        //  $user->user_name = $uname;
        //  $user->password = $hashed_password;
        //  $user->salt = $salt;
        //  $user->email = $request->email_address;
        //  $user->role_id = 3; //default student role
        //  $user->is_active = 0;

        //  if ($request->has('image')) {

        //     $path = Filepond::saveFile($request, 'image', 'avatars_img');
        //     $user->image = $path;

        // }else{
        //     $user->image = NULL;
        // }

        //  if($user->save())
        //  {
                //guardian's info
                $gur_first_name = $request->guardian_first_name;
                $gur_middle_name = $request->guardian_middle_name;
                $gur_last_name = $request->guardian_last_name;

                $is_guardian_exist = GuardianTbl::where(array('first_name' => $gur_first_name, 'middle_name' => $gur_middle_name, 'last_name' => $gur_last_name));

                if($is_guardian_exist->count() > 0){
                    $guardian_id = $is_guardian_exist->first()->id;
                }else{
                    $guardian = New GuardianTbl();
                    $guardian->first_name = $gur_first_name;
                    $guardian->middle_name = $gur_middle_name;
                    $guardian->last_name = $gur_last_name;
                    $guardian->address = $request->guardian_address;
                    $guardian->contact_number = $request->guardian_contact_number;
                    $guardian->save();

                    $guardian_id = $guardian->id;
                }


                if($request->student_department == 'College'){
                    $other_details= [
                        'student_department' => $request->student_department,
                        'college_shs_track' => $request->college_shs_track,
                        'last_school_attended' => $request->last_school_attended,
                        'year_graduated' => $request->year_graduated,
                    ];
                }
                elseif($request->student_department == 'Graduate Studies'){
                    $other_details= [
                        'student_department' => $request->student_department,
                        'under_grad_program_taken' => $request->under_grad_program_taken,
                        'last_school_attended' => $request->last_school_attended,
                        'year_graduated' => $request->year_graduated,
                    ];
                }else{
                    $other_details= [
                        'last_school_attended' => $request->last_school_attended,
                        'year_graduated' => $request->year_graduated,
                    ];
                }

                //save student in student table
                $student = New StudentsTbl();
                // $student->user_id = $user->id;
                $student->guardian_id = $guardian_id;
                $student->first_name = $request->first_name;
                $student->middle_name = $request->middle_name;
                $student->last_name = $request->last_name;
                $student->email = $request->email_address;
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

                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $image_name = $app_no.'image.'.$image->getClientOriginalExtension(); //create a unique file name
                    $destinationPath = storage_path('app/public/student_images'); //path to save image 'url/public/uploads/...'
                    $image->move($destinationPath, $image_name); //move and save file to folder
                    $student->image = $image_name;
                }else{
                    $student->image = NULL;
                }


                if($student->save())
                {
                    $student_id = $student->id;
                    //enrollment tbl
                    $enroll = New EnrollmentTbl();
                    $enroll->application_no = $app_no;
                    $enroll->student_id = $student_id;
                    $enroll->level_id = $request->student_level;
                    $enroll->branch_id = $request->school_branch;
                    $enroll->student_type = $request->student_type;
                    $enroll->term_id = NULL; //
                    $enroll->curriculum_id = $request->curriculum; //
                    $enroll->school_year_id = Helpers::currentSchoolYear('id');
                    $enroll->section_id = NULL;
                    $enroll->student_department = $request->student_department;
                    $enroll->is_approved = 0;
                    $enroll->date_submitted	 = Helpers::currentTimestamp();
                    if($enroll->save())
                    {
                        //documents tbl
                        $documents = DocumentTypeTbl::where(array('student_dept' => $request->student_department, 'student_type' => $request->student_type))->get();
                        foreach($documents as $docs){


                            if ($request->hasFile('document_'.$docs->id)) { //check if it has file
                                $stud_docs = new DocumentsTbl();
                                $stud_docs->student_id = $student_id;
                                $image = $request->file('document_'.$docs->id); //get file
                                $image_name = $enroll->application_no.'_'.$docs->document_name.'.'.$image->getClientOriginalExtension(); //create a unique file name
                                $destinationPath = storage_path('app/public/student_docs'); //path to save image 'url/public/uploads/...'
                                $image->move($destinationPath, $image_name); //move and save file to folder
                                $stud_docs->document_type_id = $docs->id;
                                $stud_docs->document_file = $image_name; //declare to save in database
                                $stud_docs->save();
                            }else{
                                $stud_docs = new DocumentsTbl();
                                $stud_docs->student_id = $student_id;
                                $stud_docs->document_type_id = $docs->id;
                                $stud_docs->document_file = NULL;
                                $stud_docs->save();
                            }


                        }
                         //log to audit trail
                        // $new_data = $enroll;
                        // $action_taken = 'New Student Application';
                        // $description = 'New Student Application';
                        // AuditTrail::logAuditTrail( $action_taken , $description , $new_data);
                        //end log
                        return $enroll->application_no;
                    }
                }

        // }
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


    public function getLevelsByStudDept(Request $request)
    {
        $stud_dept = $request->stud_dept;
        $data['levels'] = LevelsTbl::where(array('student_dept' => $stud_dept, 'is_active' => 1))->get();
        return $data;
    }

    public function getCurriculumByStudDeptAndLevel(Request $request)
    {
        $stud_dept = $request->stud_dept;
        $stud_level = $request->stud_level;
        $branch_id = $request->branch_id;
        $school_year = SchoolYearTbl::where('is_active', 1)->first()->id;
        $data['levels'] = LevelsTbl::where(array('student_dept' => $stud_dept, 'is_active' => 1))->get();
        $data['curriculums'] = BranchCollegesProgramsMajorsTbl::select(
            "curriculum_tbls.id as id",
            "programs_tbls.program_name as pname",
            "majors_tbls.major_name as mname")
            ->leftJoin('program_majors_tbls', 'branch_colleges_programs_majors_tbls.program_major_id', '=', 'program_majors_tbls.id')
            ->leftJoin('programs_tbls', 'program_majors_tbls.program_id', '=', 'programs_tbls.id')
            ->leftJoin('majors_tbls', 'program_majors_tbls.major_id', '=', 'majors_tbls.id')
            ->leftJoin('curriculum_tbls', 'curriculum_tbls.program_major_id', '=', 'program_majors_tbls.id')
            ->where('branch_colleges_programs_majors_tbls.branch_id',$branch_id)
            ->where('curriculum_tbls.school_year_id',$school_year)
            ->where('curriculum_tbls.level_id',$stud_level)
            ->where('curriculum_tbls.student_department', $stud_dept)
            ->where('curriculum_tbls.is_active',1)->get();
        return $data;
    }

    public function getDocumentsByStudDeptAndType(Request $request)
    {
        $stud_dept = $request->stud_dept;
        $stud_type = $request->stud_type;
        $data['documents'] = DocumentTypeTbl::where(array('student_dept' => $stud_dept, 'student_type' => $stud_type))->get();
        return $data;
    }
    public function checkEmail(Request $request)
    {
        $user = UsersTbl::where('email', '=', $request->email)->first();
        if ($user == NULL) {
            return 0;
        }else{
            return 1;
        }
    }

    public function applicationForm($app_no) {

        // SELECT a.*, b.fees, c.id, CASE WHEN a.is_approved = 0 THEN 'For Approval' WHEN a.is_approved = 1 THEN CASE WHEN b.fees is null THEN 'For Assessment' ELSE CASE WHEN c.id is null THEN 'For Payment' ELSE 'Enrolled' END END ELSE 'Rejected' END AS STATUS FROM `enrollment_tbls` a LEFT JOIN assessments_tbls b ON (a.id = b.enrollment_id) LEFT JOIN payment_history_tbls c ON (b.id = c.assessments_id);
        $app_no = $app_no;
        $data['app_no'] = $app_no;
        $data['details'] = EnrollmentTbl::select("enrollment_tbls.*",
        "assessments_tbls.fees",
        "payment_history_tbls.id",
            DB::raw("CASE WHEN enrollment_tbls.is_approved = 0 THEN 'For Approval' WHEN enrollment_tbls.is_approved = 1 THEN CASE WHEN assessments_tbls.fees is null THEN 'For Assessment' ELSE CASE WHEN payment_history_tbls.id is null THEN 'For Payment' ELSE 'Enrolled' END END ELSE 'Rejected' END AS app_status"))
        ->leftJoin('assessments_tbls', 'enrollment_tbls.id', '=', 'assessments_tbls.enrollment_id')
        ->leftJoin('payment_history_tbls', 'assessments_tbls.id', '=', 'payment_history_tbls.assessments_id')
        ->where('enrollment_tbls.application_no', $app_no)->first();
        $data['home'] = HomeSettings::first();
        $data['about'] = AboutSettings::first();
        $data['campus_photos'] = CampusPhotos::all();
        $data['branches'] = BranchTbl::all();


        if($data['home']->is_maintenance == true) {
            return view('ui.maintenance');
        }
        return view('landing.application',$data);
    }
}
