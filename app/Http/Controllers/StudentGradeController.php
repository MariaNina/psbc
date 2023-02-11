<?php

namespace App\Http\Controllers;

use App\Models\EnrollmentTbl;
use App\Models\Grade;
use App\Models\GradeSettings;
use App\Models\ProgramsTbl;
use App\Models\SchoolYearTbl;
use App\Models\ShowGrades;
use App\Utilities\AccessRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class StudentGradeController extends Controller
{
    public function index(Request $request)
    {
        $id = session('user')->id; // User ID

        // Latest School Year
        $sy = SchoolYearTbl::latest('school_years')->where("is_active", '1')->first();

        DB::statement(DB::raw('set @rownum=0'));

        $enrollment = EnrollmentTbl::whereRelation('student', 'user_id', $id)
            ->whereRelation('school_year', 'school_years', $sy->school_years)
            ->where('is_approved', 1)
            //->latest('date_submitted') // Latest Enrollment
            ->with(['grades' => function ($query) {
                $query->select('*', DB::raw('@rownum :=@rownum+1 as No'));
            }, 'grades.subjects'])
             ->first(['id', 'student_id',  'student_department', 'is_approved']);

        $deped = array('elementary', 'jhs', 'shs');
        $department = (!empty($enrollment->student_department)) ? strtolower($enrollment->student_department) : '';

        $showGrades = ShowGrades::orderBy('id', 'asc')->first();

        $canShow = null;
        $isCollege = false;

        if (in_array($department, $deped)) {
            $canShow = $showGrades->show_deped_grade;
        } else {
            $canShow = $showGrades->show_ched_grade;
            $isCollege = true;
        }

        $permissions = AccessRoute::user_permissions($id);

        return view('dashboard.student.grades', compact('permissions', 'enrollment', 'canShow', 'isCollege'));
    }
}
