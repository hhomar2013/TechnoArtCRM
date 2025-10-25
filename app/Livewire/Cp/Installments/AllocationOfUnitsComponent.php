<?php

namespace App\Livewire\Cp\Installments;

use App\Models\Apartments;
use App\Models\Buildings;
use App\Models\costs;
use App\Models\costs_installments;
use App\Models\Customers;
use App\Models\installment_plans;
use App\Models\instllmentCustomers;
use App\Models\payments;
use App\Models\payment_plans;
use App\Models\phases;
use App\Models\Project;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class AllocationOfUnitsComponent extends Component
{
    use WithPagination;
    protected $paginationTheme                                                                                                                                              = 'bootstrap';
    public $customer, $customer_id, $unit_id, $phase, $unit_price, $unit_area, $unit_number, $unit_floor, $unit_type, $unit_status, $unit_availability, $selected_customers = [];
    public $building, $building_id, $appartment;
    public $project, $project_id;
    public $payment_plan = 1, $total_amount;
    public $start_down_payment_date, $start_installment_date, $installmentPlans,
        $installment_id, $customer_payment = [], $downPayment, $downPaymentParts, $installments_count, $installment_value, $installment_pages = 10, $costs_pages = 10,
        $costs_installments_count, $costs_installments_period, $customer_units;
    public $search_type  = 'code';
    protected $listeners = ['getInstallmentPlans' => 'getInstallmentPlans'];
    public $costs = [];
    public $actionsOptions = [
        'one_payment' => 'دفعه واحده',
        'payments'    => 'مقسمه على دفعات',
    ];
    public function addCost()
    {
        $this->costs[] = [
            'cost_id'                   => '',
            'value'                     => 0,
            'date'                      => 0,
            'actions'                   => '',
            'costs_installments_count'  => '',
            'costs_installments_period' => '',
        ];
    }

    public function hasEmptyDate()
{
    foreach ($this->costs as $cost) {
        if ($cost['date'] == 0) {
            return true; // يوجد صف بدون تاريخ
        }
    }
    return false; // كل التواريخ سليمة
}
    public function deleteAllCosts()
    {
        $this->reset(['costs']);
    }

    public function check_customer_count($customerId)
    {
        $search = DB::table('customers')
            ->select(
                'customers.id',
                'customers.name',
                'instllment_customers.installment_plan_id',
                'installment_plans.project_id',
                'installment_plans.status',
                'projects.name as project_name',
                'phases.name as phase_name',
                'phases.id as phase_id'
            )
            ->join('instllment_customers', 'customers.id', '=', 'instllment_customers.customersId')
            ->join('installment_plans', 'instllment_customers.installment_plan_id', '=', 'installment_plans.id')
            ->join('projects', 'installment_plans.project_id', '=', 'projects.id')
            ->join('phases', 'installment_plans.phase_id', '=', 'phases.id')
            ->where('customers.id', $customerId)
            ->where('installment_plans.status', 'pending')
            ->get();
        return $search;
    }

    public function generateCostPayments($index)
    {
        $this->validate([
            "costs.$index.costs_installments_count"  => 'required|numeric|min:1',
            "costs.$index.costs_installments_period" => 'required|numeric|min:1',
            "costs.$index.value"                     => 'required|numeric|min:0',
            "costs.$index.date"                      => 'required|date',
        ]);
        $costId            = $this->costs[$index]['cost_id'];
        $date              = $this->costs[$index]['date'];
        $value             = $this->costs[$index]['value'];
        $installment_count = $this->costs[$index]['costs_installments_count'];
        $dateCount         = $this->costs[$index]['costs_installments_period'];
        $new_date          = '';
        for ($i = 1; $i <= $installment_count; $i++) {
            // $new_date      = SupportCarbon::parse($date)->addMonths($i * $dateCount)->toDateString();
            $new_date = Carbon::parse($date)->addMonths(($i * $dateCount) - $dateCount)->toDateString();
            $this->costs[] = [
                'cost_id'                   => $costId,
                'value'                     => $value,
                'date'                      => $new_date,
                'actions'                   => 'one_payment',
                'costs_installments_count'  => '',
                'costs_installments_period' => '',
            ];
        }
        $this->removeCosts($index);

    }

    public function generate()
    {
        $this->validate([
            'selected_customers' => 'required',
        ]);

        $installmentPlan = installment_plans::create([
            'customers'          => json_encode($this->selected_customers),
            'payment_plan_id'    => $this->payment_plan,
            'phase_id'           => $this->phase,
            'total_amount'       => 0,
            'down_payment_total' => 0,
            'down_payment_parts' => 0,
            'status'             => 'pending',
            'project_id'         => $this->project,
            'user_id'            => auth()->id(),
        ]);
        $this->installment_id = $installmentPlan->id;

        foreach ($this->selected_customers as $key => $value) {
            instllmentCustomers::create([
                'customersId'         => $value['id'],
                'installment_plan_id' => $installmentPlan->id,
            ]);
        }

        // دفعات التقسيط
        for ($i = 1; $i <= $this->installments_count; $i++) {
            payments::create([
                'installment_plan_id' => $installmentPlan->id,
                'amount'              => $this->installment_value,
                'due_date'            => Carbon::parse($this->start_installment_date)->addMonths($i - 1), // تبدأ بعد المقدم
                'type'                => 'installment',
                'status'              => 'pending',
            ]);
        }

        $this->GenerateCosts($this->installment_id);
        $this->dispatch('getInstallmentPlans');
        $this->dispatch('message', message: 'تم توليد الدفعات بنجاح ✅');
        $this->reset();
    }

    public function getInstallmentPlans()
    {
        $this->resetPage();
        $this->customer_payment = payments::query()->where('installment_plan_id', $this->installment_id)->get();
    }

    public function updated($property)
    {
        switch ($property) {
            case 'appartment':
                $a = Apartments::query()->find($this->appartment);
                // $this->unit_price = $a->total;
                // $this->total_amount = $a->total;
                break;

            case 'installment_pages':
                $this->resetPage();
                break;

            default:
                # code...
                break;
        }
    }

    public function selectProject()
    {
        // $this->building = Buildings::where('project_id', $this->project)->get();
    }

    public function updateCode()
    {
        $customers = Customers::find($this->customer);
        if ($this->customer) {
            $this->customer_id = $customers->code;
        } else {
            $this->customer_id = null;
        }
    }

    public function selectCustomer()
    {
        $customers = Customers::find($this->customer);

        // تأكد أن العميل موجود
        if (! $customers) {
            $this->dispatch('error', message: __('No Results Found.'));
            return;
        }

        // تحقق إذا كان العميل موجود بالفعل في الـ array
        $alreadyExists = collect($this->selected_customers)->contains(function ($item) use ($customers) {
            return $item['code'] == $customers->code;
        });

        if ($alreadyExists) {
            $this->dispatch('error', message: __('Customer already added'));
            return;
        }

        // لو مش موجود، ضيفه
        $this->selected_customers[] = [
            'id'   => $customers->id,
            'code' => $customers->code,
            'name' => $customers->name,
        ];
    }

    public function removeCosts($index)
    {
        unset($this->costs[$index]);
        $this->costs = array_values($this->costs);
    }

    public function removeSelectedCustomer($index)
    {
        unset($this->selected_customers[$index]);
        $this->selected_customers = array_values($this->selected_customers);
    }

    public function searchCustomer()
    {
        if ($this->customer_id != null) {
            $search = $this->customer_id;
            $search = str_replace(' ', '%', $search);
            if (strlen($search) < 1) {
                $this->dispatch('error', message: __('No Results Found.'));
                return;
            }

            if ($this->search_type == 'name') {
                $customers = Customers::query()->where('name', 'like', '%' . $search . '%')->first();
            } elseif ($this->search_type == 'code') {
                $customers = Customers::query()->where('code', '=', $search)->first();
            } elseif ($this->search_type == 'mobile') {
                $customers = Customers::query()->where('mobile', 'like', '%' . $search . '%')->first();
            }

            $customers = Customers::query()->where('code', 'like', '%' . $search . '%')->first();
            if ($customers) {
                $this->customer       = $customers->id;
                $this->customer_units = $this->check_customer_count($this->customer);
            }
        }
    }

    public function GenerateCosts($installment_plan_id)
    {
        // dd($installment_plan_id);
        foreach ($this->costs as $key => $value) {
            costs_installments::query()->create([
                'installment_plan_id' => $installment_plan_id,
                'cost_id'             => $value['cost_id'],
                'date'                => $value['date'],
                'value'               => $value['value'],
            ]);
        }
    }

      public function getHasEmptyDateProperty()
    {
        return collect($this->costs)->contains(fn($cost) => $cost['date'] == 0 || empty($cost['date']));
    }

    public function render()
    {
        $customers     = Customers::query()->get();
        $buildings     = Buildings::where('project_id', $this->project)->get();
        $projects      = Project::query()->get();
        $appartments   = Apartments::query()->where('building_id', $this->building_id)->get();
        $payment_plans = payment_plans::query()->get();
        $costsData     = costs::query()->get();
        $phases        = phases::all();
        return view(
            'livewire.cp.installments.allocation-of-units-component',
            [
                'customers'         => $customers,
                'buildings'         => $buildings,
                'projects'          => $projects,
                'phases'            => $phases,
                'appartments'       => $appartments,
                'payment_plans'     => $payment_plans,
                'customer_payments' => payments::query()->where('installment_plan_id', $this->installment_id)->paginate($this->installment_pages),
                'customer_costs'    => costs_installments::query()
                    ->with('costs')
                    ->where('installment_plan_id', $this->installment_id)->get(),
                'costsData'         => $costsData,
            ]
        )->extends('layouts.app');
    }
}
