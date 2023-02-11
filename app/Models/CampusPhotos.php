<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampusPhotos extends Model
{
    use HasFactory;

    protected $table = 'campus_photos';

    protected $fillable = ['file'];
}
