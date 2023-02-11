<?php

namespace App\Http\Controllers;

use App\Models\HolidaysSettings;
use App\Utilities\AccessRoute;
use App\Utilities\AuditTrail;
use Carbon\Carbon;
use DateTimeZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class HolidayController extends Controller
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
            $Holiday = HolidaysSettings::orderBy("holiday_date");

            return DataTables::of($Holiday)
                ->addIndexColumn()
                ->addColumn('action', function ($Holiday) {

                    $is_active = ($Holiday->is_active == TRUE) ? 'deactivate' : 'activate';

                    //button update
                    $button = '<span class="actionCust editData" title="update holiday" data-id="' . md5($Holiday->id) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    $button .= '<span class="actionCust ' . $is_active . '"  title="' . $is_active . ' holiday" data-id="' .md5($Holiday->id). '" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>';


                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);

        }

        $permissions = AccessRoute::user_permissions(session('user')->id);
        return view('dashboard.holiday',compact('permissions'));
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
        $Holiday = new HolidaysSettings();
        $Holiday->holiday_name = $request->holiday_name;
        $Holiday->holiday_date = $request->holiday_date;
        $Holiday->is_active =1;
        $Holiday->encoded_by = session("user")->full_name;
        $Holiday->created_at = $nowInManila;
        $Holiday->updated_at =$nowInManila;
        if($Holiday->save()){
             //log to audit trail
             $new_data = $Holiday;
             $action_taken = 'Create';
             $description = 'Add New Holiday';
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
        $getDataById = HolidaysSettings::where(DB::raw('md5(id)'), $id)->get();
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
        $update = HolidaysSettings::where(DB::raw('md5(id)'), $id);
        $data['holiday_name'] = $request->edit_holiday_name;
        $data['holiday_date'] =$request->edit_holiday_date;
        $data['encoded_by'] = session('user')->full_name;
        $data['updated_at'] = $nowInManila;
        $update->update($data);

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
        $deactivate = HolidaysSettings::where(DB::raw('md5(id)'), $id);
        $data['is_active'] = $request->is_active;
        $data['encoded_by'] = session('user')->full_name;
        $data['updated_at'] = $nowInManila;
        $deactivate->update($data);
    }
}
