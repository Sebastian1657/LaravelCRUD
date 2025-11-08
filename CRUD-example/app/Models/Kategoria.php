<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategoria extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = ['name'];

    /**
     * Relacja: Jedna kategoria ma wiele zadań (todos).
     */
    public function todos()
    {
        return $this->hasMany(Todos::class);
    }
}