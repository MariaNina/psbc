<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidaysSettings extends Model
{
    use HasFactory;
    protected $table = "holidays_settings";
    protected $fillable = ['holiday_name','holiday_date','encoded_by','is_active','created_at','updated_at'];
    public $timestamps =true;


}
