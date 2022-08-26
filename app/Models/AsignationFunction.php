<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignationFunction extends Model
{
    use HasFactory;
    protected $fillable = ['function_id','area_id'];

    /*public function funcion(){
        return $this->hasMany(FunctionArea::class);
    }

    public function area(){
        return $this->hasMany(Area::class);
    }*/
}
