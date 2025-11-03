<?php
namespace App\Livewire\Cp\Reports;

use App\Models\costs_installments;
use App\Models\payments;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class CollectionIndex extends Component
{

    public $costInstallments        = [];
    public $costInstallmentsReaming = [];
    public $payments                = [];
    public $paymentsReaming         = [];
    public $start_date;
    public $end_date;
    public function resetAll()
    {
        $this->costInstallments        = [];
        $this->costInstallmentsReaming = [];
        $this->payments                = [];
        $this->paymentsReaming         = [];
    }

    public function getBetweenTwoDates()
    {
        $this->getByMounth($this->start_date, $this->end_date);

    }

    public function getByMounth($from = null, $to = null)
    {

        //costs installmetns
        if ($from && $to) {
            $this->resetAll();
            $this->costInstallments = costs_installments::query()->with(['costs', 'installmentPlan.customers.customer'])
                ->whereBetween('date', [$from, $to])
                ->orderBy('date', 'ASC')
                ->where('status', 'pending')->get();
            // dd($this->costInstallments);
            //Payments
            $this->payments = payments::query()->with(['installmentPlan.customers.customer'])
                ->whereBetween('due_date', [$from, $to])
                ->orderBy('due_date', 'ASC')
                ->where('status', 'pending')->get();
            $this->dispatch('$refresh');
            // Log::info('Updated:', [
            //     'payments' => $this->payments,
            //     'costs'    => $this->costInstallments,
            // ]);
        } else {
            $this->resetAll();
            $this->costInstallments = costs_installments::query()->with(['costs', 'installmentPlan.customers.customer'])
                ->whereMonth('date', Carbon::now()->month)
                ->whereYear('date', Carbon::now()->year)
                ->orderBy('date', 'ASC')
                ->where('status', 'pending')->get();

            //Payments
            $this->payments = payments::query()->with(['installmentPlan.customers.customer'])
                ->whereMonth('due_date', Carbon::now()->month)
                ->whereYear('due_date', Carbon::now()->year)
                ->orderBy('due_date', 'ASC')
                ->where('status', 'pending')->get();

        }

        //  dd($this->payments);
    }

    public function printView()
    {
        Session::put('costInstallments', $this->costInstallments);
        Session::put('payments', $this->payments);
        return redirect()->route('pdf.collection-summary');
    }
    public function mount()
    {
        $this->getByMounth();
    }

    public function render()
    {

        return view('livewire.cp.reports.collection-index')
            ->extends('layouts.app');
    }
}
