<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherEarningList extends Model
{
    use HasFactory;
    public $timestamps =true;

    public function staffs()
    {
        return $this->belongsTo(StaffsTbl::class, 'staff_id');
    }
    
    public function other_earnings()
    {
        return $this->belongsTo(OtherEarningsSettings::class, 'earnings_id');
    }
}
