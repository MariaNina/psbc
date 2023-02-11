<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSettings extends Model
{
    use HasFactory;

    protected $fillable = ['staff_id', 'morning_in', 'morning_out', 'afternoon_in', 'afternoon_out', 'days', 'required_time'];

    public function staff()
    {
        return $this->belongsTo(StaffsTbl::class, 'staff_id');
    }
}
