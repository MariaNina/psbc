<?php

namespace App\Http\Controllers;

use App\Utilities\AccessRoute;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\ProgramsTbl;
use App\Utilities\AuditTrail;
use Illuminate\Support\Facades\DB;

class ProgramController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $ProgramsTbl = ProgramsTbl::select();
            return DataTables::of($ProgramsTbl)
                ->addIndexColumn()
                ->addColumn('action', function ($ProgramsTbl) {

                    $is_active = ($ProgramsTbl->is_active == TRUE) ? 'deactivate' : 'activate';

                    //button update
                    $button = '<span class="actionCust editData" title="update program" data-id="' . md5($ProgramsTbl->id) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    $button .= '<span class="actionCust ' . $is_active . '"  title="' . $is_active . ' program" data-id="' . md5($ProgramsTbl->id) . '" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>';


                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);

        }

        $data['title'] = "Programs";
        $data['permissions'] = AccessRoute::user_permissions(session('user')->id);

        return view('dashboard.programs', $data);
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
            'program_code' => ['required', 'string', 'max:10', 'min:3', 'unique:programs_tbls,program_code,except,id'],
            'program_name' => ['required', 'max:100', 'min:10', 'string'],
            'program_desc' => ['max:100', 'string'],
        ]);
        $check_program = ProgramsTbl::where('program_name',$request->program_name);

        if($check_program->doesntExist()){
            
            $program = new ProgramsTbl;
            $program->program_code = $request->program_code;
            $program->program_name = $request->program_name;
            $program->program_description = $request->program_desc;
            $program->is_active = 1;
           
            if($program->save()){

                //log to audit trail
                $new_data = $program;
                $action_taken = 'Create';
                $description = 'Created New Program';
                AuditTrail::logAuditTrail( $action_taken , $description , $new_data);
                //end log

                return response()->json(['success' => 'New Program successfully created']);
            }
           
        }else{
            return response()->json(['message' => 'Program Name Already Exist!', 'status' => 'error']);
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
        $getDataById = ProgramsTbl::where(DB::raw('md5(id)'), $id)->get();
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
        $request->validate([
            'program_code' => ['required', 'string', 'max:10', 'min:3'],
            'program_name' => ['required', 'max:100', 'min:10', 'string'],
            'program_desc' => ['max:100', 'string'],
        ]);
        $check_program = ProgramsTbl::where([['program_name','=', $request->program_name],[DB::raw('md5(id)'),'<>', $id]]);

        if($check_program->doesntExist()){

                $old_data = ProgramsTbl::where(DB::raw('md5(id)'), $id)->first();

                $program = ProgramsTbl::where(DB::raw('md5(id)'), $id)->first();
                $program->program_code = $request->program_code;
                $program->program_name = $request->program_name;
                $program->program_description = $request->program_desc;

                if($program->save()){

                    //log to audit trail
                    $new_data = $program;
                    $action_taken = 'Update';
                    $description = 'Updated Program';
                    AuditTrail::logAuditTrail( $action_taken , $description , $new_data, $old_data);
                    //end log

                return response()->json(['message' => 'Program successfully updated', 'status' => 'success']);
            }
            
        }else{
            return response()->json(['message' => 'Program Name Already Exist!', 'status' => 'error']);
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
        $deactivate = ProgramsTbl::where(DB::raw('md5(id)'), $id);
        $data['is_active'] = $request->is_active;
        $deactivate->update($data);
    }
}
