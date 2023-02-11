<?php

namespace App\Http\Controllers;

use App\Utilities\AccessRoute;
use Illuminate\Http\Request;
use App\Models\CurriculumSubjectsTbl;
use Yajra\DataTables\DataTables;
use App\Models\RoomTbl;
use App\Models\BranchTbl;
use App\Models\SectionsTbl;
use App\Models\StaffsTbl;
use App\Models\LevelsTbl;
use App\Models\CurriculumTbl;
use App\Models\TermsTbl;
use App\Models\SchoolYearTbl;
use App\Models\SchedulesTbl;
use Illuminate\Support\Facades\DB;
use App\Models\SubjectTbl;
use App\Utilities\AuditTrail;
use Illuminate\Database\Eloquent\Builder;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $schedules = SchedulesTbl::select("schedules_tbls.id as sched_id",
            DB::raw("CONCAT(schedules_tbls.start_time, '-',schedules_tbls.end_time) as time"),
            "schedules_tbls.days as days", "room_tbls.room_no as room",
            "sections_tbls.section_label as section", DB::raw("CONCAT(subject_tbls.subject_code, ':',subject_tbls.subject_name) as subject"),
            DB::raw("CONCAT(staffs_tbls.last_name,' ',staffs_tbls.first_name) as teacher"))
            ->join('sections_tbls', 'schedules_tbls.section_id', '=', 'sections_tbls.id')
            ->join('subject_tbls', 'schedules_tbls.subject_id', '=', 'subject_tbls.id')
            ->join('staffs_tbls', 'schedules_tbls.staff_id', '=', 'staffs_tbls.id')
            ->join('room_tbls', 'schedules_tbls.room_id', '=', 'room_tbls.id');

        if ($request->ajax()) {

            return DataTables::of($schedules)
                ->addColumn('action', function ($schedules) {
                    //button delete
                    $button = '<button class="btn btn-danger delete_row" data-id="' . $schedules->sched_id . '" id="' . $schedules->sched_id . '" type="button"><i class="fas fa-trash"></i></button>';
                    return $button;
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);
        }
        $data['title'] = "Create Schedule";
        $data['rooms'] = RoomTbl::all()->where("branch_id", session('user')->branch_id)->sortBy("room_no");
        // return $data['rooms'];
        $data['subjects'] = SubjectTbl::all();
        $data['teachers'] = StaffsTbl::all()->where("staff_type", "Academic");
        $data['schoolYears'] = SchoolYearTbl::all()->where("is_active", '1')->first();
        $data['branches'] = BranchTbl::all()->where("id", session('user')->branch_id)->first();
        $data['terms'] = TermsTbl::all();
        $data['sections'] = SectionsTbl::all();
        $data['permissions'] = AccessRoute::user_permissions(session('user')->id);

        $data['staffs'] = StaffsTbl::where('position', 'Teacher')
            ->distinct()->get(['first_name', 'last_name']);

        return view('dashboard.schedule', $data);
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
        $x = 0;
        while ($x < count($request->teacher)) {
            $schedule = new SchedulesTbl;
            $schedule->branch_id = session('user')->branch_id;
            $term = null;
            if ($request->department == "JHS" || $request->department == "Elementary") {
                $term = TermsTbl::all("id", "term_name")->where("term_name", "N/A")->first();
                $term = $term->id;
            } else if ($request->department == "SHS" || $request->department == "College" || $request->department == "Graduate Studies") {
                $term = TermsTbl::all("id", "term_name", "is_active")->where("is_active", "=", 1)->first();
                $term = $term->id;
            } else {
                $term = "";
            }
            $schedule->term_id = $term;
            $schedule->staff_id = $request->teacher[$x];
            $schedule->section_id = $request->section[$x];
            $schedule->subject_id = $request->subject[$x];
            $schedule->room_id = $request->roomNumber;
            $schedule->school_year_id = $request->sy;
            $mon = isset($request->M[$x]) ? $request->M[$x] : "_";
            $tues = isset($request->T[$x]) ? $request->T[$x] : "_";
            $wed = isset($request->W[$x]) ? $request->W[$x] : "_";
            $thu = isset($request->TH[$x]) ? $request->TH[$x] : "_";
            $fri = isset($request->F[$x]) ? $request->F[$x] : "_";
            $sat = isset($request->S[$x]) ? $request->S[$x] : "_";
            $schedule->days = $mon . $tues . $wed . $thu . $fri . $sat;
            $schedule->start_time = $request->startTime[$x];
            $schedule->end_time = $request->endTime[$x];
            $schedule->room_days_time = $schedule->term_id . $schedule->school_year_id . $schedule->branch_id . $schedule->room_id . $schedule->days . $schedule->start_time . $schedule->end_time;
            $schedule->teacher_days_time = $schedule->term_id . $schedule->school_year_id . $schedule->branch_id . $schedule->staff_id . $schedule->days . $schedule->start_time . $schedule->end_time;
            $schedule->section_days_time = $schedule->term_id . $schedule->school_year_id . $schedule->branch_id . $schedule->section_id . $schedule->days . $schedule->start_time . $schedule->end_time;
            $schedule->section_subject = $schedule->term_id . $schedule->school_year_id . $schedule->branch_id . $schedule->section_id . $schedule->subject_id;
            if($schedule->save()){
                //log to audit trail
                $new_data = $schedule;
                $action_taken = 'Create';
                $description = 'Add New Schedule';
                AuditTrail::logAuditTrail( $action_taken , $description , $new_data);
                //end log
           }
            $mon = null;
            $tues = null;
            $wed = null;
            $thu = null;
            $fri = null;
            $sat = null;
            $x++;

        }
        //return response()->json($schedule);

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
    public function edit(Request $request, $id)
    {
        //
        $data['getDatabyId'] = SchedulesTbl::where(DB::raw('md5(id)'), $id)->first();
        $data['subject'] = SubjectTbl::where('id', $data['getDatabyId']->subject_id)->first();
        $data['rooms'] = RoomTbl::all();
        $data['teachers'] = StaffsTbl::all()->where('staff_type', 'Academic');
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
        $update = SchedulesTbl::where(DB::raw('md5(id)'), $id);
        $data['staff_id'] = $request->teacher;
        $data['room_id'] = $request->room;
        $data['days'] = $request->day1 . $request->day2 . $request->day3 . $request->day4 . $request->day5 . $request->day6;
        $data['start_time'] = $request->startTime;
        $data['end_time'] = $request->endTime;
        $data['room_days_time'] = $data['room_id'] . "," . $data['days'] . "," . $data['start_time'] . "," . $data['end_time'];
        $data['teacher_days_time'] = $data['staff_id'] . "," . $data['days'] . "," . $data['start_time'] . "," . $data['end_time'];
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
        $delete = SchedulesTbl::where("id", $id);
        $delete->delete();
    }

    public function getDatas($type = "kto12")
    {
        $data["section"] = null;

        if ($type !== "kto12") // IF not college
            $data["section"] = SectionsTbl::whereRelation('levels',function($query){
                $query->whereIn('student_dept',['Graduate Studies','College']);
            })
                ->where("is_active", 1)
                ->orderBy("section_label")
                ->get(["id", "section_label", "is_active"]);
        else
            $data["section"] = SectionsTbl::select("id", "section_label", "is_active")->where("is_active", 1)->orderBy("section_label")->get();


        $data["subjects"] = SubjectTbl::select("id", "subject_code", "subject_name", "is_offered")->where("is_offered", 1)->orderBy("subject_name")->get();
        $data["teachers"] = StaffsTbl::select("id", "last_name", "first_name", "staff_type")->where("staff_type", "Academic")->orderBy("last_name")->get();
        $data["rooms"] = RoomTbl::where('branch_id', session('user')->branch_id)->get();
        return response()->json($data);
    }

    public function getAllSchedule($id)
    {
        $schedules = SchedulesTbl::select("schedules_tbls.id as sched_id",
            DB::raw("CONCAT(schedules_tbls.start_time, '-',schedules_tbls.end_time) as time"),
            "schedules_tbls.days as days", "room_tbls.room_no as room_id",
            "sections_tbls.section_label as section", DB::raw("CONCAT(subject_tbls.subject_code, ':',subject_tbls.subject_name) as subject"),
            DB::raw("CONCAT(staffs_tbls.last_name,' ',staffs_tbls.first_name) as teacher"))
            ->join('sections_tbls', 'schedules_tbls.section_id', '=', 'sections_tbls.id')
            ->join('subject_tbls', 'schedules_tbls.subject_id', '=', 'subject_tbls.id')
            ->join('staffs_tbls', 'schedules_tbls.staff_id', '=', 'staffs_tbls.id')
            ->join('room_tbls', 'schedules_tbls.room_id', '=', 'room_tbls.id')->where("room_id", $id)->get();
        return response()->json($schedules);
    }

    // College
    public function collegeSchedule()
    {
        $branch = BranchTbl::find(session('user')->branch_id);
        $permissions = AccessRoute::user_permissions(session('user')->id);

        // Curriculum that has subjects and also curriculum that is college
//        $subjects = CurriculumTbl::has('subjects')
//            ->where('student_department', 'College')
//            ->with('subjects')
//            ->get();

        // Registered Subjects in Curriculum that is College
        $subjects = SubjectTbl::whereHas('curriculums', function ($query) {
            $query->where('student_department', 'College')
            ->orWhere('student_department','Graduate Studies');
        })
            ->distinct()
            ->get();

        $sy = SchoolYearTbl::latest('school_years')->where("is_active", '1')->first();
        $terms = TermsTbl::where('term_name', '!=', 'N/A')->get();

        $staffs = StaffsTbl::where('position', 'Teacher')
            ->distinct()->get(['first_name', 'last_name']);

        return view('dashboard.schedule_college', compact('branch', 'permissions', 'subjects', 'sy', 'terms', 'staffs'));
    }

    public function collegeScheduleDatatable(Request $request, $id)
    {
        if ($request->ajax()) {

            $sy = SchoolYearTbl::latest('school_years')->where("is_active", '1')->first();

            $schedules = SchedulesTbl::whereHas('term', function ($query) {
                $query->where('term_name', '!=', 'N/A');
            })
                ->whereHas('section.levels', function ($query) {
                    $query->where('student_dept', '=', 'College')
                        ->orWhere('student_dept', '=', 'Graduate Studies');
                })
                ->whereRelation('subject', 'id', $id)
                ->where('school_year_id', $sy->id)
                ->with(['section', 'instructor', 'room'])
                ->get();

            return DataTables::of($schedules)
                ->addColumn('time', function ($schedules) {
                    return '<span>' . $schedules->start_time . ' - ' . $schedules->end_time . '</span>';
                })
                ->addColumn('section', function ($schedules) {
                    return '<span>' . $schedules->section->section_label . '</span>';
                })
                ->addColumn('instructor', function ($schedules) {
                    return '<span>' . $schedules->instructor->last_name . ' ' . $schedules->instructor->first_name . '</span>';
                })
                ->addColumn('room', function ($schedules) {
                    return $schedules->room->room_no;
                })
                ->addColumn('term', function ($schedules) {
                    return $schedules->term->term_name;
                })
                ->addColumn('action', function ($schedules) {
                    //button delete
                    return '<button class="btn btn-danger delete_row" data-id="' . $schedules->id . '" id="' . $schedules->id . '" type="button"><i class="fas fa-trash-alt"></i></button>';
                })
                ->rawColumns(['time', 'section', 'instructor', 'room,', 'term', 'action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);
        }

        return redirect('/college_schedule');
    }

    public function collegeScheduleStore(Request $request)
    {
        $x = 0;

        while ($x < count($request->teacher)) {
            $schedule = new SchedulesTbl;
            $schedule->branch_id = session('user')->branch_id;
            $schedule->term_id = $request->term[$x];
            $schedule->staff_id = $request->teacher[$x];
            $schedule->section_id = $request->section[$x];
            $schedule->subject_id = $request->subject_id;
            $schedule->room_id = $request->roomNumber[$x];
            $schedule->school_year_id = $request->sy;

            $mon = isset($request->M[$x]) ? $request->M[$x] : "_";
            $tues = isset($request->T[$x]) ? $request->T[$x] : "_";
            $wed = isset($request->W[$x]) ? $request->W[$x] : "_";
            $thu = isset($request->TH[$x]) ? $request->TH[$x] : "_";
            $fri = isset($request->F[$x]) ? $request->F[$x] : "_";
            $sat = isset($request->S[$x]) ? $request->S[$x] : "_";
            $schedule->days = $mon . $tues . $wed . $thu . $fri . $sat;

            $schedule->start_time = $request->startTime[$x];
            $schedule->end_time = $request->endTime[$x];
            $schedule->room_days_time = $schedule->term_id . $schedule->school_year_id . $schedule->branch_id . $schedule->room_id . $schedule->days . $schedule->start_time . $schedule->end_time;
            $schedule->teacher_days_time = $schedule->term_id . $schedule->school_year_id . $schedule->branch_id . $schedule->staff_id . $schedule->days . $schedule->start_time . $schedule->end_time;
            $schedule->section_days_time = $schedule->term_id . $schedule->school_year_id . $schedule->branch_id . $schedule->section_id . $schedule->days . $schedule->start_time . $schedule->end_time;
            $schedule->section_subject = $schedule->term_id . $schedule->school_year_id . $schedule->branch_id . $schedule->section_id . $schedule->subject_id;
            $schedule->save();

            $mon = null;
            $tues = null;
            $wed = null;
            $thu = null;
            $fri = null;
            $sat = null;

            $x++;

        }
    }

    public function collegeScheduleDestroy(SchedulesTbl $schedulesTbl)
    {
        $schedulesTbl->delete();

        return response([
            'msg' => 'Deleted'
        ]);
    }

}
