<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Predilecta extends Model
{
    use HasFactory;
    protected $fillable= [
        'nombre',
        'conjunto',
        'edad',
        'profesion',
        'ocupacion',
        'estatura',
        'medidas',
        'pasatiempo',
        'color',
        'deporte',
        'foto1',
        'foto2',
        'foto3',
        'nroBano',
        'nroGala',
        'nroFol',
        'nroPre',
    ];
    public function votos(){
        return $this->hasMany('App\Models\Voto')->with('user');
    }
}
