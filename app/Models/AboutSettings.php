<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AboutSettings extends Model
{
    use HasFactory;

    private $folder = '/storage';

    protected $table = 'about_settings';

    protected $fillable = ['page_title',
        'page_subtitle',
        'about_title',
        'about_content',
        'about_additional',
        'about_img',
        'vision',
        'mission'
    ];

    public function aboutImg()
    {
        return is_null($this->about_img) ? '/img/no_image_available.jpg' : $this->folder . $this->about_img;
    }
}
