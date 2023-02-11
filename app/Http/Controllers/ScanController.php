<?php

namespace App\Http\Controllers;

use App\Models\ScanModel;
use App\Models\StudentsTbl;
use App\Utilities\AccessRoute;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\StudentT;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class ScanController extends Controller
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

            $Students = ScanModel::latest();
            return DataTables::of($Students)
            ->make(true);

        }
       $permissions = AccessRoute::user_permissions(session('user')->id);
        return view('dashboard.scan', compact('permissions'));
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
        $StudentAttendance = new ScanModel();
        $StudentAttendance->student_name = $request->student_name;
        if($request->lrn==null){
            $StudentAttendance->lrn = "N/A";
        }
        else{
        $StudentAttendance->lrn = $request->lrn;
        }
        $data = ScanModel::latest()->where('student_name',$request->student_name,)->first();
        $StudentAttendance->department = $request->department;
        //return $data;
        if(!empty($data) || $data!==null)
        {
        if($data->status === 1)
        {
            $StudentAttendance->status = 0;
        }
        else{
            $StudentAttendance->status = 1; 
        }
    }else{
        $StudentAttendance->status = 1; 
    }
        $StudentAttendance->save();
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
