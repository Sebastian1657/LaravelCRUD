<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nazwa_zadania',
        'tresc_zadania',
        'kategoria_id',
        'deadline',
    ];
    protected $casts = [
        'completed_at' => 'datetime',
    ];
    public function category()
    {
        return $this->belongsTo(Kategoria::class);
    }
}