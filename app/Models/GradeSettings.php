<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GradeSettings extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "grade_settings";
}
