<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerNotes extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function customer()
    {
        return $this->belongsTo(Customers::class,'customer_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
