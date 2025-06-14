<?php

namespace App\Livewire\Cp;

use App\Models\Customers;
use App\Models\Project;
use Livewire\Component;

class DashboardComponent extends Component
{



    public function render()
    {
        $projects = Project::query()->count();
        $customers = Customers::query()->count();
        return view('livewire.cp.dashboard-component',
        [
            'projects'=>$projects,
            'customers'=>$customers,
        ]

        )->extends('layouts.app');
    }
}
