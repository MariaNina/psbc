<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CurriculumSubjectsTbl extends Model
{
    use HasFactory;

    protected $table = "curriculum_subjects_tbls";

    public $timestamps = false;

    public function curriculums()
    {
        return $this->belongsTo(CurriculumTbl::class, 'curriculum_id');
    }

    public function terms()
    {
        return $this->belongsTo(TermsTbl::class, 'term_id');
    }

    public function subjects()
    {
        return $this->belongsTo(SubjectTbl::class, 'subject_id');
    }
    public function prereq_subjects()
    {
        return $this->belongsTo(SubjectTbl::class, 'prerequisite_subject_id');
    }
}
