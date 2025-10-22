<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class withdrawal extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function WithdarawalBody()
    {
        return $this->hasMany(withdrawalbody::class, 'withdrawal_id', 'id');
    }
    public function customer()
    {
        return $this->belongsTo(Customers::class, 'customer_id', 'id');
    }
}
