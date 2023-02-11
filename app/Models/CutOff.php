<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CutOff extends Model
{
    use HasFactory;
    public $timestamps =true;
    protected $table = "cut_offs";
    protected $fillable = ['start_date','end_date','pay_day','encoded_by','is_active'];

}
