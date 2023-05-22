<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    use HasFactory;

    protected $fillable = [
        "code_filiere",
        "name",
        "annee"
    ];
    
    
    public function donnee(){
        return $this->hasMany(Donnee::class);
    }

    public function comment(){
        return $this->hasMany(Comments::class);
    }
    public function group(){
        return $this->hasMany(Group::class);
    }
}
