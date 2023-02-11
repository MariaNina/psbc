<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UsersTbl extends Authenticatable
{
    use HasFactory, Notifiable;

    public $timestamps = false;

    protected $table = "users_tbls";

    protected $fillable = [
        "branch_id",
        "full_name",
        "user_name",
        "password",
        "salt",
        "email",
        "role_id",
        "is_active"
    ];

    public static function user()
    {
        $user = UsersTbl::findOrFail(session('user')->id);

        return $user;
    }

    public function branch()
    {
        return $this->belongsTo(BranchTbl::class, 'branch_id');
    }

    public function role()
    {
        return $this->belongsTo(RoleTbl::class);
    }

    /**
     * The pages that belong to the UsersTbl
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pages()
    {
        return $this->belongsToMany(PageTbl::class, 'permissions', 'user_id', 'page_id');
    }

    /**
     * The pages that belong to the UsersTbl
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function active_pages()
    {
        return $this->pages()->where('is_active', 1);
    }

    public function staff()
    {
        return $this->hasOne(StaffsTbl::class, 'user_id');
    }

    public function student()
    {
        return $this->hasOne(StudentsTbl::class, 'user_id');
    }
}
