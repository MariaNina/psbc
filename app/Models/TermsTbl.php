<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TermsTbl extends Model
{
    use HasFactory;

    protected $table = "terms_tbls";
    protected $fillable = ['term_name', 'is_active'];
    public $timestamps = false;

    public function curriculumSubjects(): HasMany
    {
        return $this->hasMany(CurriculumSubjectsTbl::class, 'term_id', 'id');
    }

    public function enrollments()
    {
        return $this->hasMany(EnrollmentTbl::class, 'term_id');
    }

    public function schedules()
    {
        return $this->hasMany(SchedulesTbl::class, 'term_id');
    }
}
