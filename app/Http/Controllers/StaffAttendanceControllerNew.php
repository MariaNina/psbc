<?php

namespace App\Http\Controllers;

use App\Models\AttendanceSummaryView;
use App\Models\CutOff;
use App\Models\HolidaysSettings;
use App\Models\StaffAttendance;
use App\Models\StaffsTbl;
use App\Models\TimeSettings;
use App\Utilities\AccessRoute;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Yajra\DataTables\DataTables;

class StaffAttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $begin = new DateTime();
            $end = new DateTime();

            $holidays = HolidaysSettings::get();
            $holidays_array = [];
            foreach($holidays as $row){
                $holidays_array[] = $row->holiday_date;
            }

            $attendance =  new Collection();
            if(isset($request->from) && isset($request->to)){
                $begin = new DateTime($request->from);
                $end = new DateTime($request->to);
            }else{

                $cut_off = CutOff::latest()->first();
                if(!empty($cut_off->start_date)){
                    $begin = new DateTime($cut_off->start_date);
                    $end = new DateTime($cut_off->end_date);
                }
            }
        

            $interval = DateInterval::createFromDateString('1 day');
            $period = new DatePeriod($begin, $interval, $end);

            $staffs = StaffsTbl::select('staffs_tbls.*','time_settings.morning_in','time_settings.afternoon_out')->join('time_settings','time_settings.staff_id','staffs_tbls.id')->get();  
            
            if($request->dept != 'all'){
                $staffs = $staffs->where('staffs_tbls.Department',$request->dept);
            }
            foreach($staffs as $staff){
                $first_name = ($staff->first_name) ?? '';
                $last_name = ($staff->last_name) ?? '';
                $shift = ($staff->morning_in)?? ''.' - '.($staff->afternoon_out) ?? '';
                $shift_hours = ($staff->required_time) ?? '';

                $time_setting = TimeSettings::where('staff_id',$staff->id)->first();
                $days = $time_setting->days;
                $shift = $time_setting->morning_in.'-'.$time_setting->afternoon_out;
                $shift_hours = $time_setting->required_time;

                $AttendanceTbl = StaffAttendance::where('bio_id',$staff->bio_id)
                ->whereBetween('staff_attendances2.punch_date',[$begin,$end])->get();
                
                $attendance_punch_dates = [];
                foreach($AttendanceTbl as $row){
                    $attendance_punch_dates[] = $row->punch_date;
                }

             
             
                 $i = 1;

                foreach($AttendanceTbl as $row){
                    $attendance->push([
                        // "id" => 1,
                        "punch_date" => $row->punch_date,
                        "punch_day" => $row->punch_day,
                        "first_name" => $first_name,
                        "last_name" => $last_name,
                        "shift" => $shift,
                        "shift_hours" => $shift_hours,
                        "morning_in" => $row->punch_time_in,
                        "afternoon_out" => $row->punch_time_out,
                        "lates" => $row->late,
                        "undertime" => $row->undertime,
                        "status" => ''
                        
                    ]);
                }
                // foreach($period as $dt){
                //     $punch_date = $dt->format("Y-m-d");
                //     $punch_day = strtoupper($dt->format("D"));

                //     if(preg_match("/\b{$punch_day}\b/", $days) && !in_array($punch_date,$attendance_punch_dates) && !in_array($punch_date,$holidays_array)){
                //         $attendance->push([
                //             // "id" => 1,
                //             "punch_date" => $punch_date,
                //             "punch_day" => $punch_day,
                //             "first_name" => $first_name,
                //             "last_name" => $last_name,
                //             "shift" => $shift,
                //             "shift_hours" => $shift_hours,
                //             "morning_in" => 'ABSENT',
                //             "afternoon_out" => 'ABSENT',
                //             "lates" => '',
                //             "undertime" => '',
                //             "status" => 'ABSENT'
                            
                //         ]);
                       
                //     }
                //     if(in_array($punch_date,$holidays_array)){
                //         $attendance->push([
                //             // "id" => 1,
                //             "punch_date" => $punch_date,
                //             "punch_day" => $punch_day,
                //             "first_name" => $first_name,
                //             "last_name" => $last_name,
                //             "shift" => $shift,
                //             "shift_hours" => $shift_hours,
                //             "morning_in" => 'HOLIDAY',
                //             "afternoon_out" => 'HOLIDAY',
                //             "lates" => '',
                //             "undertime" => '',
                //             "status" => 'HOLIDAY'
                //         ]);
                       
                //     }
                //     if(!preg_match("/\b{$punch_day}\b/", $days)){
                //         $attendance->push([
                //             // "id" => 1,
                //             "punch_date" => $punch_date,
                //             "punch_day" => $punch_day,
                //             "first_name" => $first_name,
                //             "last_name" => $last_name,
                //             "shift" => $shift,
                //             "shift_hours" => $shift_hours,
                //             "morning_in" => 'RESTDAY',
                //             "afternoon_out" => 'RESTDAY',
                //             "lates" => '',
                //             "undertime" => '',
                //             "status" => 'RESTDAY'
                //         ]);
                       
                //     }
                //     $i++;
                // }

            }
            return DataTables::of($attendance)
                ->addIndexColumn()
                ->addColumn('action', function ($attendance) {

                    // $is_active = ($attendance->is_active == TRUE) ? 'deactivate' : 'activate';

                    //button update
                    $button = '<span class="actionCust editData" title="update term" data-id=""><a class=""><i class="fas fa-edit"></i></a></span>';

                    // //button deactivate activate
                    // $button .='<span class="actionCust '.$is_active.'"  title="'.$is_active.' term" data-id="'.md5($AttendanceTbl->id).'" ><a class="delete-btn"><i class="fa fa-power-off"></i></a></span>' ;

                    return $button; // Return Button
                })
                ->rawColumns(['action']) // Set to raw column to say to datatable that column 'action' is a HTML raw that need to be rendered as HTML5
                ->make(true);
        }
        $permissions = AccessRoute::user_permissions(session('user')->id);
        return view('dashboard.staff.staff_attendance',compact('permissions'));
    }

    public function saveAttendance(Request $request)
    {

        $success = 0;
        $error = 0;
        if (!empty($_FILES["import_excel"]["tmp_name"])) {

            $path = $_FILES["import_excel"]["tmp_name"];
            $reader = IOFactory::createReader('Xls');
            // $reader->setReadDataOnly(FALSE);
            $spreadsheet = $reader->load($path);
            
            $worksheet = $spreadsheet->getSheetByName('Exception Stat.');
            // foreach ($object->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestDataRow('A');
                // $highestColumn = $worksheet->getHighestColumn();
                for ($row = 5; $row <= $highestRow; $row++) {
                    $punch_date = "";
                    $punch_day = "";
                    $punch_time_out = "";
                    $punch_time_in = "";
                    $bio_id = "";

                    $bio_id = trim($worksheet->getCellByColumnAndRow(1, $row)->getValue());

                    $excel_date = trim($worksheet->getCellByColumnAndRow(4, $row)->getValue());
                    if($excel_date != ""){
                        $punch_date = $excel_date;
                        $day = strtotime($excel_date);
                        $punch_day = date("D", $day);
                    }
               

                    $excel_time = trim($worksheet->getCellByColumnAndRow(5, $row)->getValue());
                    if($excel_time != ""){
                        $punch_time_in = $excel_time;
                    }

                    $excel_time2 = trim($worksheet->getCellByColumnAndRow(6, $row)->getValue());
                    if($excel_time2 != ""){
                        $punch_time_out = $excel_time2;
                    }
                    $late = trim($worksheet->getCellByColumnAndRow(9, $row)->getValue());

                    if($excel_time != "" && $excel_date != ""){
                        //save in users table
                        $staff = new StaffAttendance();
                        $staff->bio_id = $bio_id;
                        $staff->punch_date = $punch_date;
                        $staff->punch_day = $punch_day;
                        $staff->punch_time_in = $punch_time_in;
                        $staff->punch_time_out = $punch_time_out;
                        $staff->late = $late;

                        if ($staff->save()) {
                            $success++;
                        } else {
                            $error++;
                        }
                    }
                }

            // }

            return response()->json([
                'msg' => $success . ' items saved successfully. ' . $error . ' items with errors'
            ]);

        }
    }
}
