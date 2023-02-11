<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolYearTbl extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "school_year_tbls";
    protected $fillable = ['school_years'];

    public function curriculums()
    {
        return $this->hasMany(CurriculumTbl::class, 'school_year_id', 'id');
    }

    public function sections()
    {
        return $this->hasMany(SectionsTbl::class, 'school_year_id', 'id');
    }

    public function enrollment()
    {
        return $this->hasMany(EnrollmentTbl::class, 'school_year_id', 'id');
    }

    public function term()
    {
        return $this->hasOneThrough(ProgramsTbl::class, ProgramMajorsTbl::class, 'id', 'id', 'program_major_id', 'program_id');
    }


}
