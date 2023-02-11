<?php

namespace App\Http\Controllers;

use App\Models\PageTbl;
use App\Models\UsersTbl;
use App\Utilities\AccessRoute;
use App\Utilities\AuditTrail;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
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

            DB::statement(DB::raw('set @rownum=0'));
            $PageTbl = PageTbl::select(DB::raw('@rownum :=@rownum+1 as rowNum'), "page_tbls.*");

            return DataTables::of($PageTbl)
            ->addIndexColumn()
                ->addColumn('action', function ($PageTbl) {
                    $is_active = ($PageTbl->is_active == TRUE) ? 'deactivate' : 'activate';

                    //button update
                    $button = '<span class="actionCust editData" title="update role" data-id="' . md5($PageTbl->id) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    $button .= '<span class="actionCust ' . $is_active . '"  title="' . $is_active . ' role" data-id="' . md5($PageTbl->id) . '" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>';


                    return $button; // Return Button
                })
                ->addColumn('rowNum', function ($PageTbl) {
                    return $PageTbl->rowNum; // Return Row NUmber
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);

        }

        $permissions = AccessRoute::user_permissions(session('user')->id);

        return view('dashboard.page', compact('permissions'));
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
            'pageName' => ['required', 'max:20', 'min:3', 'unique:role_tbls,role_name,except,id'],
        ]);
        $page = new PageTbl;
        $page->page_name = $request->pageName;
        $page->is_active = 1;
        if($page->save()){
            //log to audit trail
            $new_data = $page;
            $action_taken = 'Create';
            $description = 'Add New Page';
            AuditTrail::logAuditTrail( $action_taken , $description , $new_data);
            //end log
       }
        return response()->json(['success' => 'New Page successfully created']);
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
        $getDataById = PageTbl::where(DB::raw('md5(id)'), $id)->get();
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
            'editPageName' => ['required', 'max:20', 'min:3'],
        ]);
        $update = PageTbl::where(DB::raw('md5(id)'), $id);
        $data['page_name'] = $request->editPageName;
        $update->update($data);
        return response()->json(['success' => 'Role successfully updated']);
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
        $deactivate = PageTbl::where(DB::raw('md5(id)'), $id);
        $data['is_active'] = $request->is_active;
        $deactivate->update($data);
    }

    public function getAllPages()
    {
        $pages = PageTbl::where('is_active', 1)->get();

        return response()->json($pages);
    }

    public function getUserPages($id)
    {
        $user = UsersTbl::with('pages')->findOrFail($id);

        return response()->json($user->pages);
    }
}
