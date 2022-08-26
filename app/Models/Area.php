<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];

    public function employee(){
        return $this->hasMany(Employee::class);
    }

    public function function(){
        return $this->belongsToMany(FunctionArea::class);
    }
}
