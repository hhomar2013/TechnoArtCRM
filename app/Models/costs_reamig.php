<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class costs_reamig extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function banks()
    {
        return $this->belongsTo(Banks::class, 'bank');
    }
}
