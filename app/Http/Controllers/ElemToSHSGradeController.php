<?php

namespace App\Http\Controllers;

use App\Models\EnrollmentTbl;
use App\Models\Grade;
use App\Models\SectionsTbl;
use App\Models\StaffsTbl;
use App\Models\StudentsTbl;
use App\Utilities\AccessRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ElemToSHSGradeController extends Controller
{

    public function __construct()
    {
        $this->middleware('authenticated')->except('dashboard.grades.elem_shs_grades');
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

                $Sections = SectionsTbl::select(
                    "sections_tbls.*",
                    "levels_tbls.student_dept as student_dept"
                )
                    ->join("levels_tbls", "sections_tbls.level_id", "levels_tbls.id")
                    ->where("student_dept", "!=", "College");
            } else {

                $Employee = StaffsTbl::all()->where("user_id", session('user')->id)->first();

                $Sections = SectionsTbl::select(
                    "sections_tbls.*",
                    "levels_tbls.student_dept as student_dept"
                )
                    ->join("levels_tbls", "sections_tbls.level_id", "levels_tbls.id")
                    ->where([["student_dept", "!=", "College"], ["adviser_id", $Employee->id]]);
            }

            return DataTables::of($Sections)
                ->addIndexColumn()
                ->addColumn('action', function ($Sections) {

                    //button view
                    $button = '<span class="actionCust View"  title="View Students" data-id="' . md5($Sections->id) . '" ><a class="" href="deped_grade/' . $Sections->id . '"><i style="color:blue" class="fa fa-eye primary"></i></a></span>';


                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);
        }

        $data['title'] = "Elementary - SHS Encode Grades";
        $data['permissions'] = AccessRoute::user_permissions(session('user')->id);
        return view('dashboard.grades.elem_shs_grades', $data);
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
    public function store(Request $request)
    {
        //
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
        $sectionOne =  SectionsTbl::all()->where('id', $id);
        if (count($sectionOne) > 0) {
            if ($request->ajax()) {
                $students = StudentsTbl::select(
                    "students_tbls.id as student_id",
                    "sections_tbls.id as section_id",
                    "enrollment_tbls.*",
                    DB::raw("CONCAT(students_tbls.last_name, ', ',students_tbls.first_name, ' ',students_tbls.middle_name) as student_name")
                )
                    ->join("enrollment_tbls", "enrollment_tbls.student_id", "students_tbls.id")
                    ->join("sections_tbls", "enrollment_tbls.section_id", "sections_tbls.id")
                    ->where('section_id', $id)->get();

                return DataTables::of($students)
                    ->addIndexColumn()
                    ->addColumn('action', function ($students) {

                        //button view
                        $button = '<span class="actionCust editGrades"  title="View Grades" data-id="' . md5($students->id) . '" ><a class="" ><i class="fa fa-edit primary"></i></a></span>';


                        return $button; // Return Button
                    })
                    ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                    ->make(true);
            }
        } else {
            return "No records found";
        }
        $data['section'] = SectionsTbl::all()->where('id', $id)->first();
        $data['title'] = "Elementary - SHS Encode Grades";
        $data['permissions'] = AccessRoute::user_permissions(session('user')->id);
        return view('dashboard.grades.encode_elem_shs_grade', $data);
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
        $data['getDataById'] = Grade::select(
            "grades.*",
            "subject_tbls.subject_name as subject_name"
        )
            ->join("subject_tbls", "grades.subject_id", "subject_tbls.id")
            ->where(DB::raw('md5(grades.enrollment_id)'), $id)->get();
        $data['student'] = StudentsTbl::all()->where('id', $data['getDataById']->first()->student_id)->first();
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
