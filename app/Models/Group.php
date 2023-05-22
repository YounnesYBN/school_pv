<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $guarded = [
        "id"
    ];

    public function filiere(){
       return $this->belongsTo(Filiere::class);
    }

    public function user(){
       return $this->belongsToMany(User::class,"user_groups");
    }
}


