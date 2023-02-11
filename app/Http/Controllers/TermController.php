<?php

namespace App\Http\Controllers;

use App\Utilities\AccessRoute;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\TermsTbl;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\SubjectController;
use App\Utilities\AuditTrail;

class TermController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $TermsTbl = TermsTbl::select();
            return DataTables::of($TermsTbl)
                ->addIndexColumn()
                ->addColumn('action', function ($TermsTbl) {

                    $is_active = ($TermsTbl->is_active == TRUE) ? 'deactivate' : 'activate';

                    //button update
                    $button = '<span class="actionCust editData" title="update term" data-id="' . md5($TermsTbl->id) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    $button .= '<span class="actionCust ' . $is_active . '"  title="' . $is_active . ' term" data-id="' . md5($TermsTbl->id) . '" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>';


                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);

        }
        $title = "Semesters";
        $permissions = AccessRoute::user_permissions(session('user')->id);

        return view('dashboard.term', compact('title', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $gg = (new SubjectController)->method();
        return view('dashboard.term');
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
            'termName' => ['required', 'max:30', 'min:3', 'unique:terms_tbls,term_name,except,id'],
        ]);
        DB::table('terms_tbls')->where("term_name","!=","N/A")->update(['is_active' => 0]);
        $term = new TermsTbl;
        $term->term_name = $request->termName;
        $term->is_active = 1;
        if($term->save()){
            //log to audit trail
            $new_data = $term;
            $action_taken = 'Create';
            $description = 'Add New Term';
            AuditTrail::logAuditTrail( $action_taken , $description , $new_data);
            //end log
       }
        return response()->json(['success' => 'New Term successfully created']);

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
        $getDataById = TermsTbl::where(DB::raw('md5(id)'), $id)->get();
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
            'termName' => ['required', 'max:30', 'min:3'],
        ]);
        $update = TermsTbl::where(DB::raw('md5(id)'), $id);
        $data['term_name'] = $request->termName;
        $update->update($data);
        return response()->json(['success' => 'Term successfully updated']);

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
        $deactivate = TermsTbl::where(DB::raw('md5(id)'), $id);
        $data['is_active'] = $request->is_active;
        $deactivate->update($data);
    }
}
