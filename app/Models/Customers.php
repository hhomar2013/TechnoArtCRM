<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customers extends Model
{
    use HasFactory, SoftDeletes;
    protected $guarded = [];

    public function installmentPlans()
    {
        return $this->hasMany(installment_plans::class);
    }

    public function customers_type()
    {
        return $this->belongsTo(customerTypes::class, 'customer_type');
    }

    public function sales()
    {
        return $this->belongsTo(sales::class, 'sales_id');
    }

    public function installmentCustomers()
    {
        return $this->hasMany(instllmentCustomers::class, 'customersId');
    }

    public function notes()
    {
        return $this->hasMany(CustomerNotes::class,'customer_id', 'id');
    }
}
