<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollegesTbl extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "colleges_tbls";
    protected $fillable = [
        'college_code',
        'college_name',
        'college_description',
        'is_active'
    ];
}
