<?php

namespace App\Http\Controllers;

use App\Utilities\AccessRoute;
use Illuminate\Http\Request;
use App\Models\SubjectTbl;
use App\Utilities\AuditTrail;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class SubjectController extends Controller
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

            $SubjectTbl = SubjectTbl::select();
            return DataTables::of($SubjectTbl)
            ->addIndexColumn()
                ->addColumn('action', function ($SubjectTbl) {

                    $is_offered = ($SubjectTbl->is_offered == TRUE) ? 'deactivate' : 'activate';

                    //button update
                    $button = '<span class="actionCust editData" title="update school year" data-id="' . md5($SubjectTbl->id) . '"><a class=""><i class="fas fa-edit"></i></a></span>';

                    //button deactivate activate
                    $button .= '<span class="actionCust ' . $is_offered . '"  title="' . $is_offered . ' schoole year" data-id="' . md5($SubjectTbl->id) . '" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>';


                    return $button; // Return Button
                })
                ->addColumn('image', function ($BranchTbl) {
                    $name = $BranchTbl->subject_name;
                    $image = $BranchTbl->subject_image; // Return Row NUmber
                    $avatar = $name[0];

                    if (!empty($image)) { //check if image is empty
                        $destinationPath = asset('storage/subject_images/' . $image);
                    } else {
                        $destinationPath = asset('/uploads/avatars/' . $avatar . '.svg');
                    }


                    $img = '<img class="img-profile rounded-circle"
                        src="' . $destinationPath . '" width="50px" height="50px" >';

                    return $img;
                })
                ->rawColumns(['image', 'action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);

        }
        $permissions = AccessRoute::user_permissions(session('user')->id);
        return view('dashboard.subject', compact('permissions'));
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
        $subject = new SubjectTbl;
        $subject_name = $request->subject_name;

        if ($request->hasFile('subject_image')) { //check if it has file
            $image = $request->file('subject_image'); //get file
            $image_name = time() . $subject_name . '.' . $image->getClientOriginalExtension(); //create a unique file name
            $destinationPath = storage_path('app/public/subject_images'); //path to save image 'url/public/uploads/...'
            $image->move($destinationPath, $image_name); //move and save file to folder
            $subject->subject_image = $image_name; //declare to save in database
        }

        $subject->subject_code = $request->subject_code;
        $subject->subject_name = $subject_name;
        $subject->subject_description = $request->subject_desc;
        $subject->subject_type = $request->subject_type;
        $subject->is_offered = 1;
        $subject->is_for_college = $request->is_for_college;
        $subject->lect_unit = $request->lect_units;
        $subject->lab_unit = $request->lab_units;
        if($subject->save()){
            //log to audit trail
            $new_data = $subject;
            $action_taken = 'Create';
            $description = 'Add new subject';
            AuditTrail::logAuditTrail( $action_taken , $description , $new_data);
            //end log
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
        //
        $getDataById = SubjectTbl::where(DB::raw('md5(id)'), $id)->get();
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
        $update = SubjectTbl::where(DB::raw('md5(id)'), $id);
        $subject_name = $request->subject_name;

        if ($request->hasFile('subject_image')) { //check if it has file

            $image = $request->file('subject_image'); //get file
            $image_name = time() . $subject_name . '.' . $image->getClientOriginalExtension(); //create a unique file name
            $destinationPath = storage_path('app/public/subject_images'); //path to save image 'url/public/uploads/...'
            $image->move($destinationPath, $image_name); //move and save file to folder
            $data['subject_image'] = $image_name; //declare to save in database
        }


        $data['subject_code'] = $request->subject_code;
        $data['subject_name'] = $subject_name;
        $data['subject_type'] = $request->subject_type;
        $data['subject_description'] = $request->subject_desc;
        $data['is_for_college'] = $request->is_for_college;
        $data['lect_unit'] = $request->lect_units;
        $data['lab_unit'] = $request->lab_units;
        $update->update($data);
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
        $deactivate = SubjectTbl::where(DB::raw('md5(id)'), $id);
        $data['is_offered'] = $request->is_offered;
        $deactivate->update($data);

    }
    //select all subjects
    // public function getAllSubjects()
    // {
    //     $subjects = SubjectTbl::select("id","subject_code","subject_name","is_offered")->where("is_offered",1)->orderBy("subject_name")->get();

    //     return response()->json($subjects);
    // }
}
