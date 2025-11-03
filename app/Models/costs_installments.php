<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class costs_installments extends Model
{
    use HasFactory;
    protected $guarded = [];


    public function costs()
    {
        return $this->belongsTo(costs::class, 'cost_id');
    }

       public function reamings()
    {
        return $this->belongsTo(costs_reamig::class, 'cost_id');
    }

    public function installmentPlan()
    {
        return $this->belongsTo(installment_plans::class, 'installment_plan_id');
    }

}
