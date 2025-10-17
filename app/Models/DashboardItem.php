<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'dashboard_id',
        'note_id',
        'x',
        'y',
        'w',
        'h',
        'order_index',
    ];

    public function dashboard()
    {
        return $this->belongsTo(Dashboard::class);
    }

    public function note()
    {
        return $this->belongsTo(Note::class);
    }
}
