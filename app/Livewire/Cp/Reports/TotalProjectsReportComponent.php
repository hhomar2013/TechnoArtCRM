<?php
namespace App\Livewire\Cp\Reports;

use App\Models\installment_plans;
use App\Models\phases;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class TotalProjectsReportComponent extends Component
{
    public $projects, $project_id, $total, $results, $project_name;
    public $total_payment_pending = 0.0, $total_payment_paid = 0.0;
    public $total_cost_pending    = 0.0, $total_cost_paid    = 0.0;
    public $totalProjects, $phases, $phases_id;
    protected $listeners = ['refrechTotalProjects' => '$refrech'];
    public function mount()
    {
        $this->projects = Project::all();
        $this->phases   = phases::all();
        // dd($this->getProjectTotal(1));
    }

    public function clearAll()
    {
        $this->reset(['project_id', 'results', 'total_payment_pending', 'total_payment_paid', 'total_cost_pending', 'total_cost_paid', 'phases_id', 'project_name']);
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
        //         'sales.name as sales_name',
        //         'phases.id as phase_id'
        //     )
        //     ->join('instllment_customers', 'customers.id', '=', 'instllment_customers.customersId')
        //     ->join('installment_plans', 'instllment_customers.installment_plan_id', '=', 'installment_plans.id')
        //     ->join('projects', 'installment_plans.project_id', '=', 'projects.id')
        //     ->join('phases', 'installment_plans.phase_id', '=', 'phases.id')
        //     ->join('customer_types', 'customers.customer_type', '=', 'customer_types.id')
        //     ->join('sales', 'customers.sales_id', '=', 'sales.id')
        //     ->when($project_id, function ($query, $project_id) {
        //         $query->where('projects.id', $project_id);
        //     })
        //     ->when($this->phases_id, function ($query, $phase_id) {
        //         $query->where('phases.id', $phase_id);
        //     })
        //     ->get()
        //     ->unique('installment_plan_id')
        //     ->values();

        // dd($search);

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
            ->when($project_id, fn($q, $project_id) => $q->where('projects.id', $project_id))
            ->when($this->phases_id, fn($q, $phase_id) => $q->where('phases.id', $phase_id))
            ->get()
            ->unique('installment_plan_id')
            ->values()
            ->map(function ($item) {

                $item->total_payments = DB::table('payments')
                    ->where('installment_plan_id', $item->installment_plan_id)
                    ->sum('amount');

                $item->monthly_payment = DB::table('payments')
                    ->where('installment_plan_id', $item->installment_plan_id)
                    ->orderBy('id', 'asc')
                    ->value('amount');

                // إجمالي المقدم والدفع (من costs_installments)
                $item->total_costs = DB::table('costs_installments')
                    ->where('installment_plan_id', $item->installment_plan_id)
                    ->sum('value');

                // الإجمالي الكلي = الأقساط + المقدم والدفع
                $item->grand_total = $item->total_payments + $item->total_costs;

                return $item;
            });

        // $this->results       = true;
        // $this->totalProjects = $totalProjects;

        return $search ?? [];
    }

    public function getTolalPayments($project_id)
    {
        $total = DB::table('payments')
            ->select('payments.*', 'installment_plans.*')
            ->join('installment_plans', 'payments.installment_plan_id', '=', 'installment_plans.id')
            ->when($project_id, function ($query, $project_id) {
                $query->where('installment_plans.project_id', $project_id);
            })
            ->when($this->phases_id, function ($query, $phase_id) {
                $query->where('installment_plans.phase_id', $phase_id);
            })
            ->get();
        // dd($total->sum('amount'));
        $this->total_payment_pending = $total->sum('amount');
        $this->total_payment_paid    = $total->where('status', 'paid')->sum('amount');
        return $total ?? [];
    } // getTolalPayments

    public function getTotalCostInstallments($project_id)
    {
        $total = DB::table('costs_installments')
            ->select('costs_installments.*', 'installment_plans.*')
            ->join('installment_plans', 'costs_installments.installment_plan_id', '=', 'installment_plans.id')
            ->when($project_id, function ($query, $project_id) {
                $query->where('installment_plans.project_id', $project_id);
            })
            ->when($this->phases_id, function ($query, $phase_id) {
                $query->where('installment_plans.phase_id', $phase_id);
            })
            ->get();
        $this->total_cost_pending = $total->sum('value');
        $this->total_cost_paid    = $total->where('status', 'paid')->sum('value');
        return $total ?? [];
    }
    public function getResult()
    {
        $this->reset(['results', 'totalProjects', 'total_payment_pending', 'total_payment_paid', 'total_cost_pending', 'total_cost_paid']);
        $installment_plans = installment_plans::query()->where('project_id', $this->project_id)->first();
        $cost_installments = $this->getTotalCostInstallments($this->project_id);
        $payment           = $this->getTolalPayments($this->project_id);
        $projectTotal      = $this->getProjectTotal($this->project_id);
        if ($installment_plans) {
            $this->results = [
                'cost_installments' => $cost_installments,
                'payments'          => $payment,
                'customers'         => $projectTotal,
            ];
            $this->totalProjects = $projectTotal;
        } else {
            $this->dispatch('error', message: __('No Data'));
            $this->reset(['project_id', 'results', 'total_payment_pending', 'total_payment_paid', 'total_cost_pending', 'total_cost_paid']);
        }
    }

    public function previewReport()
    {
        $this->getResult();
        Session::put('totalProjects', $this->totalProjects);
        Session::put('total_payment_pending', $this->total_payment_pending);
        Session::put('total_cost_pending', $this->total_cost_pending);
        Session::put('total_cost_paid', $this->total_cost_paid);
        Session::put('total_payment_paid', $this->total_payment_paid);
        return redirect()->route('pdf.total-projects-report');
    }

    public function render()
    {

        return view('livewire.cp.reports.total-projects-report-component')->extends('layouts.app');
    }
}
