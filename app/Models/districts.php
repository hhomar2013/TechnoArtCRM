<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class districts extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function governement(){
        return $this->belongsTo(Goverment::class,'gov_id','id');
    }
}
