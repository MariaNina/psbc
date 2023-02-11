<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchTbl extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "branch_tbls";
    protected $fillable = [
        'branch_name',
        'branch_address',
        'description',
        'email',
        'contact_number',
    ];
}
