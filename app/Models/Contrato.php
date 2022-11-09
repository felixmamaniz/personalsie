<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;
    protected $fillable = [
        'employee_id',
        'fechaInicio',
        'fechaFin',
        'descripcion',
        /*'nota',*/
        'salario',
        //'funcion_id',
        'estado'
    ];
}
