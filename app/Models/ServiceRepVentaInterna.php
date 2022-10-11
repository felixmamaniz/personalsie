<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRepVentaInterna extends Model
{
    use HasFactory;
    protected $fillable = ['service_id','product_id','cantidad','precio_venta','lote'];

}
