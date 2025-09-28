<?php

namespace App\Livewire\Cp\Installments;

use App\Models\Banks;
use App\Models\costs;
use App\Models\costs_installments;
use App\Models\CustomerNotes;
use App\Models\Customers;
use App\Models\customerTypes;
use App\Models\installment_plans;
use App\Models\instllmentCustomers;
use App\Models\payments;
use Livewire\Component;

class ReservationsComponent extends Component
{
    public $searchType       = 'code';
    public $search           = '';
    public $results          = [];
    public $tabs             = "home";
    public $reservation_Info = [];
    public $reservationId;
    public $newCustomer  = false;
    public $addedCustomer;
    public $isWithdrawal = false;
    public $isEditCostsInstallment = false;
    public $selectedCustomerType;
    public $selectedCustomer;
    public $status;
    public $costId;
    public $installmetnId;
    public $costs = [];
    public $costsShow = [];
    public $installments = [];
    public $installmentsShow = [];
    public $time, $transaction_date, $transaction_id, $bank, $amount, $costType;
    public $addCostsInstallments = false;

    protected $listeners = ['refreshReservations' => '$refresh', 'deleteReservation' => 'delete', 'delteCost' => 'delteCost', 'delteInstallment' => 'delteInstallment'];


    public function saveInstallment()
    {

        $this->validate([
            'amount' => 'required',
            'transaction_date' => 'required',
        ]);

        $installment = payments::query()->create([
            'amount' => $this->amount,
            'due_date' => $this->transaction_date,
            'installment_plan_id' => $this->reservationId,
            'type' => 'installment',
            'status' => 'pending'
        ]);
        if ($installment) {
            $this->dispatch('message', message: __('Done Save'));
            $this->reset(['transaction_date', 'amount', 'addCostsInstallments']);
            $this->dispatch("refreshReservations");
            $this->searchCustomer();
            $this->reservationInfo($this->reservationId);
            $this->changeTabs('costs_installments');
        } else {
            $this->dispatch('error', message: __('t.Error_message'));
        }
    }

    public function saveCosts()
    {
        $this->validate([
            'amount' => 'required',
            'transaction_date' => 'required',
            'costType' => 'required'
        ]);

        $costs = costs_installments::query()->create([
            'cost_id' => $this->costType,
            'value' => $this->amount,
            'date' => $this->transaction_date,
            'installment_plan_id' => $this->reservationId
        ]);
        if ($costs) {
            $this->dispatch('message', message: __('Done Save'));
            $this->reset(['transaction_date', 'amount', 'costType', 'addCostsInstallments']);
            $this->dispatch("refreshReservations");
            $this->searchCustomer();
            $this->reservationInfo($this->reservationId);
            $this->changeTabs('costs_installments');
        } else {
            dd('error');
            $this->dispatch('error', message: __('t.Error_message'));
        }
    }

    public function addInstallment()
    {
        $this->addCostsInstallments = 'installment';
    }


    public function addCost()
    {
        $this->addCostsInstallments = 'costs';
    }


    public function backToCostsInstallment()
    {
        $this->addCostsInstallments = false;
        $this->isEditCostsInstallment = false;
        $this->status = false;
        $this->reset(['bank', 'transaction_id', 'transaction_date', 'time', 'amount']);
        $this->changeTabs('costs_installments');
    }
    public function editInstallment($status, $installmetnId)
    {
        $this->isEditCostsInstallment = 'installmentss';
        $this->status = $status;
        $this->installmetnId = $installmetnId;
        $installments = payments::query()->find($installmetnId);
        $this->amount = $installments->amount;
        $this->installmentsShow = $installments;
        $this->transaction_id = $installments->transaction_id;
        $this->transaction_date = $installments->transaction_date;
        $this->time = $installments->paid_at;
        $this->bank = $installments->bank;
    } //editCost

    public function updateInstallmentReceipt()
    {
        $this->validate([
            'bank' => 'required',
            'transaction_id' => 'required',
            'transaction_date' => 'required',
            'time' => 'required'
        ]);
        $installment = payments::query()->find($this->installmetnId);
        if ($installment) {
            $installment->update([
                'bank' => $this->bank,
                'paid_at' => $this->time,
                'transaction_id' => $this->transaction_id,
                'transaction_date' => $this->transaction_date,
            ]);
            $this->dispatch('message', message: __('Done Update'));
            $this->isEditCostsInstallment = false;
            $this->status = false;
            $this->reset(['bank', 'transaction_id', 'transaction_date', 'time', 'amount']);
        }
    } //updateInstallmentReceipt

    public function updateInstallmentValue()
    {
        $this->validate([
            'amount' => 'required',
        ]);
        $installment = payments::query()->find($this->installmetnId);
        if ($installment) {
            $installment->update([
                'amount' => $this->amount,
            ]);
            $this->dispatch('message', message: __('Done Update'));
            $this->isEditCostsInstallment = false;
            $this->status = false;
            $this->searchCustomer();
            $this->reservationInfo($this->reservationId);
            $this->changeTabs('costs_installments');
            $this->reset(['amount']);
        }
    } //updateInstallmentValue

    public function delteInstallment($id)
    {
        $delete = payments::query()->find($id);
        if ($delete) {
            $delete->delete();
            $this->dispatch('message', message: __('Done Delete'));
            $this->searchCustomer();
            $this->reservationInfo($this->reservationId);
            $this->changeTabs('costs_installments');
        }
    } //Delete Costs


    public function editCost($status, $costId)
    {
        $this->isEditCostsInstallment = 'costs';
        $this->status = $status;
        $this->costId = $costId;
        $costs = costs_installments::query()->find($costId);
        $this->amount = $costs->value;
        $this->costsShow = $costs;
        $this->transaction_id = $costs->transaction_id;
        $this->transaction_date = $costs->date;
        $this->time = $costs->time;
        $this->bank = $costs->bank;
    } //editCost

    public function updateCostReceipt()
    {
        $this->validate([
            'bank' => 'required',
            'transaction_id' => 'required',
            'transaction_date' => 'required',
            'time' => 'required'
        ]);
        $cost = costs_installments::query()->find($this->costId);
        if ($cost) {
            $cost->update([
                'bank' => $this->bank,
                'time' => $this->time,
                'transaction_id' => $this->transaction_id,
                'date' => $this->transaction_date,
            ]);
            $this->dispatch('message', message: __('Done Update'));
            $this->isEditCostsInstallment = false;
            $this->status = false;
            $this->reset(['bank', 'transaction_id', 'transaction_date', 'time', 'amount']);
        }
    } //updateCostReceipt

    public function updateCostValue()
    {
        $this->validate([
            'amount' => 'required',
        ]);
        $costs = costs_installments::query()->find($this->costId);
        if ($costs) {
            $costs->update([
                'value' => $this->amount,
            ]);
            $this->dispatch('message', message: __('Done Update'));
            $this->isEditCostsInstallment = false;
            $this->status = false;
            $this->searchCustomer();
            $this->reservationInfo($this->reservationId);
            $this->changeTabs('costs_installments');
            $this->reset(['amount']);
        }
    } //updateCostValue

    public function delteCost($id)
    {
        $delete = costs_installments::query()->find($id);
        if ($delete) {
            $delete->delete();
            $this->dispatch('message', message: __('Done Delete'));
            $this->searchCustomer();
            $this->reservationInfo($this->reservationId);
            $this->changeTabs('costs_installments');
        }
    } //Delete Costs

    public function changeTabs($tab)
    {
        $this->tabs = $tab;
    }


    public function WithDrawal($id)
    {
        $this->isWithdrawal = true;
        $this->selectedCustomer = $id;
    }

    public function saveWithdrawal()
    {
        $customer  = Customers::query()->find($this->selectedCustomer);
        if ($customer) {
            $customer->update([
                'customer_type' => $this->selectedCustomerType
            ]);

            $installmentCustomer = instllmentCustomers::query()->where('customersId', '=', $customer->id)->first();
            $selectedWithdrawelinstallment  = $installmentCustomer->installment_plan_id;
            $installmentCustomer->delete();
            if ($installmentCustomer) {
                $note = CustomerNotes::query()->create([
                    'note' => " : تم سحب العميل" . ' ' . $customer->name . ' ' . " من أستمارة " . ' #' . $selectedWithdrawelinstallment . ' ',
                    'customer_id' => $customer->id,
                    'user_id' => auth()->user()->id,
                ]);
                if ($note) {
                    $this->dispatch('refreshReservations');
                    $this->searchCustomer();
                    $this->dispatch('message', message: __('Withdrawal saved successfully.') . ' للعميل : ' . $customer->name);
                    $this->isWithdrawal = false;
                    $this->reset(['selectedCustomer', 'selectedCustomerType']);
                }
            }
        }
    }

    public function addNewCustomer($id)
    {
        $add_new_customer = instllmentCustomers::query()->create([
            'customersId' => $this->addedCustomer,
            'installment_plan_id' => $id,
        ]);
        if ($add_new_customer) {
            $this->dispatch('refreshReservations');
            $this->searchCustomer();
            $this->changeTabs('home');
            $this->newCustomer = false;
        }
    }


    public function searchCustomer()
    {
        $this->reset(['results', 'reservation_Info']);
        $this->changeTabs('home');
        if (strlen($this->search) < 1) {
            $this->dispatch('error', message: __('No Results Found.'));
            $this->reset(['results', 'reservation_Info']);
            $this->changeTabs('home');
            return;
        }

        $search = str_replace(' ', '%', $this->search);
        $query  = installment_plans::query()->with(['project', 'phases']);
        if ($this->searchType == 'code') {
            $query->whereHas('customers.customer', function ($q) use ($search) {
                $q->where('code', '=', $search);
            });
        } elseif ($this->searchType == 'name') {
            $query->whereHas('customers.customer', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        } elseif ($this->searchType == 'mobile') {
            $query->whereHas('customers.customer', function ($q) use ($search) {
                $q->where('mobile', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        $this->results = $query->with('customers.customer')->get();
        if (count($this->results) < 1) {
            $this->dispatch('error', message: __('No Results Found.'));
            $this->reset(['results', 'reservation_Info']);
            $this->changeTabs('home');
            $this->isWithdrawal = false;
        }
        // dd($this->results);
    }

    public function reservationInfo($id)
    {
        $this->reservationId = $id;
        $this->reservation_Info = instllmentCustomers::query()->where('installment_plan_id', $id)->with('customer')->get();
        $this->changeTabs('info');
        $this->costs = costs_installments::query()->with('costs')->where('installment_plan_id', $id)->get();
        $this->installments = payments::query()->where('installment_plan_id', $id)->get();
    }

    public function delete($id)
    {
        $installmentPlans = installment_plans::find($id);
        if ($installmentPlans) {
            $installmentPlans->delete();
            $this->searchCustomer();
            $this->dispatch('refreshReservations');
        }
    }

    public function render()
    {
        $costTypes = costs::query()->get();
        $banks = Banks::query()->get();
        $CustomerTypes = customerTypes::query()->get();
        $customers = Customers::query()->get();
        return view('livewire.cp.installments.reservations-component', compact('customers', 'CustomerTypes', 'banks', 'costTypes'))->extends('layouts.app');
    }
}
