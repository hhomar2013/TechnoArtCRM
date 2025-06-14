<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class installment_plans extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_id', 'payment_plan_id', 'total_amount', 'down_payment_total',
        'down_payment_parts', 'status',
    ];

    public function customer()
    {
        return $this->belongsTo(Customers::class);
    }

    public function paymentPlan()
    {
        return $this->belongsTo(payment_plans::class);
    }

    public function payments()
    {
        return $this->hasMany(payments::class);
    }
}
