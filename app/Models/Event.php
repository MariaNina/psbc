<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['title',
        'body', 'link', 'image', 'upcoming_at', 'branch_id'];

    public function eventImage()
    {
        $a = $this->image;

        if (strpos($a, 'https://') !== false) {
            return $this->image;
        } else {
            return '/storage' . $this->image;
        }
    }

    public function getDayAttribute()
    {
        $date = Carbon::parse($this->upcoming_at);
        $formattedDate = $date->isoFormat('MMM D YYYY');
        $day = explode(" ", $formattedDate);
        return $day[1];
    }

    public function getMonthAttribute()
    {
        $date = Carbon::parse($this->upcoming_at);
        $formattedDate = $date->isoFormat('MMM D YYYY');
        $day = explode(" ", $formattedDate);
        return $day[0];
    }

    public function getYearAttribute()
    {
        $date = Carbon::parse($this->upcoming_at);
        $formattedDate = $date->isoFormat('MMM D YYYY');
        $day = explode(" ", $formattedDate);
        return $day[2];
    }

    public function branch()
    {
        return $this->belongsTo(BranchTbl::class, 'branch_id');
    }
}
