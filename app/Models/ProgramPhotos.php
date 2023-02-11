<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramPhotos extends Model
{
    use HasFactory;

    protected $table = 'program_photos';

    protected $fillable = ['name', 'file', 'description'];
}
