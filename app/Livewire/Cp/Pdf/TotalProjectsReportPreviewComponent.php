<?php
namespace App\Livewire\Cp\Pdf;

use Illuminate\Support\Facades\Session;
use Livewire\Component;

class TotalProjectsReportPreviewComponent extends Component
{
    public $totalProjects         = [];
    public $total_payment_pending = 0.0, $total_payment_paid = 0.0;
    public $total_cost_pending    = 0.0, $total_cost_paid    = 0.0;

    public function mount()
    {
        $this->totalProjects = Session::get('totalProjects', []);
        $this->total_payment_pending = Session::get('total_payment_pending', 0.0);
        $this->total_payment_paid    = Session::get('total_payment_paid', 0.0);
        $this->total_cost_pending    = Session::get('total_cost_pending', 0.0);
        $this->total_cost_paid       = Session::get('total_cost_paid', 0.0);
    }

    public function render()
    {
        return view('livewire.cp.pdf.total-projects-report-preview-component')->extends('layouts.app');
    }
}
