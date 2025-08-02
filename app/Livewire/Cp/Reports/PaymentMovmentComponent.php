<?php

namespace App\Livewire\Cp\Reports;

use App\Models\boxs;
use Livewire\Component;

class PaymentMovmentComponent extends Component
{
    public $start_date,$end_date ,$boxs =[] ,$total;


    public function getBox(){
        $this->validate([
            'start_date' => 'required',
            'end_date' => 'required',
        ]);
          $this->boxs = boxs::query()->whereBetween('date', [
            $this->start_date,
            $this->end_date
        ])->get();
    }
    public function render()
    {
        return view('livewire.cp.reports.payment-movment-component')->extends('layouts.app');
    }
}
