<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeductionSettings extends Model
{
    use HasFactory;
    public $timestamps =true;
    protected $table = "deduction_settings";
    protected $fillable = ['deduction_name','amount','encoded_by','is_active','created_at','updated_at'];

    public function deductionList()
    {
        return $this->hasMany(DeductionList::class, 'deduction_id');
    }
}
