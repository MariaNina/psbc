<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CurriculumTbl extends Model
{
    use HasFactory;

    protected $table = "curriculum_tbls";

    protected $fillable = ['curriculum_year', 'curriculum_description', 'student_department', 'program_major_id', 'school_year_id', 'is_active'];

    public $timestamps = false;

    public function curriculumSubjects()
    {
        return $this->hasMany(CurriculumSubjectsTbl::class, 'curriculum_id', 'id');
    }

    public function subjects()
    {
        return $this->belongsToMany(SubjectTbl::class, 'curriculum_subjects_tbls', 'curriculum_id', 'subject_id');
    }

    public function programMajors()
    {
        return $this->belongsTo(ProgramMajorsTbl::class, 'program_major_id');
    }

    public function school_years()
    {
        return $this->belongsTo(SchoolYearTbl::class, 'school_year_id');
    }

    public function levels()
    {
        return $this->belongsTo(LevelsTbl::class, 'level_id');
    }

}
