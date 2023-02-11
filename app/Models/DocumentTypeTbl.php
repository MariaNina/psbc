<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentTypeTbl extends Model
{
    use HasFactory;
    protected $table = "document_type_tbls";
    public $timestamps = false;

    public function documents()
    {
        return $this->hasMany(DocumentsTbl::class, 'document_type_id');
    }
}
