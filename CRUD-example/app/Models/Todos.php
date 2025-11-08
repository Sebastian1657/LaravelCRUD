<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Todos extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nazwa_zadania',
        'categories_id',
        'tresc_zadania',
        'deadline'
    ];
    protected $casts = [
        'completed_at' => 'datetime',
    ];
    public function categories()
    {
        return $this->belongsTo(Kategoria::class);
    }
    public function users(){
        return $this->belongsToMany(Users::class);
    }
}