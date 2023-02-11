<?php

namespace App\Http\Controllers;

use App\Models\CurriculumTbl;
use App\Models\LevelsTbl;
use App\Models\ProgramMajorsTbl;
use App\Models\SchoolYearTbl;
use App\Utilities\AccessRoute;
use App\Utilities\AuditTrail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class CurriculumController extends Controller
{
    public function __construct()
    {
        $this->middleware('authenticated');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        // $data['curriculums'] = CurriculumTbl::all();
        // $data['distinctCurriculumYears'] = CurriculumTbl::distinct()->get(['curriculum_year']);
        // $data['schoolYears'] = SchoolYearTbl::all();
        // $data['programsMajors'] = ProgramMajorsTbl::all();

        // $data['college_levels'] = LevelsTbl::where('student_dept','College')->get();
        // $data['shs_levels'] = LevelsTbl::where('student_dept','SHS')->get();
        // //  $data['k10_levels'] = LevelsTbl::wherein('student_dept',["Elementary","JHS"])->get();
        // $data['elem_levels'] = LevelsTbl::where('student_dept',"Elementary")->get();
        // $data['jhs_levels'] = LevelsTbl::where('student_dept',"JHS")->get();

        // $data['title'] = "Curriculum";


        // return view('dashboard.curriculum',$data)->with('n');

    }

    public function getCurriculums(Request $request)
    {
        if ($request->ajax()) {
            
            $CurriculumTbl =
                CurriculumTbl::select(
                    "curriculum_tbls.id as id",
                    "curriculum_tbls.curriculum_year",
                    "curriculum_tbls.curriculum_description",
                    "curriculum_tbls.student_department",
                    "curriculum_tbls.is_active",
                    "programs_tbls.program_name",
                    "majors_tbls.major_name",
                    "levels_tbls.level_name",
                    "school_year_tbls.school_years")
                    ->leftJoin('program_majors_tbls', 'curriculum_tbls.program_major_id', '=', 'program_majors_tbls.id')
                    ->leftJoin('programs_tbls', 'program_majors_tbls.program_id', '=', 'programs_tbls.id')
                    ->leftJoin('majors_tbls', 'program_majors_tbls.major_id', '=', 'majors_tbls.id')
                    ->leftJoin('levels_tbls', 'curriculum_tbls.level_id', '=', 'levels_tbls.id')
                    ->leftJoin('school_year_tbls', 'curriculum_tbls.school_year_id', '=', 'school_year_tbls.id');

            return Datatables::of($CurriculumTbl)
                ->addIndexColumn()
                ->addColumn('action', function ($CurriculumTbl) {

                    $is_active = ($CurriculumTbl->is_active == TRUE) ? 'deactivate' : 'activate';

                    //button update
                    $button = '<span class="actionCust editData_' . str_replace(' ','',$CurriculumTbl->student_department) . '" title="update branch" data-id="' . md5($CurriculumTbl->id) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    $button .= '<span class="actionCust ' . $is_active . '"  title="' . $is_active . ' curriculum" data-id="' . md5($CurriculumTbl->id) . '" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>';

                    //button to redirect to curriculum subject settings
                    //passing md5 and encoded id for protection
                    $button .= '<span class="actionCust" title="click to add subjects"><a href="' . route('curriculum_subjects.index', ['s' => base64_encode($CurriculumTbl->student_department), 'c' => base64_encode(md5($CurriculumTbl->id))]) . '"  class="delete-btn"><i class="fa fa-plus"></i></a></span>';


                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);
        }

        $data['distinctCurriculumYears'] = CurriculumTbl::distinct()->get(['curriculum_year']);
        $data['schoolYears'] = SchoolYearTbl::all();
        $data['programsMajorsGraduateStudies'] = ProgramMajorsTbl::where(array('student_department' => 'Graduate Studies', 'is_active' => 1))->get();
        $data['programsMajorsCollege'] = ProgramMajorsTbl::where(array('student_department' => 'College', 'is_active' => 1))->get();
        $data['programsMajorsSHS'] = ProgramMajorsTbl::where(array('student_department' => 'SHS', 'is_active' => 1))->get();
        $data['programsMajorsElementary'] = ProgramMajorsTbl::where(array('student_department' => 'Elementary', 'is_active' => 1))->get();
        $data['programsMajorsJHS'] = ProgramMajorsTbl::where(array('student_department' => 'JHS', 'is_active' => 1))->get();
        $data['programsMajorsGradStud'] = ProgramMajorsTbl::where(array('student_department' => 'Graduate Studies', 'is_active' => 1))->get();

        $data['college_levels'] = LevelsTbl::where(array('student_dept' => 'College', 'is_active' => 1))->get();
        $data['grad_stud_levels'] = LevelsTbl::where(array('student_dept' => 'Graduate Studies', 'is_active' => 1))->get();
        $data['shs_levels'] = LevelsTbl::where(array('student_dept' => 'SHS', 'is_active' => 1))->get();
        //  $data['k10_levels'] = LevelsTbl::wherein('student_dept',["Elementary","JHS"])->get();
        $data['elem_levels'] = LevelsTbl::where(array('student_dept' => 'Elementary', 'is_active' => 1))->get();
        $data['jhs_levels'] = LevelsTbl::where(array('student_dept' => 'JHS', 'is_active' => 1))->get();

        $data['title'] = "Curriculum";

        $data['permissions'] = AccessRoute::user_permissions(session('user')->id);

        return view('dashboard.curriculum', $data)->with('n');
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $cur = new CurriculumTbl();

        $cur->program_major_id = $request->programMajor;
        $cur->curriculum_year = $request->curriculumYear;
        $cur->curriculum_description = $request->curriculumDescription;
        $cur->level_id = $request->level;
        $cur->student_department = $request->studentDept;
        $cur->school_year_id = $request->schoolYear;
        $cur->is_active = 1;
        if($cur->save()){
             //log to audit trail
             $new_data = $cur;
             $action_taken = 'Create';
             $description = 'Created New Curriculum';
             AuditTrail::logAuditTrail( $action_taken , $description , $new_data);
             //end log
        }
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
    public function edit($id)
    {
        //
        $data['getDataById'] = CurriculumTbl::where(DB::raw('md5(id)'), $id)->get();
        // $data['programsMajors'] = ProgramMajorsTbl::select("program_majors_tbls.*", "programs_tbls.program_code", "programs_tbls.program_name", "majors_tbls.major_code", "majors_tbls.major_name")
        // ->leftJoin('programs_tbls', 'program_majors_tbls.program_id', '=', 'programs_tbls.id')
        // ->leftJoin('majors_tbls', 'program_majors_tbls.major_id', '=', 'majors_tbls.id')->get();
        $data['school_years'] = SchoolYearTbl::all();
        // $data['graduate_levels'] = LevelsTbl::where('student_dept', 'Graduate Studies')->get();
           $data['grad_levels'] = LevelsTbl::where('student_dept', 'Graduate Studies')->get();
        $data['college_levels'] = LevelsTbl::where('student_dept', 'College')->get();
        $data['shs_levels'] = LevelsTbl::where('student_dept', 'SHS')->get();
        //  $data['k10_levels'] = LevelsTbl::wherein('student_dept',["Elementary","JHS"])->get();
        $data['elem_levels'] = LevelsTbl::where('student_dept', "Elementary")->get();
        $data['jhs_levels'] = LevelsTbl::where('student_dept', "JHS")->get();

        $data['programsMajorsCollege'] = ProgramMajorsTbl::select("program_majors_tbls.*", "programs_tbls.program_code", "programs_tbls.program_name", "majors_tbls.major_code", "majors_tbls.major_name")
            ->leftJoin('programs_tbls', 'program_majors_tbls.program_id', '=', 'programs_tbls.id')
            ->leftJoin('majors_tbls', 'program_majors_tbls.major_id', '=', 'majors_tbls.id')
            ->where('program_majors_tbls.student_department', 'College')
            ->where('program_majors_tbls.is_active', 1)->get();

        $data['programsMajorsSHS'] = ProgramMajorsTbl::select("program_majors_tbls.*", "programs_tbls.program_code", "programs_tbls.program_name", "majors_tbls.major_code", "majors_tbls.major_name")
            ->leftJoin('programs_tbls', 'program_majors_tbls.program_id', '=', 'programs_tbls.id')
            ->leftJoin('majors_tbls', 'program_majors_tbls.major_id', '=', 'majors_tbls.id')
            ->where('program_majors_tbls.student_department', 'SHS')
            ->where('program_majors_tbls.is_active', 1)->get();

        $data['programsMajorsElementary'] = ProgramMajorsTbl::select("program_majors_tbls.*", "programs_tbls.program_code", "programs_tbls.program_name", "majors_tbls.major_code", "majors_tbls.major_name")
            ->leftJoin('programs_tbls', 'program_majors_tbls.program_id', '=', 'programs_tbls.id')
            ->leftJoin('majors_tbls', 'program_majors_tbls.major_id', '=', 'majors_tbls.id')
            ->where('program_majors_tbls.student_department', 'Elementary')
            ->where('program_majors_tbls.is_active', 1)->get();

        $data['programsMajorsJHS'] = ProgramMajorsTbl::select("program_majors_tbls.*", "programs_tbls.program_code", "programs_tbls.program_name", "majors_tbls.major_code", "majors_tbls.major_name")
            ->leftJoin('programs_tbls', 'program_majors_tbls.program_id', '=', 'programs_tbls.id')
            ->leftJoin('majors_tbls', 'program_majors_tbls.major_id', '=', 'majors_tbls.id')
            ->where('program_majors_tbls.student_department', 'JHS')
            ->where('program_majors_tbls.is_active', 1)->get();

        $data['programsMajorsGradStud'] = ProgramMajorsTbl::select("program_majors_tbls.*", "programs_tbls.program_code", "programs_tbls.program_name", "majors_tbls.major_code", "majors_tbls.major_name")
            ->leftJoin('programs_tbls', 'program_majors_tbls.program_id', '=', 'programs_tbls.id')
            ->leftJoin('majors_tbls', 'program_majors_tbls.major_id', '=', 'majors_tbls.id')
            ->where('program_majors_tbls.student_department', 'Graduate Studies')
            ->where('program_majors_tbls.is_active', 1)->get();

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
        $old_data = CurriculumTbl::where(DB::raw('md5(id)'), $id)->first();

        $update = CurriculumTbl::where(DB::raw('md5(id)'), $id)->first();
        $update->curriculum_year = $request->curriculumYear;
        $update->curriculum_description = $request->curriculumDescription;
        $update->student_department = $request->studentDept;
        $update->program_major_id = $request->programMajor;
        $update->school_year_id = $request->schoolYear;
        $update->level_id = $request->level;
        if($update->save()){
            //log to audit trail
            $new_data = $update;
            $action_taken = 'Update';
            $description = 'Update Curriculum';
            AuditTrail::logAuditTrail( $action_taken , $description , $new_data, $old_data);
            //end log
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
        $old_data = CurriculumTbl::where(DB::raw('md5(id)'), $id)->first();
        $deactivate = CurriculumTbl::where(DB::raw('md5(id)'), $id)->first();

        $deactivate->is_active = $request->is_active;
        if($deactivate->save()){
                //log to audit trail
                $stats = ($request->is_active == 1) ? 'Activate':'Deactivate';
                $new_data = $deactivate;
                $action_taken = 'Update';
                $description = $stats.' Curriculum';
                AuditTrail::logAuditTrail( $action_taken , $description , $new_data, $old_data);
                //end log
        }
    }
}
