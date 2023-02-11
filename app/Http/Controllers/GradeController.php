<?php

namespace App\Http\Controllers;

use App\Models\EnrollmentTbl;
use App\Models\Grade;
use App\Models\SectionsTbl;
use App\Models\StaffsTbl;
use App\Models\StudentsTbl;
use App\Models\SubjectTbl;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Utilities\AccessRoute;
use Illuminate\Support\Facades\DB;

class GradeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        DB::statement(DB::raw('set @rownum=-1'));
        $data['students'] = StudentsTbl::select(
            DB::raw('@rownum :=@rownum+1 as rowNum'),
            DB::raw("CONCAT(students_tbls.last_name, ', ',students_tbls.first_name, ' ',students_tbls.middle_name) as student_name"),
            "sections_tbls.section_label as section_label",
            "enrollment_tbls.subject_ids as subjects",
            "grades.grades as grades",
            "grades.id as grade_id",
            "grades.enrollment_id as enrollment_id")
            ->join('grades', 'grades.student_id', '=', 'students_tbls.id')
            ->join('enrollment_tbls', 'grades.enrollment_id', '=', 'enrollment_tbls.id')
            ->join('sections_tbls', 'enrollment_tbls.section_id', '=', 'sections_tbls.id');
        // $array = $data['students'][0]->subjects;
        // $data['subjects'] =SubjectTbl::all("id","subject_name")->whereIn('id',json_decode($array));
        $data['staff'] = StaffsTbl::all()->where('user_id',session('user')->id)->first();
        if(session('user')->role=="Super Admin" || $data['staff']->position =="Registrar" || session('user')->role=="Registrar"){
            $data['sections'] =SectionsTbl::all()->where('branch_id',session('user')->branch_id);
        }else{
        $data['sections'] =SectionsTbl::select('sections_tbls.*')->where('adviser_id',$data['staff']->id)->get();
        }
        $data['permissions'] = AccessRoute::user_permissions(session('user')->id);
        $data['title'] ="Encode Grades";
        // for($i =0; $i<2; $i++){
        // $data['grade'][$i] = json_decode($data['students'][$i]->grades);
        // }
        
        return view("dashboard.list_section",$data);
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
    public function show($id)
    {
        //
        DB::statement(DB::raw('set @rownum=-1'));
        $data['students'] = StudentsTbl::select(
            DB::raw('@rownum :=@rownum+1 as rowNum'),
            DB::raw("CONCAT(students_tbls.last_name, ', ',students_tbls.first_name, ' ',students_tbls.middle_name) as student_name"),
            "sections_tbls.section_label as section_label",
            "sections_tbls.id as section_id",
            "enrollment_tbls.subject_ids as subjects",
            "grades.grades as grades",
            "grades.id as grade_id",
            "enrollment_tbls.section_id as section_id",
            "grades.enrollment_id as enrollment_id")
            ->join('grades', 'grades.student_id', '=', 'students_tbls.id')
            ->join('enrollment_tbls', 'grades.enrollment_id', '=', 'enrollment_tbls.id')
            ->join('sections_tbls', 'enrollment_tbls.section_id', '=', 'sections_tbls.id')
            ->where('sections_tbls.id',$id)->get();
        $data['stud_num'] =count($data['students']);
        if($data['stud_num']==0){
            $data['staff'] = StaffsTbl::all()->where('user_id',session('user')->id)->first();
        $data['sections'] =SectionsTbl::select('sections_tbls.*')->where('id',$id)->first();
        $data['permissions'] = AccessRoute::user_permissions(session('user')->id);
        $data['title'] ="Encode Grades";
            return view("dashboard.encode_grade",$data);
        }else{
        $array = $data['students'][0]->subjects;
        $data['subjects'] =SubjectTbl::all("id","subject_name")->whereIn('id',json_decode($array));
        $data['staff'] = StaffsTbl::all()->where('user_id',session('user')->id)->first();
        
        $data['sections'] =SectionsTbl::select('sections_tbls.*')->where('id',$id)->first();
        $data['permissions'] = AccessRoute::user_permissions(session('user')->id);
        $data['title'] ="Encode Grades";
        $data['num'] = count($data['students']);
        $data['countSubject'] = count($data['subjects']);
        for($i =0; $i<$data['num']; $i++){
        $data['grade'][$i] = json_decode($data['students'][$i]->grades);
        }
        }
        return view("dashboard.encode_grade",$data);
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
        $data['getDatabyId'] = Grade::where('id', $id)->first();
        $data['enrollment'] = EnrollmentTbl::where('id',$data['getDatabyId']->enrollment_id)->first();
        $data['student'] = StudentsTbl::where('id',$data['getDatabyId']->student_id)->first();
        $array = $data['enrollment']->subject_ids;
        $data['subjects'] =SubjectTbl::all("id","subject_name")->whereIn('id',json_decode($array));
        $data['grades'] = json_decode($data['getDatabyId']->grades);
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
        $update = Grade::where('id', $id);
        $data['grades'] = json_encode($request->grades);
        $update->update($data);
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
