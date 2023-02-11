<?php

namespace App\Http\Controllers;

use App\Models\DeductionList;
use App\Models\DeductionSettings;
use App\Models\StaffsTbl;
use App\Utilities\AccessRoute;
use App\Utilities\AuditTrail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class StaffDeductionController extends Controller
{
    //
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {

            $DeductionTbl = DeductionList::with(['staffs']);

            return DataTables::of($DeductionTbl)
            ->addIndexColumn()
                ->addColumn('action', function ($DeductionTbl) {

                    // $is_active = ($DeductionTbl->is_active == TRUE) ? 'deactivate' : 'activate';

                    //button update
                    $button = '<span class="actionCust editData" title="update term" data-id="' . md5($DeductionTbl->id) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    // //button deactivate activate
                    // $button .='<span class="actionCust '.$is_active.'"  title="'.$is_active.' term" data-id="'.md5($DeductionTbl->id).'" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>' ;

                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);
        }
        $data['staffs'] = StaffsTbl::whereRelation('user','is_active','=',1)->get();
        $data['deductions'] = DeductionSettings::where('is_active',1)->get();
        $data['permissions'] = AccessRoute::user_permissions(session('user')->id);
        return view('dashboard.staff.staff_deductions',$data);
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
        $deduct = new DeductionList();
        $deduct->staff_id = $request->staff_name;
        $deduct->sss = ($request->sss != null) ? $request->sss : '0.00';
        $deduct->tuition_fee = ($request->tuition_fee != null) ? $request->tuition_fee : '0.00';
        $deduct->canteen = ($request->canteen != null) ? $request->canteen : '0.00';
        $deduct->cash_advance =($request->cash_advance != null) ? $request->cash_advance : '0.00';
        $deduct->others = ($request->others != null) ? $request->others : '0.00';
        $deduct->late_undertime = ($request->late_undertime != null) ? $request->late_undertime : '0.00';
        $deduct->encoded_by = session('user')->full_name;
        if($deduct->save()){
            //log to audit trail
            $new_data = $deduct;
            $action_taken = 'Create';
            $description = 'Add New Staff Deduction';
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
        $data['getDataById'] = DeductionList::where(DB::raw('md5(id)'), $id)->get();
        $data['staffs'] = StaffsTbl::whereRelation('user','is_active','=',1)->get();
        $data['deductions'] = DeductionSettings::where('is_active',1)->get();
        return $data;
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
        $deduct = DeductionList::where(DB::raw('md5(id)'), $id)->first();
        $deduct->staff_id = $request->staff_name;
        $deduct->sss = $request->sss;
        $deduct->tuition_fee = $request->tuition_fee;
        $deduct->canteen = $request->canteen;
        $deduct->cash_advance = $request->cash_advance;
        $deduct->others = $request->others;
        $deduct->late_undertime = $request->late_undertime;
        $deduct->encoded_by = session('user')->full_name;
        $deduct->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        //
    }
}

