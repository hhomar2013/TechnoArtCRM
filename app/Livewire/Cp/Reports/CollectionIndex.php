<?php
namespace App\Livewire\Cp\Reports;

use App\Models\costs_installments;
use App\Models\costs_reamig;
use App\Models\payments;
use Carbon\Carbon;
use Livewire\Component;

class CollectionIndex extends Component
{

    public $costInstallments        = [];
    public $costInstallmentsReaming = [];
    public $payments                = [];
    public $paymentsReaming         = [];
    public function resetAll()
    {
        $this->costInstallments        = [];
        $this->costInstallmentsReaming = [];
        $this->payments                = [];
        $this->paymentsReaming         = [];
    }
    public function getByMounth()
    {

        $this->resetAll();
        //costs installmetns
        $this->costInstallments = costs_installments::query()->with('costs')
            ->whereMonth('date', Carbon::now()->month)
            ->whereYear('date', Carbon::now()->year)
            ->where('status', 'pending')->get();

            //Payments
            $this->payments = payments::query()
            ->whereMonth('due_date', Carbon::now()->month)
            ->whereYear('due_date', Carbon::now()->year)
            ->where('status', 'pending')->get();

        //costs reamings
        // $this->costInstallmentsReaming = costs_reamig::query()
        //     ->whereMonth('date', Carbon::now()->month)
        //     ->whereYear('date', Carbon::now()->year)
        //     ->where('status', 'unpaid')->get();
        // dd($this->costInstallments , $this->payments);
    }

    public function render()
    {
        $this->getByMounth();
        return view('livewire.cp.reports.collection-index')
            ->extends('layouts.app');
    }
}
