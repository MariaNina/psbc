<?php
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AboutSettingsController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AssessmentsController;
use App\Http\Controllers\AuditTrailController;
use App\Http\Controllers\BranchCollegeProgramMajorController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CollegeAttendanceHistoryController;
use App\Http\Controllers\CollegeController;
use App\Http\Controllers\CollegeGradeController;
use App\Http\Controllers\CollegeAttendanceView;
use App\Http\Controllers\CurriculumController;
use App\Http\Controllers\CurriculumSubjectsController;
use App\Http\Controllers\CutOffSettingsController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DatatableController;
use App\Http\Controllers\DeductionController;
use App\Http\Controllers\DiscountsController;
use App\Http\Controllers\DocumentSettingsController;
use App\Http\Controllers\ElemToSHSGradeController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\EnrollmentHistoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\FeesController;
use App\Http\Controllers\GradeSettingController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\HomeSettingsController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MajorController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ParentsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProgramMajorController;
use App\Http\Controllers\ProgramSettingsController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SalarySettingsController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\SchoolYearController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StaffAttendanceController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffDeductionController;
use App\Http\Controllers\StaffDiscountController;
use App\Http\Controllers\StaffOtherEarningController;
use App\Http\Controllers\StaffProfileController;
use App\Http\Controllers\StudentGradeController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\StudentsEnrollmentController;
use App\Http\Controllers\StudentsEnrollmentHistoryController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TermController;
use App\Http\Controllers\TimeSettingsController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ScanController;
use App\Mail\UserDetailsMail;
use App\Models\BranchCollegesProgramsMajorsTbl;
use App\Models\EnrollmentTbl;
use App\Models\ProgramMajorsTbl;
use App\Models\SchoolYearTbl;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::fallback(function () {
    return view('ui.404');
});
// ================= SETTINGS =========================  //
// Events
Route::get('/events/datatable', [EventController::class, 'datatable']);
Route::resource('events', EventController::class)->except(['create']);

// Announcement
Route::get('/all-announcements', [AnnouncementController::class, 'announcements']);
Route::resource('announcements', AnnouncementController::class)->except(['create']);

// Settings - Home
Route::get('/', [HomeSettingsController::class, 'home'])->name('landing.home');

Route::post('/settings/maintenance', [HomeSettingsController::class, 'maintenance']);

Route::post('/campus', [HomeSettingsController::class, 'addCampusImage'])->name('landing.campus');

Route::delete('/campus/{photo}', [HomeSettingsController::class, 'deleteCampusImage'])->name('landing.campus');

Route::resource('settings', HomeSettingsController::class)->only([
    'index', 'update'
]);

// About
Route::resource('about', AboutSettingsController::class)->only([
    'index', 'update'
]);

Route::resource('our-programs', ProgramSettingsController::class)->only([
    'index', 'update', 'store', 'destroy', 'show'
]);

// ================= END OF SETTINGS =========================  //

// ======== AUTHENTICATION ============ //

Route::get('login', [LoginController::class, 'index'])->name('login');

Route::post('/login', [LoginController::class, 'login']);

Route::post('logout', [LoginController::class, 'logout']);

// ===== END OF AUTH ====== //


// ==== ENROLLMENT ===== //

Route::resource('enrollment', EnrollmentController::class);

Route::post('/enrollment/getLevelsByStudDept', [EnrollmentController::class, 'getLevelsByStudDept']);

Route::post('/enrollment/getCurriculumByStudDeptAndLevel', [EnrollmentController::class, 'getCurriculumByStudDeptAndLevel']);

Route::post('/enrollment/getDocumentsByStudDeptAndType', [EnrollmentController::class, 'getDocumentsByStudDeptAndType']);

Route::get('application/{app_no}', [EnrollmentController::class, 'applicationForm']);
// ==== END OF ENROLLMENT ===  //

Route::group(['middleware' => ['XSS', 'authenticated']], function () {

    //Login Route
    Route::get('/get_latest_students', [DashboardController::class, 'getLatestStudents']);
    Route::get('/get_latest_employees', [DashboardController::class, 'getLatestEmployees']);
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/sections', [DashboardController::class, 'sections'])->name('dashboard.section');

    //SchoolYear Routes
    Route::resource('school_years', SchoolYearController::class)->middleware('has_permission:school_years');
    Route::resource('branches', BranchController::class)->middleware('has_permission:branches');


    //Curriculum Routes
    Route::resource('curriculums', CurriculumController::class)->middleware('has_permission:curriculums');

    //College Routes
    Route::resource('colleges', CollegeController::class)->middleware('has_permission:colleges');

    // Subject Route
    Route::resource('subjects', SubjectController::class)->middleware('has_permission:subjects');

    // Programs Route
    Route::resource('programs', ProgramController::class)->middleware('has_permission:programs');

    // Majors Route
    Route::resource('majors', MajorController::class)->middleware('has_permission:majors');

    //Levels Route
    Route::resource('levels', LevelController::class)->middleware('has_permission:levels');

    //Program Major Route
    Route::resource('programmajors', ProgramMajorController::class)->middleware('has_permission:programmajors');

    //Term Route Route
    Route::resource('terms', TermController::class)->middleware('has_permission:terms');

    //Room Route Route
    Route::resource('rooms', RoomController::class)->middleware('has_permission:rooms');

    //Branch College Majors Route
    Route::resource('branch_college_program_majors', BranchCollegeProgramMajorController::class)
        ->middleware('has_permission:branch_college_program_majors');

    //Section Route Route
    Route::resource('sections', SectionController::class)->middleware('has_permission:sections');


    //Staff Route
    Route::prefix('staff_profile')->group(function () {
        Route::get('/', [StaffProfileController::class, 'index'])->name('staff_profile');
        Route::put('/basic_info', [StaffProfileController::class, 'basicInfo']);
        Route::put('/account_details', [StaffProfileController::class, 'accountDetails']);
        Route::put('/address_details', [StaffProfileController::class, 'addressDetails']);
        Route::put('/other_card_details', [StaffProfileController::class, 'otherCardDetails']);
        Route::put('/change_password', [StaffProfileController::class, 'changePassword']);
        Route::put('/change_avatar', [StaffProfileController::class, 'changeAvatar']);
    });

    Route::resource('employees', StaffController::class)->middleware('has_permission:employees');

    //User Route
    Route::post('/update_user_permission/{id}', [UserController::class, 'updateUsersPermission']);
    Route::put('/users/reset-password', [UserController::class, 'resetPassword'])->middleware('has_permission:users');
    Route::resource('users', UserController::class)->middleware('has_permission:users');

    //Role Route
    Route::resource('roles', RoleController::class)->middleware('has_permission:roles');

    //Page Route
    Route::get('/all_pages', [PageController::class, 'getAllPages']);
    Route::get('/users_pages/{id}', [PageController::class, 'getUserPages']);

    Route::resource('pages', PageController::class)->middleware('has_permission:pages');

    //Schedule Route
    Route::get('/college_schedule', [ScheduleController::class, 'collegeSchedule'])->name('schedule.college');
    Route::get('/college_schedule/datatable/{id}', [ScheduleController::class, 'collegeScheduleDatatable'])->name('schedule.college.datatable');
    Route::post('/college_schedule', [ScheduleController::class, 'collegeScheduleStore'])->name('schedule.college.store');
    Route::delete('/college_schedule/{schedulesTbl}', [ScheduleController::class, 'collegeScheduleDestroy'])->name('schedule.college.destroy');


    Route::resource('/schedule', ScheduleController::class)->middleware('has_permission:schedule');
    Route::get('/all_datas/{type?}', [ScheduleController::class, 'getDatas']);
    Route::get('/all_schedule/{id}', [ScheduleController::class, 'getAllSchedule']);
    // DataTable Sample
    Route::get('/datatable', [DatatableController::class, 'index'])->name('datable.index');
    Route::get('/curriculums', [CurriculumController::class, 'getCurriculums'])->name('curriculum.getCurriculums');
    //Curriculum Routes
    Route::resource('curriculum_subjects', CurriculumSubjectsController::class)->middleware('has_permission:curriculum_subjects');
    Route::resource('curriculum_subjects', CurriculumSubjectsController::class)->middleware('has_permission:curriculum_subjects');

    //Grades Routes
    Route::get('/my_grades', [StudentGradeController::class, 'index'])->name('student.grade.index');

    Route::put('/grade_settings/toggle_showing_deped_grade', [GradeSettingController::class, 'toggleShowingDepedGrades']);
    Route::put('/grade_settings/toggle_showing_ched_grade', [GradeSettingController::class, 'toggleShowingChedGrades']);

    Route::resource('grade_settings', GradeSettingController::class)->middleware('has_permission:grade_settings');
    Route::resource('deped_grade', ElemToSHSGradeController::class)->middleware('has_permission:deped_grade');
    Route::resource('college_grade', CollegeGradeController::class)->middleware('has_permission:college_grade');

    // SHS
    // Route::view('/shs/registration', 'print.shs.shsreg');
    Route::view('/shs/fees', 'print.shs.shsfees');

    // College
    Route::get('/assessmentForm', [PrintController::class, 'printAssessmentForm']);

    //Document Setting
    Route::resource('document_settings', DocumentSettingsController::class)->middleware('has_permission:document_settings');


    //Students Controller
    Route::get('/my_schedule', [StudentsController::class, 'schedule'])->name('student.schedule');
    Route::resource('students', StudentsController::class)->middleware('has_permission:students');
    // Route::post('/students/getDocuments', [StudentsController::class, 'getDocuments']);
    Route::post('/students/saveMultipleStudents', [StudentsController::class, 'saveMultipleStudents']);
    Route::post('/students/getSubjectByCurAjax', [StudentsController::class, 'getSubjectByCurAjax']);
    Route::post('/students/getSubjectByCurAdam', [StudentsController::class, 'getSubjectByCurAdam']);
    //Students Controller

    //Students Enrollment Controller
    Route::get('/students_enrollment/get_strand', [StudentsEnrollmentController::class, 'getCurriculumStrandByDepartment']);
    Route::get('/students_enrollment/{branch?}/{department?}/{strand?}', [StudentsEnrollmentController::class, 'index'])->name('student.students');
    Route::resource('students_enrollment', StudentsEnrollmentController::class)->except(['index']);
    Route::post('/students_enrollment/getDocuments', [StudentsEnrollmentController::class, 'getDocuments']);
    Route::post('/students_enrollment/getSectionByBranchAndLevel', [StudentsEnrollmentController::class, 'getSectionByBranchAndLevel']);
    Route::post('/students_enrollment/getSubjectByCurAjax', [StudentsEnrollmentController::class, 'getSubjectByCurAjax']);
    Route::post('/students_enrollment/getSubjectByCurAjaxAdd', [StudentsEnrollmentController::class, 'getSubjectByCurAjaxAdd']);
      Route::post('/students_enrollment/getStudentData', [StudentsEnrollmentController::class, 'getStudentData']);
    //Students Enrollment Controller

    // Route::resource('students', StudentsController::class);

    // Profile
    Route::prefix('profile')->group(function () {
        Route::get('/', [StudentProfileController::class, 'index'])->name('profile.index');
        Route::put('/basic_info', [StudentProfileController::class, 'basicInfo']);
        Route::put('/account_details', [StudentProfileController::class, 'accountDetails']);
        Route::put('/address_details', [StudentProfileController::class, 'addressDetails']);
        Route::put('/guardian_details', [StudentProfileController::class, 'guardianDetails']);
        Route::put('/change_password', [StudentProfileController::class, 'changePassword']);
        Route::put('/change_avatar', [StudentProfileController::class, 'changeAvatar']);
        Route::put('/document_details', [StudentProfileController::class, 'document_details']);
    });

    //Fees Controller
    Route::resource('fees', FeesController::class)->middleware('has_permission:fees');

    //Discounts Controller
    Route::resource('discounts', DiscountsController::class)->middleware('has_permission:discounts');

    //Assessments Routes
    Route::get('/assessments/get_programs', [AssessmentsController::class, 'getPrograms'])->name('assessments.getPrograms');
    Route::get('/assessments/total_balances', [AssessmentsController::class, 'getTotalBalances'])->name('assessments.getTotalBalances');
    Route::post('/assessments/getStudentDetailsByEnrollmentId', [AssessmentsController::class, 'getStudentDetailsByEnrollmentId']);
    Route::post('/assessments/getFeesByDepartment', [AssessmentsController::class, 'getFeesByDepartment']);
    Route::post('/assessments/getFeeAmount', [AssessmentsController::class, 'getFeeAmount']);

    Route::post('/assessments/getDiscountsByDepartment', [AssessmentsController::class, 'getDiscountsByDepartment']);
    Route::post('/assessments/getDiscountAmount', [AssessmentsController::class, 'getDiscountAmount']);

    // Route::get('/assessments/{level?}', [AssessmentsController::class, 'index'])->name('assessments.index')->middleware('has_permission:assessments');
    // Route::resource('assessments', AssessmentsController::class)
    //     ->except(['index'])->middleware('has_permission:assessments');

   Route::resource('assessments', AssessmentsController::class)
        ->middleware('has_permission:assessments');
    //Payments Route
    Route::get('/payments', [PaymentsController::class, 'index']);
    Route::get('/payments_filter/{dateToFilter?}/level/{level?}', [PaymentsController::class, 'filterPayments']);
    Route::post('/payments/total', [PaymentsController::class, 'getTotalIncome']);
    Route::resource('payments', PaymentsController::class)->except(['index']);
    Route::post('payments/savePayments', [PaymentsController::class, 'savePayments']);

    // Time Settings
    Route::resource('time_settings', TimeSettingsController::class);

    //Enrollment History Route
    Route::resource('enrollment_history', StudentsEnrollmentHistoryController::class);

    //Payments Route
    Route::resource('payments', PaymentsController::class);

    // Ajax Reference
    Route::resource('people', PeopleController::class);

    //Payments Route
    Route::resource('parents', ParentsController::class);

    //Audit Trail Route
    Route::resource('audit_trail', AuditTrailController::class);

});


// Upload
Route::post('/upload', [UploadController::class, 'upload']);
Route::post('/upload_file/{saveToFolder?}', [UploadController::class, 'store']);

// Registration Forms
// Elem -> JHS
// Route::view('/elementary/registration', 'print.elem_jhs.elemreg');
Route::view('/elementary/fees', 'print.elem_jhs.elemfees');
Route::view('/elementary/final', 'print.elem_jhs.elemfinal');

Route::get('/email', function () {
    Mail::to('psbc@iampsbc.com')->send(new UserDetailsMail("PSBCNumber1"));
});

//Holiday Settings
Route::resource('holiday_settings', HolidayController::class)->middleware('has_permission:holiday_settings');
//Deduction Settings
Route::resource('deduction_settings', DeductionController::class)->middleware('has_permission:deduction_settings');
//Salary Settings
Route::resource('salary_settings', SalarySettingsController::class)->middleware('has_permission:salary_settings');

Route::resource('staff_deductions', StaffDeductionController::class)->middleware('has_permission:staff_deductions');

Route::resource('staff_other_earnings', StaffOtherEarningController::class)->middleware('has_permission:staff_other_earnings');

Route::resource('staff_attendance', StaffAttendanceController::class)->middleware('has_permission:staff_attendance');
Route::post('/staff_attendance/saveAttendance', [StaffAttendanceController::class, 'saveAttendance']);
Route::get('payslip', [SalarySettingsController::class, 'getPayslip'])->middleware('has_permission:payslip');
Route::get('payslip/all', [SalarySettingsController::class, 'getAllPayslip'])->middleware('has_permission:payslip');
Route::get('payslip/summary', [SalarySettingsController::class, 'payslipSummary'])->middleware('has_permission:payslip');
Route::get('payslip/{staff_id}', [SalarySettingsController::class, 'getPayslipData']);
Route::get('/view_payslip', [SalarySettingsController::class, 'viewPayslip']);
Route::post('/getSinglePayslip', [SalarySettingsController::class, 'getSinglePayslip']);
Route::get('/view_college_payslip', [SalarySettingsController::class, 'viewCollegePayslip']);
Route::get('view_college_payslip/all', [SalarySettingsController::class, 'getAllCollegePayslip'])->middleware('has_permission:payslip');
//Cutoff
Route::resource('cutoff_settings', CutOffSettingsController::class)->middleware('has_permission:cutoff_settings');

//college attendance history
Route::resource('college_attendance_histories', CollegeAttendanceHistoryController::class);
Route::resource('college_attendance_view', CollegeAttendanceView::class);

//Scanner Controller
Route::resource('scan', ScanController::class)->middleware('has_permission:school_years');

Route::get('/get_student', function (Request $request) {
    return DB::select("CALL get_student()");
});
