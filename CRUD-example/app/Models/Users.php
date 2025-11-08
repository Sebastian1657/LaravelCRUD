<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    protected $table = "users";
    protected $fillable = [
        'nick',
    ];
    public function todos(){
        return $this->belongsToMany(Todos::class);
    }
}
