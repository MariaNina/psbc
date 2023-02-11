<?php

namespace App\Http\Controllers;

use App\Utilities\AccessRoute;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\ProgramMajorsTbl;
use App\Models\ProgramsTbl;
use App\Models\MajorsTbl;
use App\Utilities\AuditTrail;

class ProgramMajorController extends Controller
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
            $ProgramMajorTbl =
                ProgramMajorsTbl::select(
                    'program_majors_tbls.id as id',
                    'programs_tbls.program_name as program_name',
                    'majors_tbls.major_name as major_name',
                    'program_majors_tbls.description as description',
                    'program_majors_tbls.is_active as is_active')
                    ->join('programs_tbls', 'program_majors_tbls.program_id', '=', 'programs_tbls.id')
                    ->join('majors_tbls', 'program_majors_tbls.major_id', '=', 'majors_tbls.id');

            return DataTables::of($ProgramMajorTbl)
                ->addIndexColumn()
                ->addColumn('action', function ($ProgramMajorTbl) {

                    $is_active = ($ProgramMajorTbl->is_active == TRUE) ? 'deactivate' : 'activate';

                    //button update
                    $button = '<span class="actionCust editData" title="update program major" data-id="' . md5($ProgramMajorTbl->id) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    $button .= '<span class="actionCust ' . $is_active . '"  title="' . $is_active . ' program major" data-id="' . md5($ProgramMajorTbl->id) . '" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>';


                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);


        }
        $data["programs"] = ProgramsTbl::all();
        $data["majors"] = MajorsTbl::all();
        $data['title'] = "Program Major";
        $data['permissions'] = AccessRoute::user_permissions(session('user')->id);

        return view('dashboard.programMajors', $data);
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
        $request->validate([
            'programName' => ['required'],
            'majorName' => ['required', 'string'],
            'description' => ['max:100', 'string'],
        ]);
        $programMajor = new ProgramMajorsTbl;
        $programMajor->program_id = $request->programName;
        $programMajor->major_id = $request->majorName;
        $programMajor->description = $request->description;
        $programMajor->student_department = $request->studentDept;
        $programMajor->is_active = 1;
        if($programMajor->save()){
            //log to audit trail
            $new_data = $programMajor;
            $action_taken = 'Create';
            $description = 'Assign New Program Major';
            AuditTrail::logAuditTrail( $action_taken , $description , $new_data);
            //end log
       }
        return response()->json(['success' => 'New Program successfully created']);
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
        $data['getDataById'] = ProgramMajorsTbl::where(DB::raw('md5(id)'), $id)->get();
        $data["programs"] = ProgramsTbl::all();
        $data["majors"] = MajorsTbl::all();
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
        $request->validate([
            'programName' => ['required'],
            'majorName' => ['required', 'string'],
            'description' => ['max:100', 'string'],
        ]);
        $update = ProgramMajorsTbl::where(DB::raw('md5(id)'), $id);
        $data['program_id'] = $request->programName;
        $data['major_id'] = $request->majorName;
        $data['student_department'] = $request->studentDept;
        $data['description'] = $request->description;
        $update->update($data);
        return response()->json(['success' => 'Program successfully updated']);
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
        $deactivate = ProgramMajorsTbl::where(DB::raw('md5(id)'), $id);
        $data['is_active'] = $request->is_active;
        $deactivate->update($data);
    }
}
