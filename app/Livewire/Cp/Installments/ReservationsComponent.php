<?php
namespace App\Livewire\Cp\Installments;

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

    public function changeTabs($tab)
    {
        $this->tabs = $tab;
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
                $q->where('code', 'like', "%{$search}%");
            });
        } elseif ($this->searchType == 'name') {
            $query->whereHas('customers.customer', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        } elseif ($this->searchType == 'mobile') {
            $query->whereHas('customers.customer', function ($q) use ($search) {
                $q->where('mobile', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }
        $this->results = $query->with('customers.customer')->get();
        // dd( $this->results);
        if (count($this->results) < 1) {
            $this->dispatch('error', message: __('No Results Found.'));
            $this->reset(['results', 'reservation_Info']);
            $this->tabs = 'home';
        }
    }

    public function reservationInfo($id)
    {
        $this->reservation_Info = instllmentCustomers::query()->where('installment_plan_id', $id)->with('customer')->get();
        $this->tabs             = 'info';
        // dd($id);
    }

    public function render()
    {
        return view('livewire.cp.installments.reservations-component')->extends('layouts.app');
    }
}
