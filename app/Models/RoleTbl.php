<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleTbl extends Model
{
    use HasFactory;
    public $timestamps =false;
    protected $table = "role_tbls";
    protected $fillable =[
        "role_name",
        "is_active"
    ];
}
