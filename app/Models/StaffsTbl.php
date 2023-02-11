<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StaffsTbl extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = "staffs_tbls";

    protected $fillable = [
        'csc_id',
        'first_name',
        'middle_name',
        'last_name',
        'extension_name',
        'staff_type',
        'position',
        'Department',
        'major_in',
        'licence_number',
        'is_masteral',
        'birth_day',
        'birth_place',
        'gender',
        'civil_status',
        'height_m',
        'weight_kg',
        'blood_type',
        'gsis',
        'pagibig',
        'sss',
        'tin',
        'phil_health',
        'agency_employee_no',
        'citizenship',
        'address',
        'zip_code',
        'telephone_number',
        'mobile_number',
        'image'
    ];

    public function sections()
    {
        return $this->hasMany(SectionsTbl::class, 'adviser_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(UsersTbl::class);
    }

    public function staffRole()
    {
        return $this->hasOneThrough(RoleTbl::class, UsersTbl::class, 'id', 'id');
    }
    
    public function deductions()
    {
        return $this->hasMany(DeductionList::class, 'staff_id');
    }
}
