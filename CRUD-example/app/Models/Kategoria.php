<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategoria extends Model
{
    use HasFactory;
    protected $table = 'categories';

    // Pozwól na masowe dodawanie nazw  y
    protected $fillable = ['name'];

    /**
     * Relacja: Jedna kategoria ma wiele zadań (todos).
     */
    public function todos()
    {
        return $this->hasMany(Todo::class);
    }
}