<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'tag_uuid',
        'tag_name',
        'tag_key',
    ];

    // Một tag có thể gắn cho nhiều note
    public function notes()
    {
        return $this->belongsToMany(Note::class, 'note_tag');
    }
}