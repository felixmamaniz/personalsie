<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cargo extends Model
{
    use HasFactory;
    protected $fillable = ['name','area_id','estado'];

    public function employee(){
        return $this->hasMany(Employee::class);
    }

    public function area(){
        return $this->belongsTo(Area::class);
    }
}
