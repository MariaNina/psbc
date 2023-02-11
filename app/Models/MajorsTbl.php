<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Symfony\Component\Console\Helper\Table;

class MajorsTbl extends Model
{
    use HasFactory;
    protected $table = "majors_tbls";
    public $timestamps = false;
    protected $fillable = ['major_code','major_name','major_description','is_active'];

    public function programMajors(): HasMany
    {
        return $this->hasMany(ProgramMajorsTbl::class, 'major_id', 'id');
    }  
}
