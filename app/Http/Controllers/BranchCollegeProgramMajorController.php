<?php

namespace App\Http\Controllers;

use App\Models\BranchCollegesProgramsMajorsTbl;
use App\Models\BranchTbl;
use App\Models\CollegesTbl;
use App\Models\ProgramMajorsTbl;
use App\Utilities\AccessRoute;
use App\Utilities\AuditTrail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class BranchCollegeProgramMajorController extends Controller
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

            $BranchCollege = BranchCollegesProgramsMajorsTbl::select(
                "branch_colleges_programs_majors_tbls.is_active as isActive",
                "branch_colleges_programs_majors_tbls.id as bid",
                "branch_tbls.branch_name as branch_name",
                "colleges_tbls.college_name as college_name",
                "program_majors_tbls.*",
                "programs_tbls.program_name as program_name",
                "majors_tbls.major_name as major_name")
                ->join('branch_tbls', 'branch_colleges_programs_majors_tbls.branch_id', '=', 'branch_tbls.id')
                ->join('colleges_tbls', 'branch_colleges_programs_majors_tbls.college_id', '=', 'colleges_tbls.id')
                ->join('program_majors_tbls', 'branch_colleges_programs_majors_tbls.program_major_id', '=', 'program_majors_tbls.id')
                ->join('programs_tbls', 'program_majors_tbls.program_id', '=', 'programs_tbls.id')
                ->join('majors_tbls', 'program_majors_tbls.major_id', '=', 'majors_tbls.id');

            return DataTables::of($BranchCollege)
                ->addIndexColumn()
                ->addColumn('action', function ($BranchCollege) {

                    $is_active = ($BranchCollege->isActive == 1) ? 'deactivate' : 'activate';

                    //button update
                    $button = '<span class="actionCust editData" title="update branch college" data-id="' . md5($BranchCollege->bid) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    $button .= '<span class="actionCust ' . $is_active . '"  title="' . $is_active . ' branch_college" data-id="' . md5($BranchCollege->bid) . '" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>';

                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);
        }

        $branches = BranchTbl::all();
        $colleges = CollegesTbl::all();

        $programMajors = ProgramMajorsTbl::select(
            'program_majors_tbls.id as id',
            'programs_tbls.program_name as program_name',
            'majors_tbls.major_name as major_name')
            ->join('programs_tbls', 'program_majors_tbls.program_id', '=', 'programs_tbls.id')
            ->join('majors_tbls', 'program_majors_tbls.major_id', '=', 'majors_tbls.id')->get();

        $title = "Branch Colleges";

        $permissions = AccessRoute::user_permissions(session('user')->id);

        return view('dashboard.collegeBranch', compact('branches', 'colleges', 'programMajors', 'title', 'permissions'));
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
        $branchCollege = new BranchCollegesProgramsMajorsTbl;
        $branchCollege->branch_id = $request->branchName;
        $branchCollege->college_id = $request->collegeName;
        $branchCollege->program_major_id = $request->programMajor;
        $branchCollege->is_active = 1;
        if($branchCollege->save()){
            //log to audit trail
            $new_data = $branchCollege;
            $action_taken = 'Create';
            $description = 'Assigned Branch College';
            AuditTrail::logAuditTrail( $action_taken , $description , $new_data);
            //end log
        }
        return response()->json(['success' => 'New Branch College successfully created']);
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
        $data['getDataById'] = BranchCollegesProgramsMajorsTbl::where(DB::raw('md5(id)'), $id)->get();
        $data["branches"] = BranchTbl::all();
        $data["colleges"] = CollegesTbl::all();
        $data['programMajors'] = ProgramMajorsTbl::select(
            'program_majors_tbls.id as id',
            'programs_tbls.program_name as program_name',
            'majors_tbls.major_name as major_name')
            ->join('programs_tbls', 'program_majors_tbls.program_id', '=', 'programs_tbls.id')
            ->join('majors_tbls', 'program_majors_tbls.major_id', '=', 'majors_tbls.id')->get();
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
        $old_data = BranchCollegesProgramsMajorsTbl::where(DB::raw('md5(id)'), $id)->first();

        $update = BranchCollegesProgramsMajorsTbl::where(DB::raw('md5(id)'), $id)->first();
        $update->branch_id = $request->branchName;
        $update->college_id = $request->collegeName;
        $update->program_major_id = $request->programMajor;
        if($update->save()){
            //log to audit trail
            $new_data = $update;
            $action_taken = 'Update';
            $description = 'Updated Branch College';
            AuditTrail::logAuditTrail( $action_taken , $description , $new_data, $old_data);
            //end log
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
        $old_data = BranchCollegesProgramsMajorsTbl::where(DB::raw('md5(id)'), $id)->first();

        $deactivate = BranchCollegesProgramsMajorsTbl::where(DB::raw('md5(id)'), $id)->first();
        $deactivate->is_active = $request->is_active;
        if($deactivate->save()){
                //log to audit trail
                $stats = ($request->is_active == 1) ? 'Activate':'Deactivate';
                $new_data = $deactivate;
                $action_taken = 'Update';
                $description = $stats.' Branch College';
                AuditTrail::logAuditTrail( $action_taken , $description , $new_data, $old_data);
                //end log
        }
    }
}
