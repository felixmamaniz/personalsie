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
        'address',
        'phone',
        'dateAdmission',
        'area_id'
    ];

    public function area(){
        return $this->belongsTo(Area::class);
    }
}
