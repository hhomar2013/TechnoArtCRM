<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transfer_request extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function installmentPlan(){
        return $this->belongsTo(installment_plans::class,'installment_plan_id');
    }
}
