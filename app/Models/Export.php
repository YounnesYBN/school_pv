<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Export extends Model
{
    use HasFactory;
    protected $guarded = [
        "export_id",
    ];



    public function data_export(){
       return  $this->hasMany(DataExport::class);
    }
}
