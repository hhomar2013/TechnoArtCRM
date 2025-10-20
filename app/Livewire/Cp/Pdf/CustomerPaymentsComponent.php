<?php

namespace App\Livewire\Cp\Pdf;

use App\Models\costs_installments;
use App\Models\costs_reamig;
use App\Models\installment_plans;
use App\Models\instllmentCustomers;
use App\Models\payments_reaming;
use App\Models\transfer_request;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;


class CustomerPaymentsComponent extends Component
{

    public $header;
    public $transfer;
    public $costs;
    public $costs_reaming;
    public $payments;
    public $payments_reaming;
    public $total, $total_payment, $total_costs, $remaing_costs, $remaing_payment;
    #[Url]
    public $installmentId;


    public function mount($id)
    {
        // if (session()->has('CustomerPaymentId')) {
        //     // dd(session()->get('CustomerPaymentId'));
        //     $this->installmentId = session()->get('CustomerPaymentId');
        //     $this->showPayments($this->installmenءذtId);
        // }
        $this->installmentId = $id;
        $this->showPayments($this->installmentId);
    }


    public function showPayments($id)
    {
        $this->transfer = transfer_request::where('installment_plan_id', $id)->first();
        $this->header = DB::table('installment_plans')
            ->select('installment_plans.*', 'customers.name as customer_name', 'customers.code as code', 'projects.name as project_name', 'phases.name as phase_name')
            ->join('instllment_customers', 'installment_plans.id', '=', 'instllment_customers.installment_plan_id')
            ->join('projects', 'installment_plans.project_id', '=', 'projects.id')
            ->join('phases', 'installment_plans.phase_id', '=', 'phases.id')
            ->join('customers', 'instllment_customers.customersId', '=', 'customers.id')
            ->where('installment_plans.id', '=', $id)
            ->get();
        // dd($this->header);
        $this->costs = DB::table('costs_installments')
            ->select('costs_installments.*', 'banks.name as banke_name', 'costs.name as cost_name', 'costs_reamigs.remaining')
            ->leftJoin('banks', 'costs_installments.bank', '=', 'banks.id')
            ->leftJoin('costs', 'costs_installments.cost_id', '=', 'costs.id')
            ->leftJoin('costs_reamigs', 'costs_installments.cost_id', '=', 'costs_reamigs.cost_id')
            ->where('costs_installments.installment_plan_id', '=', $id)
            ->get();

        $this->costs_reaming = DB::table('costs_reamigs')
            ->select('costs_reamigs.*', 'banks.name as banke_name')
            ->leftJoin('banks', 'costs_reamigs.bank', '=', 'banks.id')
            ->where('status', 'paid')
            ->get();
        $this->payments_reaming = payments_reaming::query()->get();
        $this->payments = DB::table('payments')
            ->select('payments.*', 'banks.name as bank_name', 'payments_reamings.remaining')
            ->leftJoin('payments_reamings', 'payments.id', '=', 'payments_reamings.payment_id')
            ->leftJoin('banks', 'payments.bank', '=', 'banks.id')
            ->where('payments.installment_plan_id', '=', $id)
            ->get();

        // dd($this->costs_reaming);
    }
    public function render()
    {
        return view('livewire.cp.pdf.customer-payments-component')->extends('layouts.pdf');
    }
}
