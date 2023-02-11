<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentsTbl extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function student()
    {
        return $this->belongsTo(StudentsTbl::class, 'student_id');
    }

    public function enrollment()
    {
        return $this->belongsTo(EnrollmentTbl::class, 'enrollment_id');
    }

    public function payment_history()
    {
        return $this->hasMany(PaymentHistoryTbl::class, 'assessments_id');
    }
}
