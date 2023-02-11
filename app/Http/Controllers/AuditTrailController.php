<?php

namespace App\Http\Controllers;

use App\Models\AuditTrailTbl;
use App\Utilities\AccessRoute;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AuditTrailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $AuditTrailTbl = AuditTrailTbl::select('audit_trail_tbls.*','users_tbls.user_name')
            ->join('users_tbls','users_tbls.id','=','audit_trail_tbls.user_id')->orderBy('audit_trail_tbls.datetime','DESC');

            if (session('user')->role != "Super Admin") {
                $AuditTrailTbl = $AuditTrailTbl->where('audit_trail_tbls.user_id', session('user')->id);
            }
      
            return DataTables::of($AuditTrailTbl)
                ->addIndexColumn()
                ->make(true);
        }

        $permissions = AccessRoute::user_permissions(session('user')->id);


        return view('dashboard.audit_trail', compact('permissions'));
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
