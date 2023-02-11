<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SubjectTbl extends Model
{
    use HasFactory;

    protected $table = "subject_tbls";
    protected $fillable = [
        "subject_code",
        "subject_name",
        "subject_description",
        "subject_type",
        "subject_image",
        "is_offered",
        "is_for_college",
        "lect_unit",
        "lab_unit",
    ];
    public $timestamps = false;

    public function curriculumSubjects(): HasMany
    {
        return $this->hasMany(CurriculumSubjectsTbl::class, 'subject_id', 'id');
    }

    public function curriculumPreReqSubjects(): HasMany
    {
        return $this->hasMany(CurriculumSubjectsTbl::class, 'prerequisite_subject_id', 'id');
    }

    public function curriculums()
    {
        return $this->belongsToMany(CurriculumTbl::class, 'curriculum_subjects_tbls', 'subject_id', 'curriculum_id');
    }
}
