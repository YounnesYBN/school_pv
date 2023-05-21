<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;
    protected $table = "types";
    protected $fillable = [
        "type_name"
    ];
    public function aspeet()
    {
        return $this->belongsToMany(Aspeet::class,"typs_aspeets");
    }

    public function user(){
        return $this->hasMany(User::class);
    }
}
