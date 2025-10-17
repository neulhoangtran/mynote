<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        'file_name',
        'file_path',
        'mime_type',
        'note_id',
    ];

    // Mỗi file thuộc về 1 note
    public function note()
    {
        return $this->belongsTo(Note::class);
    }
}