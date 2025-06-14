<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment_transactions extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_id', 'payment_method_id', 'amount', 'paid_at', 'note',
    ];

    public function payment()
    {
        return $this->belongsTo(payments::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(payment_methods::class);
    }
}
