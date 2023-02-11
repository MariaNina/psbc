<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SectionsTbl extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "sections_tbls";
    protected $fillable = [
        "section_label",
        "branch_id",
        "adviser_id ",
        "school_year_id",
        "level_id",
        "is_active"
    ];

    public function school_years()
    {
        return $this->belongsTo(SchoolYearTbl::class, 'school_year_id');
    }

    public function advisers()
    {
        return $this->belongsTo(StaffsTbl::class, 'adviser_id');
    }

    public function levels()
    {
        return $this->belongsTo(LevelsTbl::class, 'level_id');
    }

    public function schedules()
    {
        return $this->hasMany(SchedulesTbl::class, 'section_id');
    }

}
