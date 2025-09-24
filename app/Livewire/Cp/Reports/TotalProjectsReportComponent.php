<?php

namespace App\Livewire\Cp\Reports;

use App\Models\costs_installments;
use App\Models\installment_plans;
use App\Models\instllmentCustomers;
use App\Models\payments;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use PhpParser\Node\Expr\Cast\Double;

class TotalProjectsReportComponent extends Component
{
    public $projects, $project_id, $total, $results, $project_name;
    public $total_payment_pending = 0.0, $total_payment_paid = 0.0;
    public $total_cost_pending = 0.0, $total_cost_paid = 0.0;
    public $totalProjects;
    protected $listeners = ['refrechTotalProjects' => '$refrech'];
    public function mount()
    {
        $this->projects =  Project::all();
        // dd($this->getProjectTotal(1));
    }


    public function getCustomerInstallments($installment_id, $customer_id)
    {
        session()->forget(['installmentId', 'customerId']);
        session()->flash('installmentId', $installment_id);
        session()->flash('customerId', $customer_id);
        return redirect()->to('/collection');
    }

    public function getProjects()
    {
        $this->projects = $this->project_name ? Project::query()->where('name', 'like', '%' . $this->project_name . '%')->get() : Project::all();
        if ($this->projects->count() > 0) {
            $this->dispatch('openSelect');
        }
    }

    public function getProjectTotal($project_id)
    {
        $search = '';
        // $search = DB::table('customers')
        //     ->select(
        //         'customers.*',
        //         'instllment_customers.installment_plan_id',
        //         'installment_plans.project_id',
        //         'projects.name as project_name',
        //         'phases.name as phase_name',
        //         'customer_types.name as customer_type_name',
        //         'sales.name as sales_name'
        //     )
        //     ->join('instllment_customers', 'customers.id', '=', 'instllment_customers.customersId')
        //     ->join('installment_plans', 'instllment_customers.installment_plan_id', '=', 'installment_plans.id')
        //     ->join('projects', 'installment_plans.project_id', '=', 'projects.id')
        //     ->join('phases', 'installment_plans.phase_id', '=', 'phases.id')
        //     ->join('customer_types', 'customers.customer_type', '=', 'customer_types.id')
        //     ->join('sales', 'customers.sales_id', '=', 'sales.id')
        //     ->where('projects.id', $project_id)
        //     ->get();
        $search = DB::table('customers')
            ->select(
                'customers.*',
                'instllment_customers.installment_plan_id',
                'installment_plans.project_id',
                'projects.name as project_name',
                'phases.name as phase_name',
                'customer_types.name as customer_type_name',
                'sales.name as sales_name',
                'phases.id as phase_id'
            )
            ->join('instllment_customers', 'customers.id', '=', 'instllment_customers.customersId')
            ->join('installment_plans', 'instllment_customers.installment_plan_id', '=', 'installment_plans.id')
            ->join('projects', 'installment_plans.project_id', '=', 'projects.id')
            ->join('phases', 'installment_plans.phase_id', '=', 'phases.id')
            ->join('customer_types', 'customers.customer_type', '=', 'customer_types.id')
            ->join('sales', 'customers.sales_id', '=', 'sales.id')
            ->where('projects.id', $project_id)
            // ->where('phases.id', $this->phase_id)
            // ->orderBy('customers.id', 'desc') // علشان يجيب أول واحد
            ->get()
            ->unique('installment_plan_id') // هنا بيشيل التكرار ويخلي أول عميل بس
            ->values();

        // dd($search);
        return $search ?? [];
    }
    public function getTolalPayments($project_id)
    {
        $total = DB::table('payments')

            ->select('payments.*', 'installment_plans.project_id')
            ->join('installment_plans', 'payments.installment_plan_id', '=', 'installment_plans.id')
            ->where('installment_plans.project_id', '=', $project_id)
            ->get();
        $this->total_payment_pending = $total->where('status', 'pending')->sum('amount');
        $this->total_payment_paid = $total->where('status', 'paid')->sum('amount');
        return $total ?? [];
    }// getTolalPayments

    public function getTotalCostInstallments($project_id)
    {
        $total = DB::table('costs_installments')
            ->select('costs_installments.*', 'installment_plans.project_id')
            ->join('installment_plans', 'costs_installments.installment_plan_id', '=', 'installment_plans.id')
            ->where('installment_plans.project_id', '=', $project_id)
            ->get();
        $this->total_cost_pending = $total->where('status', 'pending')->sum('value');
        $this->total_cost_paid = $total->where('status', 'paid')->sum('value');
        return $total ?? [];
    }
    public function getResult()
    {
        $this->reset(['results', 'totalProjects', 'total_payment_pending', 'total_payment_paid', 'total_cost_pending', 'total_cost_paid']);
        $installment_plans = installment_plans::query()->where('project_id', $this->project_id)->first();
        $cost_installments = $this->getTotalCostInstallments($this->project_id);
        $payment = $this->getTolalPayments($this->project_id);
        $projectTotal = $this->getProjectTotal($this->project_id);
        if ($installment_plans) {
            $this->results = [
                'cost_installments' => $cost_installments,
                'payments' =>  $payment,
                'customers' => $projectTotal,
            ];
            $this->totalProjects = $projectTotal;
        } else {
            $this->dispatch('error', message: __('No Data'));
            $this->reset(['project_id', 'results', 'total_payment_pending', 'total_payment_paid', 'total_cost_pending', 'total_cost_paid']);
        }
    }

    public function render()
    {

        return view('livewire.cp.reports.total-projects-report-component')->extends('layouts.app');
    }
}
