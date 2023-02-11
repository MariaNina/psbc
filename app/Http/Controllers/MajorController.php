<?php

namespace App\Http\Controllers;

use App\Utilities\AccessRoute;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\MajorsTbl;
use App\Utilities\AuditTrail;
use Illuminate\Support\Facades\DB;

class MajorController extends Controller
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

            $MajorTbl = MajorsTbl::select();
            return DataTables::of($MajorTbl)
                ->addIndexColumn()
                ->addColumn('action', function ($MajorTbl) {

                    $is_active = ($MajorTbl->is_active == TRUE) ? 'deactivate' : 'activate';

                    //button update
                    $button = '<span class="actionCust editData" title="update branch" data-id="' . md5($MajorTbl->id) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    $button .= '<span class="actionCust ' . $is_active . '"  title="' . $is_active . ' major" data-id="' . md5($MajorTbl->id) . '" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>';

                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);
        }

        $data['permissions'] = AccessRoute::user_permissions(session('user')->id);
        $data['title'] = 'Majors';
        return view('dashboard.major', $data);
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
        $request->validate([
            'majorCode' => ['required', 'max:10', 'min:3'],
            'majorName' => ['required', 'max:100', 'min:5'],
            'majorDesc' => ['max:100'],
        ]);
        $major = new MajorsTbl;
        $major->major_code = $request->majorCode;
        $major->major_name = $request->majorName;
        $major->major_description = $request->majorDesc;
        $major->is_active = 1;
        if($major->save()){
             //log to audit trail
             $new_data = $major;
             $action_taken = 'Create';
             $description = 'Add New Major';
             AuditTrail::logAuditTrail( $action_taken , $description , $new_data);
             //end log
        }
        return response()->json(['success' => 'New Major successfully created']);

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
        $getDataById = MajorsTbl::where(DB::raw('md5(id)'), $id)->get();
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
        $request->validate([
            'majorCode' => ['required', 'max:10', 'min:3'],
            'majorName' => ['required', 'max:100', 'min:5'],
            'majorDesc' => ['max:100'],
        ]);
        $update = MajorsTbl::where(DB::raw('md5(id)'), $id);
        $data['major_code'] = $request->majorCode;
        $data['major_name'] = $request->majorName;
        $data['major_description'] = $request->majorDesc;
        $update->update($data);
        return response()->json(['success' => 'Major successfully updated']);

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
        $deactivate = MajorsTbl::where(DB::raw('md5(id)'), $id);
        $data['is_active'] = $request->is_active;
        $deactivate->update($data);
    }
}
