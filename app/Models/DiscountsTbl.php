<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountsTbl extends Model
{
    use HasFactory;
    protected $table = "discounts_tbls";
    public $timestamps = false;
}
