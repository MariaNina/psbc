<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowGrades extends Model
{
    use HasFactory;

    protected $table = 'show_grades_settings';
    public $timestamps = false;

    protected $fillable = ['show_deped_grade', 'show_ched_grade'];
}
