<?php

namespace App\Livewire\Cp\ProjectManagement;

use Livewire\Attributes\Url;
use Livewire\Component;

class ProjectManagementComponent extends Component
{
    public $ListAction =[
        'main' => 'البيانات الرئيسية',
        'phase' => 'مراحل المشروع',
    ];
    public $navigate = 'main';
    protected $queryString = ['navigate'];

    public function mount()
    {
        $this->navigate = request()->query('navigate', 'main'); // جلب القيمه من الـ URL
    }
    #[Url]
    public function navigateTo($page)
    {
        $this->navigate = $page;
        $this->dispatch('update-url', navigate: $page);
    }

    public function render()
    {
        return view('livewire.cp.project-management.project-management-component')->extends('layouts.app');
    }
}
