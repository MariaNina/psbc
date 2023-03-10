<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageTbl extends Model
{
    use HasFactory;
    public $timestamps =false;
    protected $table = "page_tbls";
    protected $fillable =[
        "page_name",
        "is_active"
    ];

    /**
     * The users that belong to the UsersTbl
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(UsersTbl::class, 'permissions', 'page_id', 'user_id');
    }
}
