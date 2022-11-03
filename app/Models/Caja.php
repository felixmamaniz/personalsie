<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','monto_base', 'estado', 'sucursal_id'];

    public function carteras()
    {
        //de uno a Muchos
        return $this->hasMany(Cartera::class);
    }
    public function sucursal()
    {
        //de uno a uno
        return $this->belongsTo(Sucursal::class);
    }
}
