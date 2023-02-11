<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollegeAttendanceHistory extends Model
{
    protected $table = 'college_attendance_histories';
    use HasFactory;
    protected $fillable = [
        'staff_id',
        'cutoff_id',
        'attendance_date',
        'hours',
        'rate'
    ];
}
