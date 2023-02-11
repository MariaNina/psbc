<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchCollegesProgramsMajorsTbl extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table ="branch_colleges_programs_majors_tbls";
    protected $fillable =[
        "branch_id",
        "college_id	",
        "program_major_id",
        "is_active"
    ];
}
