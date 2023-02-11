<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchedulesTbl extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "schedules_tbls";
    protected $fillable = [
        'branch_id', 'term_id', 'staff_id', 'section_id', 'subject_id', 'room_id',
        'days', 'start_time', 'end_time', 'room_days_time', 'teacher_days_time', 'school_year_id',
    ];

    public function getStartClassAttribute()
    {
        return Carbon::parse($this->start_time)->format('g:i A');
    }

    public function getEndClassAttribute()
    {
        return Carbon::parse($this->end_time)->format('g:i A');
    }

    public function getFormatedDaysAttribute()
    {
        $days = explode('_', $this->days);
        $arr = array();
        foreach ($days as $day) {
            $txt = '';
            if ($day != "") {
                if ($day == "M") {
                    $txt = "MON";
                } else if ($day == "T") {
                    $txt = "TUE";
                } else if ($day == "W") {
                    $txt = "TUE";
                } else if ($day == "TH") {
                    $txt = "THU";
                } else if ($day == "F") {
                    $txt = "FRI";
                } else {
                    $txt = "SAT";
                }
                array_push($arr, $txt);
            }
        }
        $output = "";
        $last = count($arr) - 1;

        foreach ($arr as $key => $item) {
            $output .= $item . ", ";
        }
        return rtrim(trim($output), ',');

    }

    public function section()
    {
        return $this->belongsTo(SectionsTbl::class, 'section_id');
    }

    public function subject()
    {
        return $this->belongsTo(SubjectTbl::class, 'subject_id');
    }

    public function room()
    {
        return $this->belongsTo(RoomTbl::class, 'room_id');
    }

    public function instructor()
    {
        return $this->belongsTo(StaffsTbl::class, 'staff_id');
    }

    public function term()
    {
        return $this->belongsTo(TermsTbl::class, 'term_id');
    }

    public function schoolYear()
    {
        return $this->belongsTo(SchoolYearTbl::class, 'school_year_id');
    }


}
