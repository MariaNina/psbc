<?php

namespace App\Http\Controllers;

use App\Models\GuardianTbl;
use App\Utilities\AccessRoute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ParentsController extends Controller
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

            $GuardianTbl = GuardianTbl::select();

            return DataTables::of($GuardianTbl)

                ->addIndexColumn()
                ->addColumn('action', function ($GuardianTbl) {
                    $is_active = ($GuardianTbl->is_active == TRUE) ? 'deactivate' : 'activate';

                    //button update
                    $button = '<span class="actionCust editData" title="update role" data-id="' . md5($GuardianTbl->id) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    // $button .= '<span class="actionCust ' . $is_active . '"  title="' . $is_active . ' role" data-id="' . md5($GuardianTbl->id) . '" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>';


                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);

        }
        $permissions = AccessRoute::user_permissions(session('user')->id);

        return view('dashboard.parents', compact('permissions'));
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
        $getDataById = GuardianTbl::where(DB::raw('md5(id)'),$id)->first();

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
        $update = GuardianTbl::where(DB::raw('md5(id)'),$id)->first();
        $update->first_name = $request->first_name;
        $update->last_name = $request->last_name;
        $update->middle_name = $request->middle_name;
        $update->address = $request->address;
        $update->contact_number = $request->contact_number;
        $update->save();
    }

}
