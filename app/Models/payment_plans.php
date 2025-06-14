<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class payment_plans extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'years', 'installments_count', 'down_payment_percent', 'description',
    ];

    public function installmentPlans()
    {
        return $this->hasMany(installment_plans::class);
    }
}
