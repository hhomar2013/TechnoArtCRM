<?php

namespace App\Livewire\Cp\Installments;

use App\Models\Banks;
use App\Models\boxs;
use App\Models\costs_installments;
use App\Models\costs_reamig;
use App\Models\Customers;
use App\Models\customer_account;
use App\Models\CustomerNotes;
use App\Models\customerTypes;
use App\Models\instllmentCustomers;
use App\Models\payments;
use App\Models\payments_reaming;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

use function PHPUnit\Framework\returnSelf;

class CollectionComponent extends Component
{
    // public $search = '';
    // public $result ='';
    public $customer = [];
    public $customer_id;
    public $customer_details;
    public $costs            = [];
    public $payments         = [];
    public $notes;
    public $selectedPayments = [];
    public $selectedCosts    = [];
    public $customer_balance;
    public $collectCosts    = false;
    public $collectPayments = false;
    public $search_type     = 'code';
    public $bank, $transaction_id, $transaction_date, $time,
        $receipt_value            = 0.0, $reaming            = 0.0, $total_payment            = 0.0, $cost_reaming            = false, $payment_reaming            = false,
        $greaterThanCustomerCount = false, $selected_installment_id;

    public function mount()
    {
        if (session()->has('installmentId') && session()->has('customerId')) {
            $this->customer_id = session('customerId');
            $this->customer    = session('customerId');
            $customer_search   = $this->searchCustomer($this->customer_id);
            $this->getSearch(session('installmentId'));
        }
    }

    public function saveNotes()
    {
        // strlen($this->notes) > 1
        if ($this->notes) {
            CustomerNotes::query()->create([
                'note' => $this->notes,
                'user_id' => auth()->user()->id,
                'customer_id' => $this->customer_id,
            ]);
        }
    }

    public function previewCustomerReport($id)
    {
        return redirect()->to('/pdf/customer-payments/' . $id);
    }

    public function updated($variable)
    {
        switch ($variable) {
            case 'customer':
                $this->searchCustomer($this->customer);
                break;
            case 'customer_id';
                $this->searchCustomer($this->customer_id);
                break;
            case 'receipt_value':
                $this->totalReaming();
                break;
            default:
                # code...
                break;
        }
    }

    public function selectCostReaming($id)
    {
        $costs                 = costs_reamig::where('cost_id', $id)->first();
        $this->cost_reaming    = $id;
        $this->selectedCosts[] = [
            'id'    => $costs->id,
            'value' => $costs->remaining,
            'cost'  => $costs->notes,
            'date'  => $costs->date,
        ];
    }
    public function selectPaymentReaming($id)
    {
        $payment_reaming          = payments_reaming::query()->where('payment_id', $id)->first();
        $payment                  = payments::query()->find($id);
        $this->selectedPayments[] = [
            'id'     => $payment_reaming->id,
            'amount' => $payment_reaming->remaining,
            'type'   => $payment_reaming->notes,
            'date'   => $payment->due_date,
        ];
        $this->payment_reaming = $id;
    }

    public function save_cost_reaming()
    {
        $costs_reaming         = costs_reamig::where('cost_id', $this->cost_reaming)->first();
        $costs_reaming->status = 'paid';
        $costs_reaming->bank = $this->bank;
        $costs_reaming->time = $this->time;
        $costs_reaming->transaction_id = $this->transaction_id;
        $costs_reaming->transaction_date = $this->transaction_id;
        $costs_reaming->save();
        if ($costs_reaming) {
            $costs = costs_installments::query()->findOrFail($this->cost_reaming);
            $costs->update([
                'status' => 'paid',
            ]);
            boxs::query()->create([
                'in_or_out' => 0,
                'value'     => $costs_reaming->remaining,
                'notes'     => 'تم تحصيل : ' . ' ' . $costs_reaming->remaining . ' ' . 'من العميل : ' . $this->customer_details->name . ' بتاريخ : ' . ' ' . $this->transaction_date,
                'date'      => $this->transaction_date,
                'time'      => $this->time,
                'user_id'   => Auth::id(),
            ]);
            $this->saveNotes();
        }
        $this->cost_reaming  = false;
        $this->selectedCosts = [];
        $this->dispatch('message', message: __('Done Save'));
        $this->reset(['bank', 'transaction_id', 'transaction_date', 'time', 'reaming', 'receipt_value', 'notes']);
        $this->removeAll();
        $this->getSearch($this->selected_installment_id);
    }

    public function save_payments_reaming()
    {
        $payment_reamings         = payments_reaming::where('payment_id', $this->payment_reaming)->first();
        $payment_reamings->status = 'paid';
        $payment_reamings->bank = $this->bank;
        $payment_reamings->time = $this->time;
        $payment_reamings->transaction_id = $this->transaction_id;
        $payment_reamings->transaction_date = $this->transaction_date;
        $payment_reamings->save();
        if ($payment_reamings) {
            $payments = payments::query()->findOrFail($this->payment_reaming);
            $payments->update([
                'status' => 'paid',

            ]);
            boxs::query()->create([
                'in_or_out' => 0,
                'value'     => $payment_reamings->remaining,
                'notes'     => 'تم تحصيل : ' . ' ' . $payment_reamings->remaining . ' ' . 'من العميل : ' . $this->customer_details->name . ' بتاريخ : ' . ' ' . $this->transaction_date,
                'date'      => $this->transaction_date,
                'time'      => $this->time,
                'user_id'   => Auth::id(),
            ]);

            $this->saveNotes();
        }
        $this->payment_reaming  = false;
        $this->selectedPayments = [];
        $this->dispatch('message', message: __('Done Save'));
        $this->reset(['bank', 'transaction_id', 'transaction_date', 'time', 'reaming', 'receipt_value', 'notes']);
        $this->removeAll();
        $this->getSearch($this->selected_installment_id);
    }
    public function back()
    {
        $this->reset(['collectCosts', 'notes', 'collectPayments', 'selectedPayments', 'selectedCosts', 'bank', 'transaction_id', 'transaction_date', 'time', 'receipt_value', 'reaming', 'total_payment']);
    }
    public function totalReaming()
    {
        $value               = 0;
        $this->total_payment = '';
        if ($this->selectedPayments) {
            foreach ($this->selectedPayments as $payment_val) {
                $value += $payment_val['amount'];
            }
            $this->total_payment = $value;
            // $this->reaming = $this->receipt_value - $this->total_payment;
        } else if ($this->selectedCosts) {
            foreach ($this->selectedCosts as $costs_val) {
                $value += $costs_val['value'];
            }
            $this->total_payment = $value;
        }

        return $this->reaming = (float) $this->receipt_value - (float) $this->total_payment;
    }

    public function check_customer_count($customerId)
    {
        $search = DB::table('customers')
            ->select(
                'customers.id',
                'customers.name',
                'instllment_customers.installment_plan_id',
                'installment_plans.project_id',
                'installment_plans.status as statusip',
                'projects.name as project_name',
                'phases.name as phase_name',
                'phases.id as phase_id'
            )
            ->join('instllment_customers', 'customers.id', '=', 'instllment_customers.customersId')
            ->join('installment_plans', 'instllment_customers.installment_plan_id', '=', 'installment_plans.id')
            ->join('projects', 'installment_plans.project_id', '=', 'projects.id')
            ->join('phases', 'installment_plans.phase_id', '=', 'phases.id')
            ->where('customers.id', $customerId)
            ->get();
        return $search;
    }
    public function searchCustomer($query = null)
    {
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
                $customer_count         = $this->check_customer_count($this->customer_details->id);
                // if ($customer_count->count() < 1) {
                //     $this->dispatch('error', message: __('No Results Found.'));
                // }
                $this->greaterThanCustomerCount = $customer_count;
            }
        } else {
            $this->reset('customer');
            $this->reset(['customer', 'customer_details', 'greaterThanCustomerCount']);
        }
    }
    public function getSearch($installment_p_id)
    {
        $this->selected_installment_id = $installment_p_id;
        $custId                        = $this->customer_details->id;
        if ($custId == null) {
            $this->dispatch('error', message: __('No Current Data'));
            $this->reset();
            $this->reset(['customer', 'customer_details', 'greaterThanCustomerCount']);
        } else {
            $customer_installment = instllmentCustomers::query()->where('customersId', '=', $custId)->first();
            if ($customer_installment) {
                $installment_plan_id = $customer_installment->installment_plan_id;
                $this->costs         = costs_installments::query()->where('installment_plan_id', '=', $installment_p_id)
                    ->with('costs')
                    ->with('reamings')
                    ->get();
                $this->payments = payments::query()
                    // ->where('status', 'pending')
                    ->where('installment_plan_id', '=', $installment_p_id)
                    ->with('reamings')
                    ->get();
                $this->customer_balance = customer_account::query()->where('customersId', '=', $custId)->sum('credit');
                // dd($this->payments);
            } else {
                $this->dispatch('error', message: __('No Results Found.'));
                $this->reset();
                $this->reset(['customer', 'customer_details', 'greaterThanCustomerCount']);
            }
        }
    }

    public function selectPayments($id)
    {
        $payments = payments::query()->find($id);

        if (! $payments) {
            $this->dispatch('error', message: __('No Results Found.'));
            return;
        }

        // تحقق إذا كان العميل موجود بالفعل في الـ array
        $alreadyExists = collect($this->selectedPayments)->contains(function ($item) use ($payments) {
            return $item['id'] == $payments->id;
        });

        if ($alreadyExists) {
            $this->dispatch('error', message: __('موجود بالفعل'));
            return;
        }
        $this->selectedPayments[] = [
            'id'     => $payments->id,
            'amount' => $payments->amount,
            'type'   => $payments->type == 'installment' ? 'قسط' : $payments->type,
            'date'   => $payments->due_date,
        ];
    }

    public function selectCost($id)
    {
        $costs = costs_installments::query()->find($id);

        if (! $costs) {
            $this->dispatch('error', message: __('No Results Found.'));
            return;
        }
        // تحقق إذا كان العميل موجود بالفعل في الـ array
        $alreadyExists = collect($this->selectedCosts)->contains(function ($item) use ($costs) {
            return $item['id'] == $costs->id;
        });

        if ($alreadyExists) {
            $this->dispatch('error', message: __('موجود بالفعل'));
            return;
        }
        $this->selectedCosts[] = [
            'id'    => $costs->id,
            'value' => $costs->value,
            'cost'  => $costs->costs->name,
            'date'  => $costs->date,
        ];
    }

    public function removeCost($index)
    {
        unset($this->selectedCosts[$index]);
        $this->selectedCosts = array_values($this->selectedCosts);
    }

    public function removeAll()
    {
        $this->reset(['selectedCosts', 'selectedPayments']);
    }

    public function removePayment($index)
    {
        unset($this->selectedPayments[$index]);
        $this->selectedPayments = array_values($this->selectedPayments);
    }

    public function collectCosts()
    {
        $this->collectCosts = true;
    }

    public function collectPayment()
    {
        $this->collectPayments = true;
    }

    public function updateCostsInstallmentsStatus($id, $status)
    {
        $cost                   = costs_installments::find($id);
        $cost->bank             = $this->bank;
        $cost->time             = $this->time;
        $cost->transaction_id   = $this->transaction_id;
        $cost->transaction_date = $this->transaction_date;
        $cost->status           = $status;
        $cost->save();
    }

    public function updatePaymentsInstallmentsStatus($id, $status)
    {
        $payment                   = payments::find($id);
        $payment->bank             = $this->bank;
        $payment->paid_at          = $this->time;
        $payment->transaction_id   = $this->transaction_id;
        $payment->transaction_date = $this->transaction_date;
        $payment->status           = $status;
        $payment->save();
    }

    public function saveCosts()
    {
        $this->validate([
            'bank'             => 'required',
            'transaction_id'   => 'required',
            'transaction_date' => 'required',
            'time'             => 'required',
            'reaming'          => 'required',
        ]);
        $print               = [];
        $last_key            = array_key_last($this->selectedCosts);
        $this->reaming       = str_contains($this->reaming, '-') ? (float) str_replace('-', '', $this->reaming) : $this->reaming;
        $receipt_value_costs = 0.0;
        $totalCostsValue     = array_sum(array_column($this->selectedCosts, 'value'));
        $receipt_value_costs = $this->receipt_value;
        if ($this->receipt_value == $totalCostsValue) {
            for ($i = 0; $i < count($this->selectedCosts); $i++) {
                $receipt_value_costs -= $this->selectedCosts[$i]['value'];
                $this->updateCostsInstallmentsStatus($this->selectedCosts[$i]['id'], 'paid');
                if ($i == $last_key) {
                    $box = boxs::query()->create([
                        'in_or_out' => 0,
                        'value'     => $this->receipt_value,
                        'notes'     =>
                        ' تم تحصيل : ' . $this->selectedCosts[$i]['cost'] .
                            ' من العميل :  ' . $this->customer_details->name .
                            ' بتاريخ  :  ' . $this->selectedCosts[$i]['date'],
                        'date'      => Carbon::now(),
                        'time'      => $this->time,
                        'user_id'   => auth()->id(),
                    ]);
                }
            }
        } else if ($this->receipt_value > $totalCostsValue) {
            for ($i = 0; $i < count($this->selectedCosts); $i++) {
                $receipt_value_costs -= $this->selectedCosts[$i]['value'];
                $this->updateCostsInstallmentsStatus($this->selectedCosts[$i]['id'], 'paid');
                if ($i == $last_key) {

                    $this->updateCostsInstallmentsStatus($this->selectedCosts[$i]['id'], 'paid');

                    $customer_account = customer_account::query()->create([
                        'customersId' => $this->customer_details->id,
                        'debit'       => 0,
                        'credit'      => $receipt_value_costs,
                        'status'      => 0,
                        'notes'       => 'سداد تكاليف',
                        'user_id'     => auth()->id(),
                    ]);

                    if ($customer_account) {
                        $box = boxs::query()->create([
                            'in_or_out' => 0,
                            'value'     => $this->receipt_value,
                            'notes'     =>
                            ' تم تحصيل : ' . $this->selectedCosts[$i]['cost'] .
                                'من العميل :  ' . $this->customer_details->name .
                                ' بتاريخ  :  ' . $this->selectedCosts[$i]['date'] .
                                'باقي له :  ' . number_format($receipt_value_costs, 2),
                            'date'      => Carbon::now(),
                            'time'      => $this->time,
                            'user_id'   => auth()->id(),
                        ]);
                    }
                    dd($customer_account, $box);
                }
            }
        } else if ($this->receipt_value < $totalCostsValue) {
            for ($i = 0; $i < count($this->selectedCosts); $i++) {
                $receipt_value_costs -= $this->selectedCosts[$i]['value'];
                $this->updateCostsInstallmentsStatus($this->selectedCosts[$i]['id'], 'paid');
                if ($i == $last_key) {
                    $this->updateCostsInstallmentsStatus($this->selectedCosts[$i]['id'], 'partiallycollected');
                    $receipt_value_costs = str_contains($receipt_value_costs, '-') ? (float) str_replace('-', '', $receipt_value_costs) : $receipt_value_costs;
                    $cost_reaming        = costs_reamig::query()->create([
                        'cost_id'   => $this->selectedCosts[$i]['id'],
                        'user_id'   => auth()->id(),
                        'remaining' => (float) $this->reaming,
                        'notes'     => ' المتبقى من ' . $this->selectedCosts[$i]['cost'] . '  : '
                            . number_format($receipt_value_costs, 2) . ' رقم  : '
                            . $this->selectedCosts[$i]['id'],
                        'status'    => 'unpaid',
                    ]);
                    if ($cost_reaming) {
                        boxs::query()->create([
                            'in_or_out' => 0,
                            'value'     => $this->receipt_value,
                            'notes'     => ' المتبقى من ' . $this->selectedCosts[$i]['cost'] . '  : '
                                . number_format($cost_reaming->remaining, 2) . ' رقم  : '
                                . $this->selectedCosts[$i]['id'],
                            'date'      => Carbon::now(),
                            'time'      => $this->time,
                            'user_id'   => auth()->id(),
                        ]);
                    }
                }
            }
        }
        $this->saveNotes();
        $this->dispatch('message', message: __('Done Save'));
        $this->reset(['bank', 'transaction_id', 'transaction_date', 'time', 'reaming', 'receipt_value', 'notes']);
        $this->removeAll();
    }

    public function savePayments()
    {
        $this->validate([
            'bank'             => 'required',
            'transaction_id'   => 'required',
            'transaction_date' => 'required',
            'time'             => 'required',
            'reaming'          => 'required',
        ]);

        $last_key               = array_key_last($this->selectedPayments);
        $this->reaming          = str_contains($this->reaming, '-') ? (float) str_replace('-', '', $this->reaming) : $this->reaming;
        $receipt_value_payments = 0.0;
        $totalPaymentsValue     = array_sum(array_column($this->selectedPayments, 'amount'));
        $receipt_value_payments = $this->receipt_value;

        if ($this->receipt_value == $totalPaymentsValue) {
            for ($i = 0; $i < count($this->selectedPayments); $i++) {
                $receipt_value_payments -= $this->selectedPayments[$i]['amount'];
                $this->updatePaymentsInstallmentsStatus($this->selectedPayments[$i]['id'], 'paid');
                if ($i == $last_key) {
                    $box = boxs::query()->create([
                        'in_or_out' => 0,
                        'value'     => $this->receipt_value,
                        'notes'     =>
                        ' تم تحصيل : ' . $this->selectedPayments[$i]['type'] .
                            ' من العميل :  ' . $this->customer_details->name .
                            ' بتاريخ  :  ' . $this->selectedPayments[$i]['date'],
                        'date'      => Carbon::now(),
                        'time'      => $this->time,
                        'user_id'   => auth()->id(),
                    ]);
                }
            }
        } else if ($this->receipt_value > $totalPaymentsValue) {
            for ($i = 0; $i < count($this->selectedPayments); $i++) {
                $receipt_value_payments -= $this->selectedPayments[$i]['amount'];
                $this->updatePaymentsInstallmentsStatus($this->selectedPayments[$i]['id'], 'paid');
                if ($i == $last_key) {
                    $this->updatePaymentsInstallmentsStatus($this->selectedPayments[$i]['id'], 'paid');
                    $customer_account = customer_account::query()->create([
                        'customersId' => $this->customer_details->id,
                        'debit'       => 0,
                        'credit'      => $receipt_value_payments,
                        'status'      => 0,
                        'notes'       => 'سداد تكاليف',
                        'user_id'     => auth()->id(),
                    ]);

                    if ($customer_account) {
                        $box = boxs::query()->create([
                            'in_or_out' => 0,
                            'value'     => $this->receipt_value,
                            'notes'     =>
                            ' تم تحصيل : ' . $this->selectedPayments[$i]['type'] .
                                'من العميل :  ' . $this->customer_details->name .
                                ' بتاريخ  :  ' . $this->selectedPayments[$i]['date'] .
                                'باقي له :  ' . number_format($receipt_value_payments, 2),
                            'date'      => Carbon::now(),
                            'time'      => $this->time,
                            'user_id'   => auth()->id(),
                        ]);
                    }
                    dd($customer_account, $box);
                }
            }
        } else if ($this->receipt_value < $totalPaymentsValue) {
            for ($i = 0; $i < count($this->selectedPayments); $i++) {
                $receipt_value_payments -= $this->selectedPayments[$i]['amount'];
                $this->updatePaymentsInstallmentsStatus($this->selectedPayments[$i]['id'], 'paid');
                if ($i == $last_key) {
                    $this->updatePaymentsInstallmentsStatus($this->selectedPayments[$i]['id'], 'partiallycollected');
                    $receipt_value_payments = str_contains($receipt_value_payments, '-') ? (float) str_replace('-', '', $receipt_value_payments) : $receipt_value_payments;
                    $payment_reaming        = payments_reaming::query()->create([
                        'payment_id' => $this->selectedPayments[$i]['id'],
                        'user_id'    => auth()->id(),
                        'remaining'  => (float) $this->reaming,
                        'notes'      => ' المتبقى من ' . $this->selectedPayments[$i]['type'] . '  : '
                            . number_format($receipt_value_payments, 2) . ' رقم  : '
                            . $this->selectedPayments[$i]['id'],
                        'status'     => 'unpaid',
                    ]);
                    if ($payment_reaming) {
                        boxs::query()->create([
                            'in_or_out' => 0,
                            'value'     => $this->receipt_value,
                            'notes'     => ' المتبقى من ' . $this->selectedPayments[$i]['type'] . '  : '
                                . number_format($payment_reaming->remaining, 2) . ' رقم  : '
                                . $this->selectedPayments[$i]['id'],
                            'date'      => Carbon::now(),
                            'time'      => $this->time,
                            'user_id'   => auth()->id(),
                        ]);
                    }
                }
            }
        }
        $this->saveNotes();
        $this->dispatch('message', message: __('Done Save'));
        $this->reset(['bank', 'transaction_id', 'transaction_date', 'time', 'reaming', 'receipt_value', 'notes']);
        $this->removeAll();
        $this->getSearch($this->selected_installment_id);
    }

    public function render()
    {
        $banks = Banks::all();
        // $customers = Customers::all();
        return view('livewire.cp.installments.collection-component', ['banks' => $banks])->extends('layouts.app');
    }
}
