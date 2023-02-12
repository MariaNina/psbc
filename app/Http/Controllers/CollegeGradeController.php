<?php

namespace App\Http\Controllers;

use App\Models\EnrollmentTbl;
use App\Models\Grade;
use App\Models\SectionsTbl;
use App\Models\StaffsTbl;
use App\Models\StudentsTbl;
use App\Models\SubjectTbl;
use App\Utilities\AccessRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class CollegeGradeController extends Controller
{
    public $globalId;
    public function __construct()
    {
        $this->middleware('authenticated')->except('dashboard.grades.college_grade');
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

            if (session('user')->role == "Super Admin") {

                $Subjects = SubjectTbl::where("is_for_college", 1);
            } else {

                $Subjects = SubjectTbl::select(
                    "subject_tbls.*",
                    "schedules_tbls.id as sched_id",
                    "schedules_tbls.staff_id as staff_id"
                )
                    ->join("schedules_tbls", "schedules_tbls.subject_id", "subject_tbls.id")
                    ->where("is_for_college", 1)->where("schedules_tbls.staff_id", session('user')->staff_id)->get();
            }

            return DataTables::of($Subjects)
                ->addIndexColumn()
                ->addColumn('action', function ($Subjects) {

                    //button view
                    $button = '<span class="actionCust View"  title="View Students" data-id="' . md5($Subjects->id) . '" ><a class="" href="college_grade/' . $Subjects->id . '"><i style="color:blue" class="fa fa-eye primary"></i></a></span>';


                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);
        }
        $data['title'] = "College Encode Grades";
        $data['permissions'] = AccessRoute::user_permissions(session('user')->id);
        return view('dashboard.grades.college_grade', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function show(Request $request, $id)
    {
        //

        DB::statement(DB::raw('set @rownum=0'));
        $sectionOne =  SubjectTbl::all()->where('id', $id);
        if (count($sectionOne) > 0) {
            if ($request->ajax()) {
                $students = Grade::select(
                    DB::raw('@rownum :=@rownum+1 as rowNum'),
                    "students_tbls.id as std_id",
                    "students_tbls.last_name",
                    "enrollment_tbls.*",
                    "grades.*",
                    "grades.subject_id as grade_id",
                    DB::raw("CONCAT(students_tbls.last_name, ', ',students_tbls.first_name, ' ',students_tbls.middle_name) as student_name")
                )
                    ->Leftjoin("enrollment_tbls", "enrollment_tbls.id", "grades.enrollment_id")
                    ->Leftjoin("students_tbls", "students_tbls.id", "grades.student_id")
                    ->where('grades.subject_id', $id)->get();

                return DataTables::of($students)
                    ->addIndexColumn()
                    ->addColumn('action', function ($students) {

                        //button view
                        $button = '<span class="actionCust editGrades"  title="Edit Grades" id="' . $students->grade_id . '" data-id="' . md5($students->std_id) . '" ><a class="" ><i class="fa fa-edit primary"></i></a></span>';


                        return $button; // Return Button
                    })
                    ->addColumn('No', function ($students) {
                        return $students->rowNum; // Return Row NUmber
                    })
                    ->rawColumns(['No', 'action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                    ->make(true);
            }
        } else {
            return "No records found";
        }
        $data['subject'] = SubjectTbl::all()->where('id', $id)->first();
        $data['title'] = "Collge Grades";
        $data['permissions'] = AccessRoute::user_permissions(session('user')->id);
        $this->globalId = $id;
        return view('dashboard.grades.encode_collge_grade', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
        $data['getDataById'] = Grade::select(
            "grades.*",
            "subject_tbls.subject_name as subject_name"
        )
            ->join("subject_tbls", "grades.subject_id", "subject_tbls.id")
            ->where(DB::raw('md5(student_id)'), $id)->where('grades.subject_id', $request->id)->get();
        $data['student'] = StudentsTbl::all()->where('id', $data['getDataById'][0]->student_id)->first();
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
        $nums = count($request->grades);
        $x = 0;
        while ($x < $nums) {
            $update = Grade::where([['id', $request->gradeName[$x]], [DB::raw('md5(student_id)'), $id]]);
            $data['grade'] = $request->grades[$x];
            $update->update($data);
            $x++;
        }
    }
}
