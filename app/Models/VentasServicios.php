<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentasServicios extends Model
{
    use HasFactory;
    protected $fillable = ['estado','sale_id','service_id'];
}
