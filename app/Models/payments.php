<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payments extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'installment_plan_id', 'amount', 'due_date', 'paid_at', 'type', 'status',
    // ];
    protected $guarded =[];
    public function installmentPlan()
    {
        return $this->belongsTo(installment_plans::class);
    }

    public function transactions()
    {
        return $this->hasMany(payment_transactions::class);
    }


    public function reamings()
    {
        return $this->hasMany(payments_reaming::class, 'payment_id');
    }

}
