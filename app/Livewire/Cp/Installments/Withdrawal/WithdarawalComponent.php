<?php

namespace App\Livewire\Cp\Installments\Withdrawal;

use App\Models\Customers;
use App\Models\withdrawal;
use App\Models\withdrawalbody;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;

class WithdarawalComponent extends Component
{
    public $withdrawal = [], $withdrawalBody = [];
    public $customer_details = [];
    public $customer = [];
    public $search_type = 'code';
    public $search_txt;
    public $customer_id;
    public $costs = [];
    public $amount;
    public $notes;
    public $action = false;
    public $actionsOptions = [
        'one_payment' => 'دفعه واحده',
        'payments'    => 'مقسمه على دفعات',
    ];

    protected $listeners = [
        'deleteWithDrawal' => 'deleteWithDrawal',
    ];

    public function resetForm()
    {
        $this->withdrawal = [];
        $this->withdrawalBody = [];
        $this->customer_details = [];
        $this->customer = [];
        $this->customer_id = null;
        $this->action = false;
        $this->search_txt = null;
        $this->search_type = 'code';
        $this->reset(['costs', 'customer_details', 'customer_id', 'search_type', 'notes', 'amount']);
    }
    public function edit($id)
    {
        $this->resetForm();
        $withdrawal = withdrawal::query()->where('id', $id)->with('WithdarawalBody')->first();
        if ($withdrawal) {
            $this->withdrawal = $withdrawal;
            $this->customer_id = $withdrawal->customer_id;
            $this->amount = $withdrawal->amount;
            $this->notes = $withdrawal->note;
            foreach ($withdrawal->WithdarawalBody as $key => $value) {
                $this->costs[] = [
                    'cost_id'                   => $value->transaction_type,
                    'value'                     => $value->amount,
                    'date'                      => $value->transaction_date,
                    'transaction_id'            => $value->transaction_id,
                    'notes'                     => $value->notes,
                    'actions'                   => 'one_payment',
                ];
            }
            $this->action = 'add';
        } else {
            $this->dispatch('error', message: __('Withdrawal not found.'));
        }
    }
    public function deleteWithDrawal($id)
    {
        $withdrawal = withdrawal::query()->where('id', $id)->first();
        if ($withdrawal) {
            $withdrawal->delete();
            $this->dispatch('success', message: __('Withdrawal deleted successfully.'));
        } else {
            $this->dispatch('error', message: __('Withdrawal not found.'));
        }
        $this->resetForm();
    }

    public function addCost()
    {
        $this->costs[] = [
            'cost_id'                   => '',
            'value'                     => 0,
            'date'                      => '',
            'transaction_id'            => '',
            'notes'                     => '',
            'actions'                   => '',
        ];
    }

    public function generateCostPayments($index)
    {
        $costId            = $this->costs[$index]['cost_id'];
        $date              = $this->costs[$index]['date'];
        $value             = $this->costs[$index]['value'];
        $installment_count = $this->costs[$index]['costs_installments_count'];
        $dateCount         = $this->costs[$index]['costs_installments_period'];
        $new_date          = '';
        for ($i = 1; $i <= $installment_count; $i++) {
            // $new_date      = SupportCarbon::parse($date)->addMonths($i * $dateCount)->toDateString();
            $new_date = Carbon::parse($date)->addDays(($i * $dateCount) - $dateCount)->toDateString();
            $this->costs[] = [
                'cost_id'                   => $costId,
                'value'                     => $value,
                'date'                      => $new_date,
                'transaction_id'          => '',
                'notes'                     => '',
                'actions'                   => 'one_payment',
                'costs_installments_count'  => '',
                'costs_installments_period' => '',
            ];
        }
        $this->removeCosts($index);
    }

    public function removeCosts($index)
    {
        unset($this->costs[$index]);
        $this->costs = array_values($this->costs);
    }
    public function deleteAllCosts()
    {
        $this->reset(['costs']);
    }

    public function searchCustomer($query = null)
    {
        $query = $this->search_txt;
        if ($query != null) {
            $search    = $query;
            $search    = str_replace(' ', '%', $search);
            $customers = Customers::query();

            if ($this->search_type == 'code') {
                $customers->where('code', '=', $search)->get();
            } elseif ($this->search_type == 'name') {
                $customers->where('name', 'like', '%' . $search . '%')->get();
            } elseif ($this->search_type == 'mobile') {
                $customers->where('mobile', 'like', '%' . $search . '%')->get();
            }
            if ($customers->count() < 1) {
                $this->dispatch('error', message: __('No Results Found.'));
            } else {
                $this->customer_details = $customers->first();
                $this->customer         = $customers->get();
                $this->customer_id = $this->customer_details['id'];
                $this->checkIfHasValue($this->customer_id);
            }
        } else {
            $this->reset('customer');
            $this->reset(['customer', 'customer_details']);
        }
    }

    public function save()
    {
        $withdrawal = withdrawal::query()->updateOrCreate([
            'customer_id' => $this->customer_id,
        ], [
            'amount'         => $this->amount,
            'note'        => $this->notes,
            'created_by'             => auth()->id(),
        ]);
        if ($withdrawal) {
            withdrawalbody::query()->where('withdrawal_id', $withdrawal->id)->delete();
            foreach ($this->costs as $key => $value) {
                withdrawalbody::query()->create([
                    'withdrawal_id' =>     $withdrawal->id,
                    'transaction_id'                => $value['transaction_id'],
                    'amount'             => $value['value'],
                    'transaction_type'               => $value['cost_id'],
                    'transaction_date'               => $value['date'],
                    'notes'               => $value['notes'],
                    'created_by'             => auth()->id(),
                ]);
            }
            $this->dispatch('message', message: __('Withdrawal saved successfully.'));
            $this->resetForm();
        }
    }

    public function checkIfHasValue($customer_id)
    {
        $withdrawal = withdrawal::query()->where('customer_id', $customer_id)->with('WithdarawalBody')->get();
        if ($withdrawal->count() > 0) {
            $this->withdrawal = $withdrawal;
            $this->action = 'withdrawal';
        } else {
            $this->action = 'add';
        }
    }

    public function render()
    {
        return view('livewire.cp.installments.withdrawal.withdarawal-component')->extends('layouts.app');
    }
}
