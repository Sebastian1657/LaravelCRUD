<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todo extends Model
{
    use HasFactory, SoftDeletes; // <-- DODAJ SoftDeletes

    /**
     * Pola, które można masowo wypełniać.
     */
    protected $fillable = [
        'nazwa_zadania',
        'tresc_zadania',
        'deadline',
    ];
    protected $casts = [
        'completed_at' => 'datetime',
    ];
}