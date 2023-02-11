<?php

namespace App\Http\Controllers;

use App\Models\CutOff;
use App\Utilities\AccessRoute;
use App\Utilities\AuditTrail;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class CutOffSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('authenticated')->except('index');

    }

    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $CutOff = CutOff::latest('pay_day');
            return DataTables::of($CutOff)
            ->addIndexColumn()
                ->addColumn('action', function ($CutOff) {

                    $is_active = ($CutOff->is_active == TRUE) ? 'deactivate' : 'activate';

                    //button update
                    $button = '<span class="actionCust editData" title="update CutOff" data-id="' . md5($CutOff->id) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    $button .= '<span class="actionCust ' . $is_active . '"  title="' . $is_active . ' CutOff" data-id="' .md5($CutOff->id). '" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>';


                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);

        }

        $permissions = AccessRoute::user_permissions(session('user')->id);
        return view('dashboard.cutoff_settings',compact('permissions'));
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
        $CutOff = new CutOff();
        $CutOff->start_date = $request->start_date;
        $CutOff->end_date = $request->end_date;
        $CutOff->pay_day = $request->pay_date;
        $CutOff->is_active =1;
        $CutOff->encoded_by = session("user")->full_name;
        $CutOff->created_at = $nowInManila;
        $CutOff->updated_at =$nowInManila;
        if($CutOff->save()){
            //log to audit trail
            $new_data = $CutOff;
            $action_taken = 'Create';
            $description = 'Create New Cut Off';
            AuditTrail::logAuditTrail( $action_taken , $description , $new_data);
            //end log
        }
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
        $getDataById = CutOff::where(DB::raw('md5(id)'), $id)->get();
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
        $old_data = CutOff::where(DB::raw('md5(id)'), $id)->first();
        $update = CutOff::where(DB::raw('md5(id)'), $id)->first();
        $update->start_date = $request->edit_start_date;
        $update->end_date =$request->edit_end_date;
        $update->pay_day =$request->edit_pay_date;
        $update->encoded_by = session('user')->full_name;
        $update->updated_at = $nowInManila;
        if($update->save()){
            //log to audit trail
            $new_data = $update;
            $action_taken = 'Update';
            $description = 'Update CutOff';
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
        $old_data = CutOff::where(DB::raw('md5(id)'), $id)->first();
        $deactivate = CutOff::where(DB::raw('md5(id)'), $id)->first();
        $deactivate->is_active = $request->is_active;
        $deactivate->encoded_by = session('user')->full_name;
        $deactivate->updated_at = $nowInManila;
        if($deactivate->save()){
                //log to audit trail
                $stats = ($request->is_active == 1) ? 'Activate':'Deactivate';
                $new_data = $deactivate;
                $action_taken = 'Update';
                $description = $stats.' CutOff';
                AuditTrail::logAuditTrail( $action_taken , $description , $new_data, $old_data);
                //end log
        }
    }
}
