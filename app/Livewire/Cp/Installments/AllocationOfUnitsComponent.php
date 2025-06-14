<?php

namespace App\Livewire\Cp\Installments;

use App\Models\Apartments;
use App\Models\Buildings;
use App\Models\Customers;
use App\Models\installment_plans;
use App\Models\payment_plans;
use App\Models\payments;
use App\Models\Project;
use Carbon\Carbon;
use Livewire\Component;

class AllocationOfUnitsComponent extends Component
{
    public $customer, $customer_id, $unit_id, $unit_price, $unit_area, $unit_number, $unit_floor, $unit_type, $unit_status, $unit_availability, $selected_customers = [];
    public $building, $building_id, $appartment;
    public $project, $project_id;
    public $payment_plan ,$total_amount;
    public $start_down_payment_date ,$start_installment_date ,$installmentPlans ,$installment_id ,$customer_payment = [];
    protected $listeners = ['getInstallmentPlans' => 'getInstallmentPlans'];
    public function generate()
    {
        $plan = payment_plans::findOrFail($this->payment_plan);
        $downPayment = ($plan->down_payment_percent / 100) * $this->total_amount;
        $installmentAmount = ($this->total_amount - $downPayment) / $plan->installments_count;
        $installmentPlan = installment_plans::create([
            'customer_id' => $this->customer,
            'payment_plan_id' => $this->payment_plan,
            'total_amount' => $this->total_amount,
            'down_payment_total' => $downPayment,
            'down_payment_parts' => 4,
            'status' => 'pending',
        ]);
        $this->installment_id = $installmentPlan->id;

        // دفعات المقدم
        $downPaymentPart = $downPayment / 4;
        for ($i = 1; $i <= 4; $i++) {
            payments::create([
                'installment_plan_id' => $installmentPlan->id,
                'amount' => $downPaymentPart,
                'due_date' => Carbon::now()->addMonths($i - 1),
                'type' => 'down_payment',
                'status' => 'pending',
            ]);
        }

        // دفعات التقسيط
        for ($i = 1; $i <= $plan->installments_count; $i++) {
            payments::create([
                'installment_plan_id' => $installmentPlan->id,
                'amount' => $installmentAmount,
                'due_date' => Carbon::now()->addMonths($i + 3), // تبدأ بعد المقدم
                'type' => 'installment',
                'status' => 'pending',
            ]);
        }
        $this->dispatch('getInstallmentPlans');
        $this->dispatch('message',message:'تم توليد الدفعات بنجاح ✅');
    }

    public function getInstallmentPlans()
    {

        $this->customer_payment = payments::query()->where('installment_plan_id',$this->installment_id)->get();
    }

    public function updated($property){
        switch ($property) {
            case 'appartment':
                $a = Apartments::query()->find($this->appartment);
                $this->unit_price = $a->total;
                $this->total_amount = $a->total;
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
        $this->customer_id = $customers->code;
        // تأكد أن العميل موجود
        // if (!$customers) {
        //     $this->dispatch('error', message: 'Customer not found');
        //     return;
        // }

        // // تحقق إذا كان العميل موجود بالفعل في الـ array
        // $alreadyExists = collect($this->selected_customers)->contains(function ($item) use ($customers) {
        //     return $item['code'] == $customers->code;
        // });

        // if ($alreadyExists) {
        //     $this->dispatch('error', message: __('Customer already added'));
        //     return;
        // }

        // // لو مش موجود، ضيفه
        // $this->selected_customers[] = [
        //     'code' => $customers->code,
        //     'name' => $customers->name,
        // ];
    }

    public function selectCustomer()
    {
        $customers = Customers::find($this->customer);

        // تأكد أن العميل موجود
        if (!$customers) {
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
            'code' => $customers->code,
            'name' => $customers->name,
        ];
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
            $customers = Customers::query()
                ->where('code', 'like', '%' . $search . '%')
                ->orWhere('name', 'like', '%' . $search . '%')
                ->first();
            if ($customers) {
                $this->customer = $customers->id;
            }
        }
    }


    public function render()
    {
        $customers = Customers::query()->get();
        $buildings =  Buildings::where('project_id', $this->project)->get();
        $projects = Project::query()->get();
        $appartments = Apartments::query()->where('building_id', $this->building_id)->get();
        $payment_plans = payment_plans::query()->get();



        return view(
            'livewire.cp.installments.allocation-of-units-component',
            [
                'customers' => $customers,
                'buildings' => $buildings,
                'projects' => $projects,
                'appartments' => $appartments,
                'payment_plans' => $payment_plans,
            ]
        )->extends('layouts.app');
    }
}
