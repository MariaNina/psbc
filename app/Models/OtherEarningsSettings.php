<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherEarningsSettings extends Model
{
    use HasFactory;
    public $timestamps =true;

    public function otherEarningList()
    {
        return $this->hasMany(otherEarningList::class, 'earnings_id');
    }
}
