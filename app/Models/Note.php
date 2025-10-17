<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'note_title',
        'note_text',
        'note_code',
        'note_type',
        'note_image_path',
        'keywords',
    ];

    protected $casts = [
        'note_code' => 'array', // 👈 
    ];


    // Một note có thể có nhiều tag
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'note_tag');
    }

    // Một note có thể có nhiều file upload
    public function files()
    {
        return $this->hasMany(FileUpload::class);
    }
}
