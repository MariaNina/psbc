<?php

namespace App\Http\Controllers;

use App\Utilities\AccessRoute;
use Illuminate\Http\Request;
use App\Models\DiscountsTbl;
use App\Utilities\AuditTrail;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DiscountsController extends Controller
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

            $DiscountsTbl = DiscountsTbl::select();

            return DataTables::of($DiscountsTbl)
                ->addIndexColumn()
                ->addColumn('action', function ($DiscountsTbl) {

                    $is_active = ($DiscountsTbl->is_active == TRUE) ? 'deactivate' : 'activate';

                    //button update
                    $button = '<span class="actionCust editData" title="update branch" data-id="' . md5($DiscountsTbl->id) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    $button .= '<span class="actionCust ' . $is_active . '"  title="' . $is_active . ' discount" data-id="' . md5($DiscountsTbl->id) . '" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>';

                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);
        }

        $permissions = AccessRoute::user_permissions(session('user')->id);

        return view('dashboard.discounts', compact('permissions'));
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
        $discount = new DiscountsTbl();
        $discount->discount_name = $request->discount_name;
        $discount->discount_description = $request->description;
        $discount->student_department = $request->student_dept;
        if($request->discount_type == 'Percentage'){
            $discount->amount = 'X'.$request->amount;
        }else{
            $discount->amount = $request->amount;
        }
        
        $discount->discount_type = $request->discount_type;
        $discount->is_active = 1;
        if($discount->save()){
              //log to audit trail
              $new_data = $discount;
              $action_taken = 'Create';
              $description = 'Create New Discount';
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
        $data['getDataById'] = DiscountsTbl::where(DB::raw('md5(id)'), $id)->get();
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
        $old_data = DiscountsTbl::where(DB::raw('md5(id)'), $id)->first();

        $update = DiscountsTbl::where(DB::raw('md5(id)'), $id)->first();
        $update->discount_name = $request->discount_name;
        $update->discount_description = $request->description;
        $update->student_department = $request->student_dept;
        if($request->discount_type == 'Percentage'){
            $update->amount  = 'X'.$request->amount;
        }else{
            $update->amount  = $request->amount;
        }
        $update->discount_type = $request->discount_type;
        if($update->save()){
            //log to audit trail
            $new_data = $update;
            $action_taken = 'Update';
            $description = 'Update Discount';
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
    public function destroy(Request $request, $id)
    {
        //
        $old_data = DiscountsTbl::where(DB::raw('md5(id)'), $id)->first();
        $deactivate = DiscountsTbl::where(DB::raw('md5(id)'), $id)->first();

        $deactivate->is_active = $request->is_active;
        if($deactivate->save()){
                //log to audit trail
                $stats = ($request->is_active == 1) ? 'Activate':'Deactivate';
                $new_data = $deactivate;
                $action_taken = 'Update';
                $description = $stats.' Discount';
                AuditTrail::logAuditTrail( $action_taken , $description , $new_data, $old_data);
                //end log
        }
    }
}
