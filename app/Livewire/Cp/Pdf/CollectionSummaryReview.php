<?php
namespace App\Livewire\Cp\Pdf;

use Livewire\Component;

class CollectionSummaryReview extends Component
{
    public $costInstallments = [];
    public $payments         = [];

    public function mount()
    {
        $this->costInstallments = session()->get('costInstallments', []);
        $this->payments         = session()->get('payments', []);
    }

    public function render()
    {
        return view('livewire.cp.pdf.collection-summary-review')->extends('layouts.app');
    }
}
