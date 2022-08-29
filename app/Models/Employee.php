<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'ci',
        'name',
        'lastname',
        'genero',
        'dateNac',
        'address',
        'phone',
        'dateAdmission',
        'area_trabajo_id'
    ];

    public function area(){
        return $this->belongsTo(AreaTrabajo::class);
    }
}
