<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuardianTbl extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "guardian_tbls";
    protected $fillable = ['first_name', 'middle_name', 'last_name', 'address', 'contact_number'];

    public function student()
    {
        return $this->hasMany(StudentsTbl::class, 'guardian_id', 'id');
    }
}
