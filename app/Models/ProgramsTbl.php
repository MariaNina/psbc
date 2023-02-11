<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramsTbl extends Model
{
    use HasFactory;
    protected $table ='programs_tbls';
    protected $fillable =[
        'program_code','program_name','program_description','is_active'
    ];
    public $timestamps =false;
    
    public function programMajors()
    {
        return $this->hasMany(ProgramMajorsTbl::class, 'program_id', 'id');
    }
}
