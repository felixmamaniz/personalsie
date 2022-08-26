<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FunctionArea extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description'];

    public function area(){
        return $this->belongsToMany(Area::class);
    }
}
