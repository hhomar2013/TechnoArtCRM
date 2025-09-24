<?php

namespace App\Livewire\Cp\Installments;

use App\Models\CustomerNotes;
use App\Models\Customers;
use App\Models\customerTypes;
use App\Models\installment_plans;
use App\Models\instllmentCustomers;
use Livewire\Component;

class ReservationsComponent extends Component
{
    public $searchType       = 'code';
    public $search           = '';
    public $results          = [];
    public $tabs             = "home";
    public $reservation_Info = [];
    public $newCustomer  = false;
    public $addedCustomer;
    public $isWithdrawal = false;
    public $selectedCustomerType;
    public $selectedCustomer;

    protected $listeners = ['refreshReservations' => '$refresh', 'deleteReservation' => 'delete'];

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
                    'note' => " : تم سحب العميل".' ' . $customer->name .' ' ." من أستمارة " .' #' . $selectedWithdrawelinstallment . ' ',
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
        if (strlen($this->search) < 1) {
            $this->dispatch('error', message: __('No Results Found.'));
            $this->reset(['results', 'reservation_Info']);
            $this->tabs = 'home';
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
            $this->tabs = 'home';
            $this->isWithdrawal = false;
        }
        // dd($this->results);
    }

    public function reservationInfo($id)
    {
        $this->reservation_Info = instllmentCustomers::query()->where('installment_plan_id', $id)->with('customer')->get();
        $this->tabs             = 'info';
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
        $CustomerTypes = customerTypes::query()->get();
        $customers = Customers::query()->get();
        return view('livewire.cp.installments.reservations-component', compact('customers', 'CustomerTypes'))->extends('layouts.app');
    }
}
