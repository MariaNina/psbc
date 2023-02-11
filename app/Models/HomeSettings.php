<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSettings extends Model
{
    use HasFactory;

    private $folder = '/storage';

    protected $table = 'home_settings';


    protected $fillable = ['contact_no',
        'email',
        'facebook',
        'logo',
        'carousel_img1',
        'carousel_img2',
        'carousel_img3',
        'carousel_title',
        'carousel_subtitle',
        'carousel_link1',
        'carousel_link2',
        'home_icon_title1',
        'home_icon_subtitle1',
        'home_icon_title2',
        'home_icon_subtitle2',
        'home_icon_title3',
        'home_icon_subtitle3',
        'home_announcement_title',
        'home_announcement_subtitle',
        'home_announcement_link',
        'home_announcement_img_background',
        'home_announcement_img',
        'campus_title',
        'campus_subtitle',
        'offer_title',
        'offer_img',
        'offer_subtitle',
        'offer_list',
        'program_pagetitle',
        'program_contentitle',
        'is_maintenance'
    ];

    public function logo()
    {
        return is_null($this->logo) ? '/img/no_image_available.jpg' : $this->folder . $this->logo;
    }

    public function sliderOne()
    {
        return is_null($this->carousel_img1) ? '/img/no_image_available.jpg' : $this->folder . $this->carousel_img1;
    }

    public function sliderTwo()
    {
        return is_null($this->carousel_img2) ? '/img/no_image_available.jpg' : $this->folder . $this->carousel_img2;
    }

    public function sliderThree()
    {
        return is_null($this->carousel_img3) ? '/img/no_image_available.jpg' : $this->folder . $this->carousel_img3;
    }

    public function announcementBackground()
    {
        return is_null($this->home_announcement_img_background) ? '/img/no_image_available.jpg' : $this->folder . $this->home_announcement_img_background;
    }

    public function announcementImage()
    {
        return is_null($this->home_announcement_img) ? '/img/no_image_available.jpg' : $this->folder . $this->home_announcement_img;
    }

    public function offerImage()
    {
        return is_null($this->offer_img) ? '/img/no_image_available.jpg' : $this->folder . $this->offer_img;
    }

    public function getOffersAttribute()
    {
        $list = explode(",", $this->offer_list);

        $list = array_map(array(__CLASS__, "trimString"), $list);

        return $list;

    }

    public function trimString($value)
    {
        return trim($value);
    }
}
