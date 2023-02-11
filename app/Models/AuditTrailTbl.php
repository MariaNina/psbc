<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditTrailTbl extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "audit_trail_tbls";
    protected $fillable = ['module','description','action_taken','user_id','datetime'];
}
