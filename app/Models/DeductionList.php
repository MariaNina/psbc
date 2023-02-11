<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeductionList extends Model
{
    use HasFactory;
    public $timestamps =true;

    public function staffs()
    {
        return $this->belongsTo(StaffsTbl::class, 'staff_id');
    }
    public function deductions()
    {
        return $this->belongsTo(DeductionSettings::class, 'deduction_id');
    }
}
