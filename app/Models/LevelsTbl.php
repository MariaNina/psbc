<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LevelsTbl extends Model
{
    use HasFactory;
    protected $table = "levels_tbls";
    public $timestamps = false;
    protected $fillable = ['level_code','level_name','student_dept','is_active'];

    public function curriculums(): HasMany
    {
        return $this->hasMany(CurriculumTbl::class, 'level_id', 'id');
    }

    public function sections(): HasMany 
    {
        return $this->hasMany(SectionsTbl::class, 'level_id', 'id');
    }

    public function enrollment(): HasMany 
    {
        return $this->hasMany(EnrollmentTbl::class, 'level_id', 'id');
    }
}
