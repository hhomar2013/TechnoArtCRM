<?php

namespace App\Livewire\Cp;

use Livewire\Component;

class DashboardComponent extends Component
{



    public function render()
    {

        return view('livewire.cp.dashboard-component')->extends('layouts.app');
    }
}
