<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salarie extends Model
{
    use HasFactory;
    protected $fillable = ['fechaInicio', 'fechaFin', 'descripcion', 'totalPagos', 'salarioMes', 'salarioAño'];
}
