<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class instllmentCustomers extends Model
{
    use HasFactory;
    protected $fillable = [
        'customersId',
        'installment_plan_id',
    ];
    public function customer()
    {
        return $this->belongsTo(Customers::class, 'customersId');
    }
    public function installment_plans()
    {
        return $this->belongsTo(installment_plans::class, 'installment_plan_id');
    }




}
