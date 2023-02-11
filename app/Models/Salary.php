<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;
    public $timestamps =true;
    protected $table = "salaries";
    protected $fillable = [
        'staff_id',
        'salary_amount'
        ,'salary_classification'
        ,'employment_status'
        ,'is_active',
        'encoded_by',
        'created_at',
        'updated_at',
    ];
    

}
