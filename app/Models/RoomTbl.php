<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomTbl extends Model
{
    use HasFactory;
    protected $table ='room_tbls';
    protected $fillable =[
        'room_no','branch_id','room_description','is_active'
    ];
    public $timestamps =false;
}
