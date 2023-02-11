<?php

namespace App\Http\Controllers;

use App\Utilities\AccessRoute;
use Illuminate\Http\Request;
use App\Models\CollegesTbl;
use App\Utilities\AuditTrail;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CollegeController extends Controller
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

            $CollegesTbl = CollegesTbl::select();

            return DataTables::of($CollegesTbl)
                ->addIndexColumn()
                ->addColumn('action', function ($CollegesTbl) {

                    $is_active = ($CollegesTbl->is_active == TRUE) ? 'deactivate' : 'activate';

                    //button update
                    $button = '<span class="actionCust editData" title="update term" data-id="' . md5($CollegesTbl->id) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    $button .= '<span class="actionCust ' . $is_active . '"  title="' . $is_active . ' term" data-id="' . md5($CollegesTbl->id) . '" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>';


                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);

        }
        $title = "Colleges";
        $permissions = AccessRoute::user_permissions(session('user')->id);
        return view('dashboard.college', compact('title', 'permissions'));

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
        $request->validate([
            'college_code' => ['required', 'alpha', 'max:10', 'min:3', 'unique:colleges_tbls,college_code'],
            'college_name' => ['required', 'max:100', 'min:10', 'string', 'unique:colleges_tbls,college_name'],
            'college_desc' => ['max:100', 'string'],
        ]);


        $college = new CollegesTbl;
        $college->college_code = Str::upper($request->college_code);
        $college->college_name = $request->college_name;
        $college->college_description = $request->college_desc;
        $college->is_active = 1;
    
            if( $college->save()){

                //log to audit trail
                $new_data = $college;
                $action_taken = 'Create';
                $description = 'Created New College';
                AuditTrail::logAuditTrail( $action_taken , $description , $new_data);
                //end log
                return response()->json(['message' => 'New College successfully created', 'status' => 'success']);
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
        $getDataById = CollegesTbl::where(DB::raw('md5(id)'), $id)->get();
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

        $old_data = CollegesTbl::where(DB::raw('md5(id)'),$id)->first();
        $request->validate([
            'college_code' => [
                'required', 
                'alpha', 
                'max:10', 
                'min:3',
                Rule::unique('colleges_tbls','college_code')->ignore($old_data->id, 'id')],
            'college_name' => ['required', 'max:100', 'min:10', 'string',
                Rule::unique('colleges_tbls','college_name')->ignore($old_data->id, 'id')],
            'college_desc' => ['max:100', 'string'],
        ]);
        $college = CollegesTbl::where(DB::raw('md5(id)'),$id)->first();

        $college->college_code = Str::upper($request->college_code);
        $college->college_name = $request->college_name;
        $college->college_description = $request->college_desc;
        
        if($college->save()){

                //log to audit trail
                $new_data = $college;
                $action_taken = 'Update';
                $description = 'Updated College '.$old_data->college_name;
                AuditTrail::logAuditTrail( $action_taken , $description , $new_data, $old_data);
                //end log

            return response()->json(['message' => 'College successfully updated', 'status' => 'success']);
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
        $old_data = CollegesTbl::where(DB::raw('md5(id)'), $id)->first();
        $deactivate = CollegesTbl::where(DB::raw('md5(id)'), $id)->first();
        
        $deactivate->is_active = $request->is_active;
        if($deactivate->save()){
                //log to audit trail
                $stats = ($request->is_active == 1) ? 'Activate':'Deactivate';
                $new_data = $deactivate;
                $action_taken = 'Update';
                $description = $stats.' College '.$old_data->college_name;
                AuditTrail::logAuditTrail( $action_taken , $description , $new_data, $old_data);
                //end log
        }
    }
}
