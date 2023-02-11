<?php

namespace App\Http\Controllers;

use App\Models\DeductionSettings;
use App\Utilities\AccessRoute;
use App\Utilities\AuditTrail;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DeductionController extends Controller
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

            $Deduction = DeductionSettings::select()->sortBy("created_at");

            return DataTables::of($Deduction)
                ->addIndexColumn()
                ->addColumn('action', function ($Deduction) {

                    $is_active = ($Deduction->is_active == TRUE) ? 'deactivate' : 'activate';

                    //button update
                    $button = '<span class="actionCust editData" title="update Deduction" data-id="' . md5($Deduction->id) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    $button .= '<span class="actionCust ' . $is_active . '"  title="' . $is_active . ' Deduction" data-id="' .md5($Deduction->id). '" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>';


                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);

        }
        $permissions = AccessRoute::user_permissions(session('user')->id);
        return view('dashboard.deduction',compact('permissions'));
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
        $nowInManila = Carbon::now(new DateTimeZone('Asia/Manila'));
        $Deduction = new DeductionSettings();
        $Deduction->deduction_name = $request->deduction_name;
        $Deduction->is_active = 1;
        $Deduction->encoded_by = session('user')->full_name;
        $Deduction->created_at = $nowInManila;
        $Deduction->updated_at = $nowInManila;
        if($Deduction->save()){
            //log to audit trail
            $new_data = $Deduction;
            $action_taken = 'Create';
            $description = 'Create New Deduction';
            AuditTrail::logAuditTrail( $action_taken , $description , $new_data);
            //end log
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
        $getDataById = DeductionSettings::where(DB::raw('md5(id)'), $id)->get();
        return $getDataById;
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
        $nowInManila = Carbon::now(new DateTimeZone('Asia/Manila'));
        $old_data = DeductionSettings::where(DB::raw('md5(id)'), $id)->first();
        $update = DeductionSettings::where(DB::raw('md5(id)'), $id)->first();
        $update->deduction_name = $request->edit_deduction_name;
        $update->encoded_by =session('user')->full_name;
        $update->updated_at = $nowInManila;
        if($update->save()){
            //log to audit trail
            $new_data = $update;
            $action_taken = 'Update';
            $description = 'Update Deduction';
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
        $nowInManila = Carbon::now(new DateTimeZone('Asia/Manila'));
        $old_data = DeductionSettings::where(DB::raw('md5(id)'), $id)->first();
        $deactivate = DeductionSettings::where(DB::raw('md5(id)'), $id)->first();
        $deactivate->is_active = $request->is_active;
        $deactivate->encoded_by = session('user')->full_name;
        $deactivate->updated_at = $nowInManila;
  
        if($deactivate->save()){
                //log to audit trail
                $stats = ($request->is_active == 1) ? 'Activate':'Deactivate';
                $new_data = $deactivate;
                $action_taken = 'Update';
                $description = $stats.' Deduction';
                AuditTrail::logAuditTrail( $action_taken , $description , $new_data, $old_data);
                //end log
        }
    }
}
