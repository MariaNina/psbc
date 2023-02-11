<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentHistoryTbl extends Model
{
    use HasFactory;
    protected $table = "payment_history_tbls";
    public $timestamps = true;

    public function assessment()
    {
        return $this->belongsTo(AssessmentsTbl::class, 'assessments_id');
    }
}
