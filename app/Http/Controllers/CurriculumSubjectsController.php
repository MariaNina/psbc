<?php

namespace App\Http\Controllers;

use App\Utilities\AccessRoute;
use Illuminate\Http\Request;
use App\Models\CurriculumSubjectsTbl;
use App\Models\CurriculumTbl;
use App\Models\SubjectTbl;
use App\Models\TermsTbl;
use App\Utilities\AuditTrail;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;


class CurriculumSubjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //index page
        if(isset($request->c)){

            $cur = base64_decode($request->c);
            $std_dept = base64_decode($request->s);
            $check_cur = CurriculumTbl::where(DB::raw('md5(id)'),$cur); //check if the curriculum_id is existing in the database

            if($check_cur->count() > 0){
                if($request->ajax()) {

                    $CurriculumSubjectsTbl = CurriculumSubjectsTbl::select(
                    "curriculum_subjects_tbls.*",
                    "terms_tbls.term_name",
                    DB::raw("CONCAT(subject_tbls.subject_code,' - ',subject_tbls.subject_name) AS subjectName"),
                    DB::raw("CONCAT(subject_tbls_2.subject_code,' - ',subject_tbls_2.subject_name) AS preReqSubjectName"),
                    "curriculum_subjects_tbls.id")
                    ->leftJoin('curriculum_tbls', 'curriculum_subjects_tbls.curriculum_id', '=', 'curriculum_tbls.id')
                    ->leftJoin('terms_tbls', 'curriculum_subjects_tbls.term_id', '=', 'terms_tbls.id')
                    ->leftJoin('subject_tbls', 'curriculum_subjects_tbls.subject_id', '=', 'subject_tbls.id')
                    ->leftJoin('subject_tbls AS subject_tbls_2', 'curriculum_subjects_tbls.prerequisite_subject_id', '=', 'subject_tbls_2.id')
                    ->where(DB::raw('md5(curriculum_subjects_tbls.curriculum_id)'),$cur);

                    return DataTables::of($CurriculumSubjectsTbl)
                            ->addIndexColumn()
                            ->addColumn('action', function($CurriculumSubjectsTbl){

                            $is_active = ($CurriculumSubjectsTbl->is_active == TRUE) ? 'deactivate' :'activate';

                            //button update
                            $button = '<span class="actionCust editData" title="update school year" data-id="'.md5($CurriculumSubjectsTbl->id).'"><a class=""><i class="fas fa-edit"></i></a></span>';

                            //button deactivate activate
                            $button .='<span class="actionCust '.$is_active.'"  title="'.$is_active.' schoole year" data-id="'.md5($CurriculumSubjectsTbl->id).'" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>' ;


                                return $button; // Return Button
                            })
                            ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                            ->make(true);

                }
                $data['std_dept'] = $std_dept;
                $data['cur_id'] = $check_cur->first();
                $data['cur'] = $cur;
                $data['terms'] = TermsTbl::all();
                // $data['subjects'] = SubjectTbl::all();
                if($std_dept == 'College' || $std_dept == 'Graduate Studies'){
                    $is_for_college = 1;
                }else{
                    $is_for_college = 0;
                }
                $data['subjects'] = DB::select("SELECT id, subject_name, subject_code FROM subject_tbls WHERE is_for_college = $is_for_college AND is_offered = 1 and id NOT IN (SELECT subject_id FROM curriculum_subjects_tbls WHERE md5(curriculum_id)= '$cur')");

                $data['cur_subjects'] = CurriculumSubjectsTbl::select("curriculum_subjects_tbls.subject_id",
                DB::raw("CONCAT(subject_tbls.subject_code,' - ',subject_tbls.subject_name) AS subjectName"))
                ->leftJoin('subject_tbls', 'curriculum_subjects_tbls.subject_id', '=', 'subject_tbls.id')
                ->where(DB::raw('md5(curriculum_subjects_tbls.curriculum_id)'),$cur)->get();
                $data['title'] = "Subject per Curriculum";

                $data['permissions'] = AccessRoute::user_permissions(session('user')->id);

                return view('dashboard.curriculumSubject',$data);

            }else{
                return redirect()->back();
            }

        }else{
            return redirect()->back();
        }
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
        foreach($request->subject as $subject){
            $curSubject = new CurriculumSubjectsTbl();
            $curSubject->curriculum_id = $request->curriculum_id;
            $curSubject->term_id = $request->term;
            $curSubject->subject_id = $subject;
            $curSubject->prerequisite_subject_id = $request->prerequisite;
            $curSubject->is_offered = 1;
            $curSubject->is_active = 1;
            if($curSubject->save()){
                //log to audit trail
                $new_data = $curSubject;
                $action_taken = 'Assign';
                $description = 'Assign Subjects to Curriculum';
                AuditTrail::logAuditTrail( $action_taken , $description , $new_data);
                //end log
            }
        }
        
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

        $CurriculumSubjectsTbl = CurriculumSubjectsTbl::select(DB::raw('@rownum :=@rownum+1 as rowNum'),
        "curriculum_subjects_tbls.*",
        "curriculum_tbls.id AS cur_id",
        "curriculum_tbls.student_department AS std_dept")
        ->leftJoin('curriculum_tbls', 'curriculum_subjects_tbls.curriculum_id', '=', 'curriculum_tbls.id')
        ->where(DB::raw('md5(curriculum_subjects_tbls.id)'),$id)->first();

        if($CurriculumSubjectsTbl->std_dept == 'College' || $CurriculumSubjectsTbl->std_dept == 'Graduate Studies'){
            $is_for_college = 1;
        }else{
            $is_for_college = 0;
        }

        $data['subjects'] = DB::select("SELECT id, subject_name, subject_code FROM subject_tbls WHERE is_for_college = $is_for_college AND is_offered = 1 and id NOT IN (SELECT subject_id FROM curriculum_subjects_tbls WHERE md5(id) != '$id' AND curriculum_id= '$CurriculumSubjectsTbl->cur_id')");

        $data['prerequisites'] = CurriculumSubjectsTbl::select("curriculum_subjects_tbls.subject_id",
        DB::raw("CONCAT(subject_tbls.subject_code,' - ',subject_tbls.subject_name) AS subjectName"))
        ->leftJoin('subject_tbls', 'curriculum_subjects_tbls.subject_id', '=', 'subject_tbls.id')
        ->where(DB::raw('curriculum_subjects_tbls.curriculum_id'),$CurriculumSubjectsTbl->cur_id)->get();

        $data['getDataById'] = $CurriculumSubjectsTbl;
        $data['terms'] = TermsTbl::all();

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
        $old_data = CurriculumSubjectsTbl::where(DB::raw('md5(id)') , $id)->first();

        $update = CurriculumSubjectsTbl::where(DB::raw('md5(id)') , $id)->first();
        $update->term_id = $request->term;
        $update->subject_id = $request->subject;
        if(!empty($request->prerequisite)){
            $update->prerequisite_subject_id = $request->prerequisite;
        }
        $update->is_offered = $request->is_offered;
        if($update->save()){
            //log to audit trail
            $new_data = $update;
            $action_taken = 'Update';
            $description = 'Update Curriculum Subjects';
            AuditTrail::logAuditTrail( $action_taken , $description , $new_data, $old_data);
            //end log
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy(Request $request,$id)
    {
        //
        $old_data = CurriculumSubjectsTbl::where(DB::raw('md5(id)') , $id)->first();
        $deactivate = CurriculumSubjectsTbl::where(DB::raw('md5(id)') , $id)->first();

        $deactivate->is_active = $request->is_active;
        if($deactivate->save()){
                //log to audit trail
                $stats = ($request->is_active == 1) ? 'Activate':'Deactivate';
                $new_data = $deactivate;
                $action_taken = 'Update';
                $description = $stats.' Curriculum Subject';
                AuditTrail::logAuditTrail( $action_taken , $description , $new_data, $old_data);
                //end log
        }
    }
}
