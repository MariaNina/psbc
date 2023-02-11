<?php

namespace App\Http\Controllers;

use App\Mail\UserDetailsMail;
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
use App\Models\SchedulesTbl;
use App\Models\SchoolYearTbl;
use App\Models\SectionsTbl;
use App\Models\StudentsTbl;
use App\Models\TermsTbl;
use App\Models\UsersTbl;
use App\Utilities\AccessRoute;
use App\Utilities\AuditTrail;
use App\Utilities\Filepond;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\StudentT;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Yajra\DataTables\DataTables;

class StudentsController extends Controller
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

            $StudentsTbl =
                StudentsTbl::select(
                    "students_tbls.*",
                    "users_tbls.user_name",
                    "users_tbls.is_active",
                    "users_tbls.id as u_id")
                    ->join('users_tbls', 'students_tbls.user_id', '=', 'users_tbls.id');
            /**use join for INNER JOIN to select students with user_ids only */

            return DataTables::of($StudentsTbl)
                ->addIndexColumn()
                ->addColumn('action', function ($StudentsTbl) {

                    $is_active = ($StudentsTbl->is_active == 1) ? 'deactivate' : 'activate';
                    //button QRCode
                    $button = '<span id="qrcode-data"  class="actionCust qrcode-data" title="Generate QRCode" data-id="' .$StudentsTbl->id . '"><a class=""><i class="fas fa-qrcode"></i></a></span>';

                    //button update
                    $button .= '<span class="actionCust editData" title="update student details" data-id="' . md5($StudentsTbl->id) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    $button .= '<span class="actionCust ' . $is_active . '"  title="' . $is_active . ' students application" data-id="' . md5($StudentsTbl->u_id) . '" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>';


                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);
        }
        $data['permissions'] = AccessRoute::user_permissions(session('user')->id);
        $data['terms'] = TermsTbl::where('is_active', 1)->get();
        $data['branches'] = BranchTbl::all();
        return view('dashboard.students', $data);
    }


    /**
     * Store a newly created resource in storage.
    *
    * @param \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request, $length = 12)
    {
        // if(!empty($_FILES["excel_selected"]["tmp_name"])){

        //     $allowed_ext = array('xls'.'xlxs');
        //     $file_array = explode(".",$_FILES["excel_selected"]["name"]);
        //     $file_ext = end($file_array);

        //     if(in_array($file_ext,$allowed_ext)){
        //         $path   = $_FILES["upload_template"]["tmp_name"];
        //         $object = IOFactory::load($path);
        //         // foreach($object->getActiveCell() as $worksheet)
        //         // {
        //         //     $highestRow = $worksheet->getHighestRow();
        //         //     $highestColumn = $worksheet->getHighestColumn();
        //         //     for($row=3; $row <= $highestRow; $row++)
        //         //     {

        //         //     }

        //         // }
        //     }

        // }


        $fullName = $request->first_name . " " . $request->middle_name . " " . $request->last_name;
        $characters = sha1(md5($fullName . "123456"));
        $characterLength = strlen($characters);
        $randomStr = '';
        for ($i = 0; $i < $length; $i++) {
            $randomStr = $characters[rand(0, $characterLength - 1)];
        }
        $salt = md5($randomStr);
        $password = sha1("PSBCNumber1", TRUE);
        $hashed_password = password_hash($password, PASSWORD_BCRYPT, [$salt]);
        if ($request->lrn != '') {
            $uname = $request->lrn;
        } else {
            $uname = $request->app_no_;
        }
        //save in users table
        $user = new UsersTbl();
        $user->branch_id = $request->school_branch;
        $user->full_name = $fullName;
        $user->user_name = $uname;
        $user->password = $hashed_password;
        $user->salt = $salt;
        $user->email = $request->email_address;
        $user->role_id = 3; //default student role
        $user->is_active = 1;
        Mail::to($user->email)->send(new UserDetailsMail("PSBCNumber1"));
        if ($user->save()) {

            $is_guardian_exist = GuardianTbl::where(array('first_name' => $request->g_first_name, 'middle_name' => $request->g_middle_name, 'last_name' => $request->g_last_name));

            if ($is_guardian_exist->count() > 0) {
                $guardian_id = $is_guardian_exist->first()->id;
            } else {
                $guardian = new GuardianTbl();
                $guardian->first_name = $request->g_first_name;
                $guardian->middle_name = $request->g_middle_name;
                $guardian->last_name = $request->g_last_name;
                $guardian->address = $request->g_address;
                $guardian->contact_number = $request->g_contact_number;
                $guardian->save();
                $guardian_id = $guardian->id;
            }
            $student = new StudentsTbl();

            $student->first_name = $request->first_name;
            $student->user_id = $user->id;
            $student->guardian_id = $guardian_id;
            $student->middle_name = $request->middle_name;
            $student->last_name = $request->last_name;
            $student->suffix_name = $request->suffix_name;
            $student->student_type = "Old";
            $student->lrn = $request->lrn;
            $student->citizenship = $request->citizenship;
            $student->religion = $request->religion;
            $student->email = $request->email_address;
            $student->birth_day = $request->birth_day;
            $student->gender = $request->gender;
            $student->address = $request->address;
            $student->contact_number = $request->contact_no;
            $student->save();
        }

    }

    /**
     * Display the specified resource.
    *
    * @param int $id
    * @return \Illuminate\Http\Response
    */
    public function show(Request $request,$id)
    {
        //
        // $data['student'] = StudentsTbl::select(
        //     DB::raw("CONCAT(students_tbls.last_name,', ',students_tbls.first_name,' ',students_tbls.middle_name) AS name"),
        //     "students_tbls.lrn as lrn","students_tbls.image as img"
        // )->where('id',$id)->first();
        $data['name'] = StudentsTbl::select(DB::raw("CONCAT(students_tbls.last_name,' ',students_tbls.first_name,' ',students_tbls.middle_name) as name"))->where('id',$id)->first();
        $data['lrn'] = StudentsTbl::select("students_tbls.lrn")->where('id',$id)->first();
        $data['img'] = StudentsTbl::select("students_tbls.image")->where('id',$id)->first();
        $data['parent_id'] = StudentsTbl::select("students_tbls.guardian_id")->where('id',$id)->first();
        $data['parent_contact'] = GuardianTbl::select("guardian_tbls.contact_number")->where('id',$data['parent_id']->guardian_id)->first();
        $data['department'] = EnrollmentTbl::select("enrollment_tbls.student_department")->where('student_id',$id)->first();
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
        $data['student_details'] = StudentsTbl::select(DB::raw('@rownum :=@rownum+1 as rowNum'),
            "students_tbls.*",
            "users_tbls.user_name",
            "users_tbls.branch_id",
            "users_tbls.is_active",
            'guardian_tbls.first_name AS g_first_name',
            'guardian_tbls.middle_name AS g_middle_name',
            'guardian_tbls.last_name AS g_last_name',
            'guardian_tbls.address AS g_address',
            'guardian_tbls.contact_number AS g_contact_number')
            ->leftJoin('guardian_tbls', 'guardian_tbls.id', '=', 'students_tbls.guardian_id')
            ->leftJoin('users_tbls', 'students_tbls.user_id', '=', 'users_tbls.id')
            ->where(DB::raw('md5(students_tbls.id)'), $id)->get();
        $data['branches'] = BranchTbl::all();
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
        //
        $userUpdate = UsersTbl::find($request->user_id);
        $userUpdate->branch_id = $request->school_branch;
        $userUpdate->save();

        $guardian = GuardianTbl::find($request->guardian_id);
        $guardian->first_name = $request->g_first_name;
        $guardian->middle_name = $request->g_middle_name;
        $guardian->last_name = $request->g_last_name;
        $guardian->address = $request->g_address;
        $guardian->contact_number = $request->g_contact_number;
        $guardian->save();

        $data['image'] = "";
        $update = StudentsTbl::where(DB::raw('md5(id)'), $id);
        $data['first_name'] = $request->first_name;
        $data['middle_name'] = $request->middle_name;
        $data['last_name'] = $request->last_name;
        $studentName = $data['first_name'] . $data['last_name'];
        $data['suffix_name'] = $request->suffix_name;
        $data['lrn'] = $request->lrn;
        $data['citizenship'] = $request->citizenship;
        $data['religion'] = $request->religion;
        $data['email'] = $request->email_address;
        $data['birth_day'] = $request->birth_day;
        $data['gender'] = $request->gender;
        $data['address'] = $request->address;
        $data['contact_number'] = $request->contact_no;
        if ($request->hasFile('studentImage')) { //check if it has file
            $image = $request->file('studentImage'); //get file
            $image_name = $studentName . '.' . $image->getClientOriginalExtension(); //create a unique file name
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
        $deactivate = UsersTbl::where(DB::raw('md5(id)'), $id);
        $data['is_active'] = $request->is_active;
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
            $destinationPath = asset('/uploads/student_docs/' . $row->document_file);
            $html .= '<li>
                        <td><a href="' . $destinationPath . '" target="_blank">' . $row->document_name . '</a></td>
                    </li>';
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
                $is_checked = in_array($row->id, $subject_ids) ? "checked" : "";
            } else {
                $is_checked = '';
            }
            $html .= '<tr>
                        <td><div class="custom-control custom-checkbox">
                        <input value="' . $row->id . '" name="subjects[]" type="checkbox" class="custom-control-input" id="customCheck' . $row->id . '" data-id="' . $row->id . '" ' . $is_checked . '>
                        <label class="custom-control-label" for="customCheck' . $row->id . '"></label> </td>
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
        $cur_id = $request->curriculum;
        $enrollment_id = $request->enrollment_id;
        $subject_ids = [];

        $assessment = EnrollmentTbl::select('subject_ids',)
            ->where('id', $enrollment_id);
        if ($assessment->count() > 0) {
            $subject_ids = json_decode($assessment->first()->subject_ids);
        }
        $subjects = CurriculumSubjectsTbl::select('curriculum_subjects_tbls.id',
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
                $is_checked = in_array($row->id, $subject_ids) ? "checked" : "";
            } else {
                $is_checked = '';
            }
            $html .= '<tr>
                        <td><div class="custom-control custom-checkbox">
                        <input value="' . $row->id . '" name="subjects[]" type="checkbox" class="custom-control-input" id="customCheck' . $row->id . '" data-id="' . $row->id . '" ' . $is_checked . '>
                        <label class="custom-control-label" for="customCheck' . $row->id . '"></label> </td>
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

        $latestSy = SchoolYearTbl::latest('school_years')->first();

        $user = NULL;
        $hasFirstTerm = false;
        $hasSecondTerm = false;
        $isKto10 = false;
        $secondTerm = NULL;
        $firstTerm = NULL;
        $hasSummer = false;
        $summer = NULL;

        $checkDepartment = EnrollmentTbl::whereRelation('school_year', 'school_years', $latestSy->school_years)
            ->whereRelation('student', 'user_id', session('user')->id)
            ->where('is_approved', 1)
            ->orderBy('date_submitted', 'desc')
            ->with('section')
            ->first();

        $enrollmentFor1stTerm = EnrollmentTbl::whereRelation('school_year', 'school_years', $latestSy->school_years)
            ->whereRelation('student', 'user_id', session('user')->id)
            ->whereRelation('term', 'term_name', '1st')
            ->where('is_approved', 1)
            ->orderBy('date_submitted', 'desc')
            ->with('section')
            ->count();

        $enrollmentForSecondTerm = EnrollmentTbl::whereRelation('school_year', 'school_years', $latestSy->school_years)
            ->whereRelation('student', 'user_id', session('user')->id)
            ->whereRelation('term', 'term_name', '2nd')
            ->where('is_approved', 1)
            ->orderBy('date_submitted', 'desc')
            ->with('section')
            ->count();

        $enrollmentForSummer = EnrollmentTbl::whereRelation('school_year', 'school_years', $latestSy->school_years)
            ->whereRelation('student', 'user_id', session('user')->id)
            ->whereRelation('term', 'term_name', 'Summer')
            ->where('is_approved', 1)
            ->orderBy('date_submitted', 'desc')
            ->with('section')
            ->count();


        // Check if SHS OR ABOVE
        if (!empty($checkDepartment->section->section_label) && !empty($checkDepartment->student_department) && $checkDepartment->student_department !== "Elementary" && $checkDepartment->student_department !== "JHS") {

            $firstTerm = SchedulesTbl::whereRelation('term', 'term_name', '1st')
                ->whereRelation('section', 'section_label', $checkDepartment->section->section_label)
                ->whereRelation('schoolYear', 'school_years', $latestSy->school_years)
                ->with(['room', 'subject:id,subject_name,subject_code,subject_description', 'instructor:id,first_name,middle_name,last_name'])
                ->get();

            $secondTerm = SchedulesTbl::whereRelation('term', 'term_name', '2nd')
                ->whereRelation('section', 'section_label', $checkDepartment->section->section_label)
                ->whereRelation('schoolYear', 'school_years', $latestSy->school_years)
                ->with(['room', 'subject:id,subject_name,subject_code,subject_description', 'instructor:id,first_name,middle_name,last_name'])
                ->get();

            if ($secondTerm->count() > 0 && $enrollmentForSecondTerm > 0) {
                // Has second term
                $hasSecondTerm = true;
            }

            if ($firstTerm->count() > 0 && $enrollmentFor1stTerm > 0) {
                $hasFirstTerm = true;
            }

        } else {
            // Elementary or JHS
            if (!empty($checkDepartment->section->section_label)) {
                $firstTerm = SchedulesTbl::whereRelation('term', 'term_name', 'N/A')
                    ->whereRelation('section', 'section_label', $checkDepartment->section->section_label)
                    ->whereRelation('schoolYear', 'school_years', $latestSy->school_years)
                    ->with(['room', 'subject:id,subject_name,subject_code,subject_description', 'instructor:id,first_name,middle_name,last_name'])
                    ->get();

                if ($firstTerm->count() > 0) {
                    $hasFirstTerm = true;
                }

                $isKto10 = true;
            }
        }

        if (!empty($checkDepartment->section->section_label)) {
            $summer = SchedulesTbl::whereRelation('term', 'term_name', 'Summer')
                ->whereRelation('section', 'section_label', $checkDepartment->section->section_label)
                ->whereRelation('schoolYear', 'school_years', $latestSy->school_years)
                ->with(['room', 'subject:id,subject_name,subject_code,subject_description', 'instructor:id,first_name,middle_name,last_name'])
                ->get();
        }
        if (!is_null($summer) && $enrollmentForSummer > 0) {
            // Has second term
            $hasSummer = true;
        }

        return view('dashboard.student.schedule', compact('permissions', 'user', 'isKto10', 'hasFirstTerm', 'firstTerm', 'secondTerm', 'hasSecondTerm', 'latestSy', 'summer', 'hasSummer'));
    }

    public function get_existing_lrn() 
    {
       $lrns = StudentsTbl::select('lrn')->where('lrn','<>','Not Set')->where('lrn','<>',NULL)->get();

       $lrn_array = [];
       foreach($lrns as $row){
           $lrn_array[] = $row->lrn;
       }
       return $lrn_array; //return arrays of cost_centers 
    }

    public function get_existing_email() 
    {
       $emails = UsersTbl::select('email')->get();

       $email_array = [];
       foreach($emails as $row){
           $email_array[] = $row->email;
       }
       return $email_array; //return arrays of cost_centers 
    }

    public function saveMultipleStudents($length = 12)
    {
        // initialize all the variables we will use

        //variables for saving student details
            $lrn = "Not Set";
            $first_name = "";
            $middle_name = "N/A";
            $last_name = "";
            $suffix_name ="N/A";
            $gender = "";
            $email = "";
            $birth_day = "";
            $excel_birth_day = "";
            $address = "";
            $contact_number = "";
            $check_lrn = $this->get_existing_lrn();
            $check_email = $this->get_existing_email();

        // Variables for guardians
            $g_first_name = "";
            $g_middle_name = "";
            $g_last_name = "";
            $g_address = "";
            $g_contact_number = "";

            $success = 0;
            $error = 0;
            

            if(session('user')->branch_id > 0){
                $school_branch = session('user')->branch_id;
            }else{
                $school_branch = 1;
            }

        if (!empty($_FILES["import_excel"]["tmp_name"])) {

            $path = $_FILES["import_excel"]["tmp_name"];
            // $object = IOFactory::load($path);
            $reader = IOFactory::createReader('Xlsx');
            $reader->setReadDataOnly(FALSE);
            $spreadsheet = $reader->load($path);
            
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestDataRow('B'); //highest row is the highest row in firstname

            /**
             * Check first if the template is valid
             */
            $template_headers = ['LRN','FIRSTNAME','MIDDLENAME','LASTNAME','SUFFIX NAME']; //we get the first 5 headers

            for( $col = 0; $col <= 4 ; $col++ ){

                $header = trim($worksheet->getCellByColumnAndRow($col+1, 2)->getValue());

                if($header !== $template_headers[$col]){

                    return response()->json([
                        'msg' => 'Invalid Template. Please use the template from the system', 'status' => 'error'
                    ]);

                }
            }
            //end of checking

            /**
             * Checking errors in data and if it is empty
             */

            $template_errors = 0;
            for( $row = 3 ; $row <= $highestRow ; $row++ ){
                
                $lrn = trim($worksheet->getCellByColumnAndRow(1, $row)->getValue());
                $first_name = trim($worksheet->getCellByColumnAndRow(2, $row)->getValue());
                $last_name = trim($worksheet->getCellByColumnAndRow(4, $row)->getValue());
                $gender = trim($worksheet->getCellByColumnAndRow(6, $row)->getValue());
                $email = trim($worksheet->getCellByColumnAndRow(7, $row)->getValue());
                $birth_day = trim($worksheet->getCellByColumnAndRow(8, $row)->getFormattedValue());
                $address = trim($worksheet->getCellByColumnAndRow(9, $row)->getValue());
                $contact_number = trim($worksheet->getCellByColumnAndRow(10, $row)->getValue());

                $g_first_name = trim($worksheet->getCellByColumnAndRow(11, $row)->getValue());
                $g_last_name = trim($worksheet->getCellByColumnAndRow(13, $row)->getValue());
                $g_address = trim($worksheet->getCellByColumnAndRow(14, $row)->getValue());

                if( $lrn != '' && in_array($lrn,$check_lrn) ){

                    $worksheet->getStyleByColumnAndRow(1,$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000'); //red
                    $template_errors = 1; //set error as true
                    
                }else{
                    $worksheet->getStyleByColumnAndRow(1,$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF'); //white
                }


                if($first_name == ""){

                    $worksheet->getStyleByColumnAndRow(2,$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000'); //red
                    $template_errors = 1; //set error as true
                }else{
                    $worksheet->getStyleByColumnAndRow(2,$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF'); //white
                }


                if($last_name == ""){

                    $worksheet->getStyleByColumnAndRow(4,$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000'); //red
                    $template_errors = 1; //set error as true
                }else{
                    $worksheet->getStyleByColumnAndRow(4,$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF'); //white
                }


                if($gender == "" || !in_array($gender,['Male','Female'])){

                    $worksheet->getStyleByColumnAndRow(6,$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000'); //red
                    $template_errors = 1; //set error as true
                }else{
                    $worksheet->getStyleByColumnAndRow(6,$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF'); //white
                }


                if($email == "" || !filter_var($email, FILTER_VALIDATE_EMAIL) ||  in_array( $email, $check_email)){

                    $worksheet->getStyleByColumnAndRow(7,$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000'); //red
                    $template_errors = 1; //set error as true
                }else{
                    $worksheet->getStyleByColumnAndRow(7,$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF'); //white
                }


                if($birth_day == "" || (strtotime($birth_day) === false)){
                    $worksheet->getStyleByColumnAndRow(8,$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000'); //red
                    $template_errors = 1; //set error as true
                }else{
                    $worksheet->getStyleByColumnAndRow(8,$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF'); //white
                }


                if($address == ""){
                    $worksheet->getStyleByColumnAndRow(9,$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000'); //red
                    $template_errors = 1; //set error as true
                }else{
                    $worksheet->getStyleByColumnAndRow(9,$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF'); //white
                }


                if($contact_number == ""){
                    $worksheet->getStyleByColumnAndRow(10,$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000'); //red
                    $template_errors = 1; //set error as true
                }else{
                    $worksheet->getStyleByColumnAndRow(10,$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF'); //white
                }

                if($g_first_name == ""){
                    $worksheet->getStyleByColumnAndRow(11,$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000'); //red
                    $template_errors = 1; //set error as true
                }else{
                    $worksheet->getStyleByColumnAndRow(11,$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF'); //white
                }


                if($g_last_name == ""){
                    $worksheet->getStyleByColumnAndRow(13,$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000'); //red
                    $template_errors = 1; //set error as true
                }else{
                    $worksheet->getStyleByColumnAndRow(13,$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF'); //white
                }

                if($g_address == ""){
                    $worksheet->getStyleByColumnAndRow(14,$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFF0000'); //red
                    $template_errors = 1; //set error as true
                }else{
                    $worksheet->getStyleByColumnAndRow(14,$row)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFFFF'); //white
                }
            }
            //end checking of data


            if($template_errors == 0){

                $student_emails =[];

                for ($row = 3; $row <= $highestRow; $row++) {

                    $lrn = trim($worksheet->getCellByColumnAndRow(1, $row)->getValue());
                    $first_name = trim($worksheet->getCellByColumnAndRow(2, $row)->getValue());
                    $middle_name = trim($worksheet->getCellByColumnAndRow(3, $row)->getValue());
                    $last_name = trim($worksheet->getCellByColumnAndRow(4, $row)->getValue());
                    $suffix_name = trim($worksheet->getCellByColumnAndRow(5, $row)->getValue());
                    $gender = trim($worksheet->getCellByColumnAndRow(6, $row)->getValue());
                    $email = trim($worksheet->getCellByColumnAndRow(7, $row)->getValue());
                    $excel_birth_day = trim($worksheet->getCellByColumnAndRow(8, $row)->getFormattedValue());
                    if($excel_birth_day != ''){
                        $unix_cap_on = ((int)$excel_birth_day - 25569) * 86400;
                        $birth_day = date("Y-m-d", $unix_cap_on);
                    }
                    $address = trim($worksheet->getCellByColumnAndRow(9, $row)->getValue());
                    $contact_number = trim($worksheet->getCellByColumnAndRow(10, $row)->getValue());
                    $g_first_name = trim($worksheet->getCellByColumnAndRow(11, $row)->getValue());
                    $g_middle_name = trim($worksheet->getCellByColumnAndRow(12, $row)->getValue());
                    $g_last_name = trim($worksheet->getCellByColumnAndRow(13, $row)->getValue());
                    $g_address = trim($worksheet->getCellByColumnAndRow(14, $row)->getValue());
                    $g_contact_number = trim($worksheet->getCellByColumnAndRow(15, $row)->getValue());


                    $fullName = $first_name . " " . $middle_name . " " . $last_name;
                    $characters = sha1(md5($fullName . "123456"));
                    $characterLength = strlen($characters);
                    $randomStr = '';
                    
                        for ($i = 0; $i < $length; $i++) {
                            $randomStr = $characters[rand(0, $characterLength - 1)];
                        }

                    $salt = md5($randomStr);
                    $password = sha1("PSBCNumber1", TRUE);
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT, [$salt]);

                        if ($lrn != '') {
                            $uname = $lrn;
                        } else {
                            $uname = $randomStr;
                        }

                    $is_student_exist = StudentsTbl::where('lrn',$lrn)->whereNotIn('lrn',["Not Set",NULL,""])->first();
                    $is_student_exist_in_users = UsersTbl::where('email',$email)->first();
                    
                    if($is_student_exist || $is_student_exist_in_users){
                    
                    }else{
                        $is_guardian_exist = GuardianTbl::where(array('first_name' => $g_first_name, 'middle_name' => $g_middle_name, 'last_name' => $g_last_name));

                        if ($is_guardian_exist->count() > 0) {
                            $guardian_id = $is_guardian_exist->first()->id;
                        } else {
                            $guardian = new GuardianTbl();
                            $guardian->first_name = $g_first_name;
                            $guardian->middle_name = $g_middle_name;
                            $guardian->last_name = $g_last_name;
                            $guardian->address = $g_address;
                            $guardian->contact_number = $g_contact_number;
                            $guardian->save();
                            $guardian_id = $guardian->id;
                        }

                    
                        $student = new StudentsTbl();
                        $student->guardian_id = $guardian_id;
                        $student->lrn = $lrn;
                        $student->first_name = $first_name;
                        $student->middle_name = $middle_name;
                        $student->last_name = $last_name;
                        $student->suffix_name = $suffix_name;
                        $student->email = $email;
                        $student->student_type = "Old";
                        $student->birth_day = $birth_day;
                        $student->gender = $gender;
                        $student->address = $address;
                        $student->contact_number = $contact_number;

                        if ($student->save()) {
                            //save in users table
                            $user = new UsersTbl();
                            $user->branch_id = $school_branch;
                            $user->full_name = $fullName;
                            $user->user_name = $uname;
                            $user->password = $hashed_password;
                            $user->salt = $salt;
                            $user->email = $email;
                            $user->role_id = 3; //default student role
                            $user->is_active = 1;
                            if($user->save()){
                                $update_student = StudentsTbl::find($student->id);
                                $update_student->user_id = $user->id;
                                $update_student->save();
                                array_push( $student_emails, $user->email);
                            }
            
                        }
                    } 
                }


            }else{
                    $newfileName = session('user')->id.$_FILES["import_excel"]["name"];
                    // Write an .xlsx file  
                    $writer = new Xlsx($spreadsheet); 

                    // Save .xlsx file to the files directory 
                   
                    // $writer->save(public_path('uploaded_student_templates/'.$newfileName));
                    // return response()->json(['status'=>'error','msg'=> 'Some values are not valid or already exist. Please try again. <a id="error_file" href="'.asset('uploaded_student_templates/'.$newfileName).'">Click to download</a>']);
                    $writer->save($newfileName);
                    return response()->json(['status'=>'error','msg'=> 'Some values are not valid or already exist. Please try again. <a id="error_file" href="'.asset($newfileName).'">Click to download</a>']);
            }
               
                
            //log to audit trail
            $new_data = $student_emails;
            $action_taken = 'Create';
            $description = 'Add Multiple Students';
            AuditTrail::logAuditTrail( $action_taken , $description , $new_data);

            //finally send email to all students
            foreach($student_emails as $email){
                try{
                    Mail::to($email)->send(new UserDetailsMail("PSBCNumber1"));

                }catch(Exception $e){
                    continue;
                }
            }
      
            //end of sendingemail

            return response()->json(['status'=>'success','msg'=> 'Successfully Added!']);
        }
    }
}
