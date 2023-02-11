<?php

namespace App\Http\Controllers;

use App\Models\SchoolYearTbl;
use App\Utilities\AccessRoute;
use App\Utilities\AuditTrail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class SchoolYearController extends Controller
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
            $SchoolYearTbl = SchoolYearTbl::orderByDesc("school_years");

            return DataTables::of($SchoolYearTbl)
            ->addIndexColumn()
                ->addColumn('action', function ($SchoolYearTbl) {

                    $is_active = ($SchoolYearTbl->is_active == TRUE) ? 'deactivate' : 'activate';

                    //button update
                    $button = '<span class="actionCust editData" title="update school year" data-id="' . md5($SchoolYearTbl->id) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    $button .= '<span class="actionCust ' . $is_active . '"  title="' . $is_active . ' schoole year" data-id="' . md5($SchoolYearTbl->id) . '" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>';


                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);

        }
        $permissions = AccessRoute::user_permissions(session('user')->id);
        return view('dashboard.school_year', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('dashboard.school_year');
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
        DB::table('school_year_tbls')->update(['is_active' => 0]);

        $check_school_year = SchoolYearTbl::where('school_years',$request->sy);
        if($check_school_year->doesntExist()){
            $schoolYear = new SchoolYearTbl;
            $schoolYear->school_years = $request->sy;
            $schoolYear->is_active = 1;
            if($schoolYear->save()){

                //log to audit trail
                $new_data = $schoolYear;
                $action_taken = 'Create';
                $description = 'Created New School Year '.$new_data->school_years;
                AuditTrail::logAuditTrail( $action_taken , $description , $new_data);
                //end log

            return response()->json(['message' => 'New School Year successfully created', 'status' => 'success']);
            }
        }else{
            return response()->json(['message' => 'School Year Already Exist!', 'status' => 'error']);
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
        $getDataById = SchoolYearTbl::where(DB::raw('md5(id)'), $id)->get();
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
        $check_school_year = SchoolYearTbl::where([['school_years','=', $request->sy],[DB::raw('md5(id)'),'<>', $id]]);

        if($check_school_year->doesntExist()){
            
            $old_data = SchoolYearTbl::where(DB::raw('md5(id)'), $id)->first();

            $schoolYear = SchoolYearTbl::where(DB::raw('md5(id)'), $id)->first();
            $schoolYear->school_years = $request->sy;
            if($schoolYear->save()){

                //log to audit trail
                $new_data = $schoolYear;
                $action_taken = 'Update';
                $description = 'Updated School Year '.$old_data->school_years;
                AuditTrail::logAuditTrail( $action_taken , $description , $new_data, $old_data);
                //end log
            
                return response()->json(['message' => 'School Year successfully updated', 'status' => 'success']);
            }
        }else{
            return response()->json(['message' => 'School Year Already Exist!', 'status' => 'error']);
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
        DB::table('school_year_tbls')->update(['is_active' => 0]);

        $old_data = SchoolYearTbl::where(DB::raw('md5(id)'), $id)->first();
        $deactivate = SchoolYearTbl::where(DB::raw('md5(id)'), $id)->first();

        $deactivate->is_active = $request->is_active;
        if($deactivate->save()){
                //log to audit trail
                $stats = ($request->is_active == 1) ? 'Activate':'Deactivate';
                $new_data = $deactivate;
                $action_taken = 'Update';
                $description = $stats.' School Year '.$old_data->school_years;
                AuditTrail::logAuditTrail( $action_taken , $description , $new_data, $old_data);
                //end log
        }
    }
}
