<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aspeet extends Model
{
    use HasFactory;
    protected $fillable = [
        "value",
    ];

    public function type(){
        return $this->belongsToMany(Type::class,"typs_aspeets");
    }

    public function element(){
        return $this->hasMany(Element::class);
    }
}
