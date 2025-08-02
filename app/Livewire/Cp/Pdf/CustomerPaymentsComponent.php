<?php

namespace App\Livewire\Cp\Pdf;

use App\Models\costs_installments;
use App\Models\installment_plans;
use App\Models\instllmentCustomers;
use Illuminate\Support\Facades\DB;
use Livewire\Component;


class CustomerPaymentsComponent extends Component
{
    public $header;
    public $costs;

    public function showPayments()
    {
           $this->header = DB::table('installment_plans')
        ->select('installment_plans.*', 'customers.name as customer_name','customers.code as code','projects.name as project_name','phases.name as phase_name')
        ->join('instllment_customers', 'installment_plans.id', '=', 'instllment_customers.installment_plan_id')
        ->join('projects', 'installment_plans.project_id', '=', 'projects.id')
        ->join('phases', 'installment_plans.phase_id', '=', 'phases.id')
        ->join('customers', 'instllment_customers.customersId', '=', 'customers.id')
        ->where('installment_plans.id','=',1)
        ->first();

        $this->costs = DB::table('costs_installments')
        ->select('costs_installments.*','banks.name as banke_name','costs.name as cost_name')
        ->leftJoin('banks','costs_installments.bank' ,'=','banks.id')
        ->leftJoin('costs','costs_installments.cost_id','=','costs.id')
        ->where('costs_installments.installment_plan_id','=',1)
        ->get();
    }
    public function render()
    {
        $this->showPayments();
        return view('livewire.cp.pdf.customer-payments-component')->extends('layouts.pdf');
    }
}
