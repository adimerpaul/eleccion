<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voto extends Model
{
    use HasFactory;
    protected $fillable= [
        'user_id',
        'tipo',
        'predilecta_id',
        'puntaje',
    ];
    public function predilecta(){
        return $this->belongsTo('App\Models\Predilecta');
    }
    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
