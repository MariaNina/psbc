<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    use HasFactory;

    protected $fillable = ['announcement_title', 'announcement_body', 'announcement_image', 'branch_id'];

    public function announcementImage()
    {
        $a = $this->announcement_image;

        if (strpos($a, 'https://') !== false) {
            return $this->announcement_image;
        } else {
            return '/storage' . $this->announcement_image;
        }
    }

    public function branch()
    {
        return $this->belongsTo(BranchTbl::class, 'branch_id');
    }
}
