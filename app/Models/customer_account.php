<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer_account extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function customers()
    {
        return $this->belongsTo(Customers::class, 'customer_id');
    }
}
