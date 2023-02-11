<?php

namespace App\Http\Controllers;

use App\Models\FeesTbl;
use App\Utilities\AccessRoute;
use App\Utilities\AuditTrail;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class FeesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //index page
        if ($request->ajax()) {

            $FeesTbl = FeesTbl::select();
            return DataTables::of($FeesTbl)
                ->addIndexColumn()
                ->addColumn('action', function ($FeesTbl) {

                    $is_active = ($FeesTbl->is_active == TRUE) ? 'deactivate' : 'activate';

                    //button update
                    $button = '<span class="actionCust editData" title="update fee" data-id="' . md5($FeesTbl->id) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    $button .= '<span class="actionCust '.$is_active.'"  title="'.$is_active.' fee" data-id="'.md5($FeesTbl->id).'" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>';


                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);

        }

        $permissions = AccessRoute::user_permissions(session('user')->id);

        return view('dashboard.fees', compact('permissions'));
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
        $fee = new FeesTbl();
        $fee->fee_name = $request->feeName;
        $fee->fee_description = $request->feeDesc;
        $fee->fee_amount = $request->feeAmount;
        $fee->fee_type = $request->feeType;
        $fee->student_department = $request->studentDept;
        $fee->is_active = 1;
        if($fee->save()){
             //log to audit trail
             $new_data = $fee;
             $action_taken = 'Create';
             $description = 'Add New Fee';
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
        $getDataById = FeesTbl::where(DB::raw('md5(id)'), $id)->get();
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
        $update = FeesTbl::where(DB::raw('md5(id)'), $id);
        $data['fee_name'] = $request->feeName;
        $data['fee_description'] = $request->feeDesc;
        $data['fee_amount'] = $request->feeAmount;
        $data['fee_type'] = $request->feeType;
        $data['student_department'] = $request->studentDept;
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
        $deactivate = FeesTbl::where(DB::raw('md5(id)'), $id);
        $data['is_active'] = $request->is_active;
        $deactivate->update($data);
    }
}
