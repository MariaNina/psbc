<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentsTbl extends Model
{
    use HasFactory;
    protected $table = "documents_tbls";

    public function student()
    {
        return $this->belongsTo(StudentsTbl::class, 'student_id');
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentTypeTbl::class, 'document_type_id');
    }
}
