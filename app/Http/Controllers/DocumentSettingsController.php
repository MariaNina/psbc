<?php

namespace App\Http\Controllers;

use App\Models\DocumentTypeTbl;
use App\Models\LevelsTbl;
use App\Utilities\AccessRoute;
use App\Utilities\AuditTrail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class DocumentSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('authenticated')->except('dashboard.document_settings');

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

            $DocumentTypeTbl = DocumentTypeTbl::select();

            return DataTables::of($DocumentTypeTbl)
                ->addIndexColumn()
                ->addColumn('action', function ($DocumentTypeTbl) {

                    // $is_active = ($DocumentTypeTbl->is_active == TRUE) ? 'deactivate' :'activate';

                    //button update
                    $button = '<span class="actionCust editData" title="update document" data-id="' . md5($DocumentTypeTbl->id) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    // $button .='<span class="actionCust '.$is_active.'"  title="'.$is_active.' document" data-id="'.md5($DocumentTypeTbl->id).'" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>' ;

                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);
        }

        $permissions = AccessRoute::user_permissions(session('user')->id);

        return view('dashboard.document_settings', compact('permissions'));

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
        $docs = new DocumentTypeTbl();
        $docs->document_name = $request->document_name;
        $docs->student_type = $request->student_type;
        $docs->student_dept = $request->student_dept;
        $docs->is_required = 1;
        if($docs->save()){
             //log to audit trail
             $new_data = $docs;
             $action_taken = 'Create';
             $description = 'Add New Document';
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
        $data['getDataById'] = DocumentTypeTbl::where(DB::raw('md5(id)'), $id)->get();
        $data['levels'] = LevelsTbl::all();
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
        $old_data = DocumentTypeTbl::where(DB::raw('md5(id)'), $id)->first();

        $update = DocumentTypeTbl::where(DB::raw('md5(id)'), $id)->first();
        $update->document_name = $request->document_name;
        $update->student_type = $request->student_type;
        $update->student_dept = $request->student_dept;
        $update->is_required = $request->is_required;
        if($update->save()){
            //log to audit trail
            $new_data = $update;
            $action_taken = 'Update';
            $description = 'Update Document '.$update->document_name;
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
    public function destroy($id)
    {
        //
    }
}
