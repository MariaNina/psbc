<?php

namespace App\Http\Controllers;

use App\Models\GradeSettings;
use App\Models\ShowGrades;
use App\Utilities\AccessRoute;
use App\Utilities\AuditTrail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class GradeSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $gradeSettings = GradeSettings::select();
            return DataTables::of($gradeSettings)
                ->addIndexColumn()
                ->addColumn('action', function ($gradeSettings) {
                    $button = '<span class="actionCust editData" title="update Grade Settings" data-id="' . md5($gradeSettings->id) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    return $button;
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);
        }

        $title = "Grade Settings";
        $permissions = AccessRoute::user_permissions(session('user')->id);
        $showGrades = ShowGrades::orderBy('id', 'asc')->first();

        return view('dashboard.grade_settings', compact('title', 'permissions', 'showGrades'));
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
        $GradeSet = new GradeSettings;
        $GradeSet->grade_range = $request->grade_range;
        $GradeSet->level_department = $request->department;
        $GradeSet->point_equivalent = $request->point_equivalant;
        $GradeSet->letter_equivalent = $request->letter_equivalent;
        $GradeSet->status = $request->status;
        if($GradeSet->save()){
            //log to audit trail
            $new_data = $GradeSet;
            $action_taken = 'Create';
            $description = 'Add New Grade Settings';
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
    public function edit(Request $request, $id)
    {
        //
        $getDataById = GradeSettings::where(DB::raw('md5(id)'), $id)->get();
        return $getDataById;
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
        $update = GradeSettings::where(DB::raw('md5(id)'), $id);
        $data['grade_range'] = $request->grade_range1;
        $data['point_equivalent'] = $request->point_equivalent1;
        $data['letter_equivalent'] = $request->letter_equivalent1;
        $data['status'] = $request->status1;
        $update->update($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function toggleShowingDepedGrades()
    {
        $showGrades = ShowGrades::orderBy('id', 'asc')->first();
        $toggle = !$showGrades->show_deped_grade;

        $showGrades->update([
            'show_deped_grade' => $toggle
        ]);
    }

    public function toggleShowingChedGrades()
    {
        $showGrades = ShowGrades::orderBy('id', 'asc')->first();
        $toggle = !$showGrades->show_ched_grade;

        $showGrades->update([
            'show_ched_grade' => $toggle
        ]);
    }
}
