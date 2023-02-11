<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnrollmentTbl extends Model
{
    use HasFactory;
    use \Znck\Eloquent\Traits\BelongsToThrough;


    public $timestamps = false;
    protected $table = "enrollment_tbls";

//    protected $fillable = [
//        'student_id',
//    ];

protected $guarded = [];


    public function student()
    {
        return $this->belongsTo(StudentsTbl::class, 'student_id');
    }

    public function curriculum()
    {
        return $this->belongsTo(CurriculumTbl::class, 'curriculum_id')->select(['id', 'program_major_id']);
    }

    public function branch()
    {
        return $this->belongsTo(BranchTbl::class, 'branch_id');
    }

    public function school_year()
    {
        return $this->belongsTo(SchoolYearTbl::class, 'school_year_id');
    }

    public function term()
    {
        return $this->belongsTo(TermsTbl::class, 'term_id');
    }

    public function level()
    {
        return $this->belongsTo(LevelsTbl::class, 'level_id');
    }

    public function section()
    {
        return $this->belongsTo(SectionsTbl::class, 'section_id');
    }

    public function program_majors()
    {
        return $this->belongsToThrough('App\Models\ProgramsTbl', ['App\Models\ProgramMajorsTbl', 'App\Models\CurriculumTbl'], null, '',
            ['App\Models\ProgramMajorsTbl' => 'program_major_id',
                'App\Models\CurriculumTbl' => 'curriculum_id',
                'App\Models\ProgramsTbl' => 'program_id'
            ]);
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'enrollment_id');
    }


}
