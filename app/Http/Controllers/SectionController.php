<?php

namespace App\Http\Controllers;

use App\Utilities\AccessRoute;
use Illuminate\Http\Request;
use App\Models\LevelsTbl;
use App\Models\SectionsTbl;
use App\Models\SchoolYearTbl;
use App\Models\StaffsTbl;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Expr\AssignOp\Concat;
use App\Models\CurriculumTbl;
use App\Models\BranchTbl;
use App\Models\TermsTbl;
use App\Models\SchedulesTbl;
use App\Utilities\AuditTrail;

class SectionController extends Controller
{
    public function __construct()
    {
        $this->middleware('authenticated')->except('dashboard.section');

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
            $sectionsTbl =
                SectionsTbl::select(
                    DB::raw("CONCAT(staffs_tbls.last_name,', ',staffs_tbls.first_name) as last_name"),
                    "sections_tbls.id as id",
                    "sections_tbls.section_label as section_label",
                    "sections_tbls.is_active as is_active",
                    "sections_tbls.hasSchedule as hasSchedule",
                    "levels_tbls.level_name as level_name",
                    "branch_tbls.branch_name as branch",
                    "school_year_tbls.school_years as school_year")
                    ->join('staffs_tbls', 'sections_tbls.adviser_id', '=', 'staffs_tbls.id')
                    ->join('levels_tbls', 'sections_tbls.level_id', '=', 'levels_tbls.id')
                    ->join('school_year_tbls', 'sections_tbls.school_year_id', '=', 'school_year_tbls.id')
                    ->join('branch_tbls', 'sections_tbls.branch_id', '=', 'branch_tbls.id');
            return DataTables::of($sectionsTbl)
            ->addIndexColumn()
                ->addColumn('action', function ($sectionsTbl) {
                    $is_active = ($sectionsTbl->is_active == TRUE) ? 'deactivate' : 'activate';
                    $has_schedule = ($sectionsTbl->hasSchedule == TRUE) ? 'text-info' : 'text-secondary';
                    // //button view
                    // $button = '<span class="actionCust '.$has_schedule.'" title="'.$has_schedule.' section" data-id="'.$sectionsTbl->id.'"><a class=""><i class="fas fa-eye '.$has_schedule.'"></i></a></span>';

                    //button update
                    $button = '<span class="actionCust editData" title="update section" data-id="' . $sectionsTbl->id . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    $button .= '<span class="actionCust ' . $is_active . '"  title="' . $is_active . ' section" data-id="' . $sectionsTbl->id . '" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>';


                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);
        }
        $data['id'] = $request->curriculum;
        $data['school_years'] = SchoolYearTbl::all();
        $data['curriculums'] = CurriculumTbl::all();
        $data['levels'] = LevelsTbl::all();
        $data['terms'] = TermsTbl::all();
        $data['branches'] = BranchTbl::all();
        $data['staffs'] = StaffsTbl::all()
            ->where('staff_type', 'Academic')
            ->sortBy('first_name');
        $data['permissions'] = AccessRoute::user_permissions(session('user')->id);
        return view("dashboard.section", $data);

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
        $section = new SectionsTbl;
        $section->section_label = $request->sectionLabel;
        $section->adviser_id = $request->adviser;
        $section->branch_id = $request->branch;
        $section->school_year_id = $request->schoolYear;
        $section->level_id = $request->level;
        $section->is_active = 1;
        if($section->save()){
            //log to audit trail
            $new_data = $section;
            $action_taken = 'Create';
            $description = 'Add New Section';
            AuditTrail::logAuditTrail( $action_taken , $description , $new_data);
            //end log
       }
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
        $data['getDataById'] = SectionsTbl::where('id', $id)->get();
        $data["school_year"] = SchoolYearTbl::all();
        $data["levels"] = LevelsTbl::all();
        $data["branches"] = BranchTbl::all();
        $data["staffs"] = StaffsTbl::all();
        $data["level"] = LevelsTbl::all()->where('id', $data['getDataById'][0]->level_id)->first();
        $data['curri_id'] = CurriculumTbl::all()->where('level_id', $data["level"]->id)->first()->id;
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
        $update = SectionsTbl::find($id);
        $update->section_label = $request->sn;
        $update->adviser_id = $request->aa;
        $update->school_year_id = $request->sy;
        $update->level_id = $request->gl;
        $update->branch_id = $request->branch;
        $update->save();
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
        $deactivate = SectionsTbl::find($id);
        $deactivate->is_active = $request->is_active;
        $deactivate->save();
    }

    // public function getAllSections()
    // {
    //     $section = SectionsTbl::select("id","section_label","is_active")->where("is_active",1)->orderBy("section_label")->get();

    //     return response()->json($section);
    // }
}
