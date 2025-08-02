<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class costs extends Model
{
    use HasFactory;

    protected $guarded = [];


    /**
     * Get the banks that owns the costs
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function banks()
    {
        return $this->belongsTo(Banks::class, 'bank');
    }
}
