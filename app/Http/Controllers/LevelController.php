<?php

namespace App\Http\Controllers;

use App\Utilities\AccessRoute;
use Illuminate\Http\Request;
use App\Models\LevelsTbl;
use App\Utilities\AuditTrail;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
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
        //index page
        if ($request->ajax()) {

            $LevelsTbl = LevelsTbl::select();
            return DataTables::of($LevelsTbl)
                 ->addIndexColumn()
                ->addColumn('action', function ($LevelsTbl) {

                    $is_active = ($LevelsTbl->is_active == TRUE) ? 'deactivate' : 'activate';

                    //button update
                    $button = '<span class="actionCust editData" title="update level" data-id="' . md5($LevelsTbl->id) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    $button .= '<span class="actionCust ' . $is_active . '"  title="' . $is_active . ' level" data-id="' .md5($LevelsTbl->id). '" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>';


                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);

        }

        $permissions = AccessRoute::user_permissions(session('user')->id);


        return view('dashboard.level', compact('permissions'));

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
        $level = new LevelsTbl();
        $level->level_code = $request->levelCode;
        $level->level_name = $request->levelName;
        $level->student_dept = $request->studentDept;
        $level->is_active = 1;
        if($level->save()){
             //log to audit trail
             $new_data = $level;
             $action_taken = 'Create';
             $description = 'Add New Level';
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
        $getDataById = LevelsTbl::where(DB::raw('md5(id)'), $id)->get();
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
        $update = LevelsTbl::where(DB::raw('md5(id)'), $id);
        $data['level_code'] = $request->levelCode;
        $data['level_name'] = $request->levelName;
        $data['student_dept'] = $request->studentDept;
        $update->update($data);
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
        $deactivate = LevelsTbl::where(DB::raw('md5(id)'), $id);
        $data['is_active'] = $request->is_active;
        $deactivate->update($data);
    }
}
