<?php


namespace App\Utilities;

use App\Models\SchoolYearTbl;

class Helpers
{
    public static function currentSchoolYear($column)
    {
        $school_year = SchoolYearTbl::where( 'is_active' , 1)->first();
        return $school_year->$column;
    }

    public static function currentTimestamp()
    {
        date_default_timezone_set("Asia/Manila");
        $timestamp = date("Y-m-d H:i:s");
        return $timestamp;
    }
    
}
