<?php

namespace App\Http\Controllers;

use App\Models\TimeSettings;
use App\Utilities\AccessRoute;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class TimeSettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('has_permission:assessments');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            DB::statement(DB::raw('set @rownum=0'));
            $timeSettings = TimeSettings::with('staff:id,first_name,last_name')->get(['*', DB::raw('@rownum :=@rownum+1 as No')]);

            return DataTables::of($timeSettings)
                ->addColumn('staff_name', function ($timeSettings) {
                    return $timeSettings->staff->first_name . ' ' . $timeSettings->staff->last_name;
                })
                ->addColumn('morning_in', function ($timeSettings) {
                    return $timeSettings->morning_in === NULL ? 'None' : $timeSettings->morning_in;
                })
                ->addColumn('morning_out', function ($timeSettings) {
                    return $timeSettings->morning_out === NULL ? 'None' : $timeSettings->morning_out;
                })
                ->addColumn('afternoon_in', function ($timeSettings) {
                    return $timeSettings->afternoon_in === NULL ? 'None' : $timeSettings->afternoon_in;
                })
                ->addColumn('afternoon_out', function ($timeSettings) {
                    return $timeSettings->afternoon_out === NULL ? 'None' : $timeSettings->afternoon_out;
                })
                ->addColumn('days', function ($timeSettings) {
                    return $timeSettings->days === NULL ? 'None' : $timeSettings->days;
                })
                ->addColumn('required_time', function ($timeSettings) {
                    return $timeSettings->required_time === NULL ? 'None' : $timeSettings->required_time;
                })
                ->addColumn('action', function ($timeSettings) {
                    return '
                    <span class="actionCust">
                        <a href="#!" class="editTimeSettingsModalBtn" id="editTimeSettingsModalBtn" data-id="' . $timeSettings->id . '" role="button" data-toggle="modal" data-target="#editTimeSettingsModal"><i class="fas fa-edit"></i></a>
                    </span>
                    '; // Return Button
                })
                ->rawColumns(['staff_name', 'morning_in', 'morning_out', 'afternoon_in', 'afternoon_out', 'days', 'required_time', 'action'])
                ->make(true);
        }

        $data['permissions'] = AccessRoute::user_permissions(session('user')->id);
        return view('dashboard.time_settings', $data);
    }

    public function edit($id)
    {
        $timeSettings = TimeSettings::with('staff:id,first_name,middle_name,last_name')->find($id);
        if($timeSettings['days'] != null) {
            $timeSettings['days'] = explode(",", $timeSettings->days); // Split Every String by Comma
        }
        
        return response()->json($timeSettings);
    }

    public function update(Request $request, $id)
    {
        $data = request()->validate([
            'morning_in' => 'required',
            'morning_out' => 'required',
            'afternoon_in' => 'required',
            'afternoon_out' => 'required',
            'days' => 'required',
            'required_time' => 'required'
        ]);

        $timeSettingOfStaff = TimeSettings::find($id);

        $days = '';

        foreach ($request->days as $day) {
            $days .= $day . ',';
        }

        $data['days'] = rtrim($days, ',');

        $timeSettingOfStaff->update($data);

        return response()->json(['msg' => 'Modified Successfully']);
    }
}
