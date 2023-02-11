<?php

namespace App\Http\Controllers;

use App\Models\BranchTbl;
use App\Utilities\AccessRoute;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\RoomTbl;
use App\Utilities\AuditTrail;

class RoomController extends Controller
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

            $RoomTbl = RoomTbl::select("room_tbls.*","branch_tbls.branch_name as branch_name")
            ->join('branch_tbls', 'room_tbls.branch_id', '=', 'branch_tbls.id');


            return DataTables::of($RoomTbl)
            ->addIndexColumn()
                ->addColumn('action', function ($RoomTbl) {
                    $is_active = ($RoomTbl->is_active == TRUE) ? 'deactivate' : 'activate';

                    //button update
                    $button = '<span class="actionCust editData" title="update school year" data-id="' . $RoomTbl->id . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    $button .= '<span class="actionCust ' . $is_active . '"  title="' . $is_active . ' schoole year" data-id="' . $RoomTbl->id . '" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>';


                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->addIndexColumn()
                ->make(true);

        }
        $permissions = AccessRoute::user_permissions(session('user')->id);
        $branches = BranchTbl::all();
        return view('dashboard.room', compact('permissions','branches'));
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
            'room_number' => ['required', 'unique:room_tbls,room_no,except,id'],
            'room_desc' => ['max:100', 'string'],
        ]);
        $room = new RoomTbl;
        $room->room_no = $request->room_number;
        $room->branch_id = $request->room_branch;
        $room->room_description = $request->room_desc;
        $room->is_active = 1;
        if($room->save()){
            //log to audit trail
            $new_data = $room;
            $action_taken = 'Create';
            $description = 'Add New Room';
            AuditTrail::logAuditTrail( $action_taken , $description , $new_data);
            //end log
       }
        return response()->json(['success' => 'New Room successfully created']);

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
    $data["getDataById"] = RoomTbl::find($id);
        $data["branches"] = BranchTbl::all("id","branch_name");
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
        $request->validate([
            'room_number' => ['numeric'],
            'room_desc' => ['max:100', 'string'],
        ]);
        $update = RoomTbl::find($id);
        $data['room_no'] = $request->rn;
        $data['branch_id'] = $request->branch_id;
        $data['room_description'] = $request->rd;
        $update->update($data);
        return response()->json(['success' => 'Room successfully updated']);

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
        $deactivate = RoomTbl::find($id);
        $deactivate->is_active = $request->is_active;
        $deactivate->save();
    }
}
