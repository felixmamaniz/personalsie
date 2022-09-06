<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contrato extends Model
{
    use HasFactory;
    protected $fillable = ['fechaInicio', 'fechaFin','descripcion','nota','estado']; /*,'tipo_contrato_id'*/
}
