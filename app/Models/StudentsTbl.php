<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentsTbl extends Model
{
    use HasFactory;
    use \Znck\Eloquent\Traits\BelongsToThrough;

    public $timestamps = false;
    protected $table = "students_tbls";

    protected $guarded = [];

    public function enrollment()
    {
        return $this->hasOne(EnrollmentTbl::class, 'student_id')->select(['id', 'student_id', 'branch_id', 'curriculum_id', 'school_year_id']);
    }

    public function enrollments()
    {
        return $this->hasOne(EnrollmentTbl::class, 'student_id');
    }

    public function latestEnrollment()
    {
        return $this->hasOne(EnrollmentTbl::class, 'student_id')->latestOfMany();
    }

    public function oldestEnrollment()
    {
        return $this->hasOne(EnrollmentTbl::class, 'student_id')->oldestOfMany();
    }

    public function user()
    {
        return $this->belongsTo(UsersTbl::class, 'user_id');
    }

    public function branch()
    {
        return $this->belongsToThrough('App\Models\BranchTbl', 'App\Models\UsersTbl', null, '', ['App\Models\UsersTbl' => 'user_id', 'App\Models\BranchTbl' => 'branch_id']);
    }

    public function guardian()
    {
        return $this->belongsTo(GuardianTbl::class, 'guardian_id');
    }

    public function documents()
    {
        return $this->hasMany(DocumentsTbl::class, 'student_id');
    }

}
