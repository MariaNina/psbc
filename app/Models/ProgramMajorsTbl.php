<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramMajorsTbl extends Model
{
    use HasFactory;

    protected $table = 'program_majors_tbls';
    protected $fillable = [
        'program_id', 'major_id', 'description', 'is_active'
    ];
    public $timestamps = false;

    public function curriculumSubjects(): HasMany
    {
        return $this->hasMany(CurriculumTbl::class, 'program_major_id', 'id');
    }

    public function programs()
    {
        return $this->belongsTo(ProgramsTbl::class, 'program_id');
    }

    // For Dashboard
    public function program()
    {
        return $this->belongsTo(ProgramsTbl::class, 'program_id')->select(['id', 'program_code']);
    }

    public function majors()
    {
        return $this->belongsTo(MajorsTbl::class, 'major_id');
    }

}
