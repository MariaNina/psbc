<?php

namespace App\Http\Controllers;

use App\Models\OtherEarningList;
use App\Models\OtherEarningsSettings;
use App\Models\StaffsTbl;
use App\Utilities\AccessRoute;
use App\Utilities\AuditTrail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class StaffOtherEarningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $EarningTbl = OtherEarningList::with(['staffs','other_earnings']);

            return DataTables::of($EarningTbl)
                ->addColumn('action', function ($EarningTbl) {

                    //button update
                    $button = '<span class="actionCust editData" title="update term" data-id="' . md5($EarningTbl->id) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    // //button deactivate activate
                    // $button .='<span class="actionCust '.$is_active.'"  title="'.$is_active.' term" data-id="'.md5($EarningTbl->id).'" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>' ;

                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);
        }
        $data['staffs'] = StaffsTbl::whereRelation('user','is_active','=',1)->get();
        // $data['earnings'] = OtherEarningsSettings::where('is_active',1)->get();
        $data['permissions'] = AccessRoute::user_permissions(session('user')->id);
        return view('dashboard.staff.staff_other_earnings',$data);
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
        $earnings = new OtherEarningList();
        $earnings->earnings_id = $request->earnings;
        $earnings->staff_id = $request->staff_name;
        $earnings->cut_off = $request->period;
        $earnings->status = $request->status;
        $earnings->amount = $request->amount;
        $earnings->encoded_by = session('user')->full_name;
        if($earnings->save()){
            //log to audit trail
            $new_data = $earnings;
            $action_taken = 'Create';
            $description = 'Add New Earnings';
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
        $data['getDataById'] = OtherEarningList::where(DB::raw('md5(id)'), $id)->get();
        $data['staffs'] = StaffsTbl::whereRelation('user','is_active','=',1)->get();
        $data['earnings'] = OtherEarningsSettings::where('is_active',1)->get();
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
        $earnings = OtherEarningList::where(DB::raw('md5(id)'), $id)->first();
        $earnings->earnings_id = $request->earnings;
        $earnings->staff_id = $request->staff_name;
        $earnings->cut_off = $request->period;
        $earnings->status = $request->status;
        $earnings->amount = $request->amount;
        $earnings->encoded_by = session('user')->full_name;
        $earnings->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
