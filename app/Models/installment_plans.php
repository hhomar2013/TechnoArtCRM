<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class installment_plans extends Model
{
    use HasFactory;
    protected $fillable = [
         'payment_plan_id', 'total_amount', 'down_payment_total',
        'down_payment_parts', 'status', 'customers','project_id','phase_id'
    ];

    protected $casts = [
        'customers' => 'array',
    ];

    // public function customer()
    // {
    //     return $this->belongsTo(Customers::class);
    // }

    public function paymentPlan()
    {
        return $this->belongsTo(payment_plans::class);
    }

    public function payments()
    {
        return $this->hasMany(payments::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class,'project_id');
    }


    public function phases()
    {
        return $this->belongsTo(phases::class, 'phase_id', 'id');
    }
    public function customers(){
        return $this->hasMany(instllmentCustomers::class,'installment_plan_id');
    }
}
