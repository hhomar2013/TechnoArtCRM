<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartments extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function buildings()
    {
        return $this->belongsTo(Buildings::class);
    }
}
