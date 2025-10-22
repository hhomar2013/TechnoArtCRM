<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class withdrawalbody extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function withdrawal()
    {
        return $this->belongsTo(withdrawal::class);
    }
}
