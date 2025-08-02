<?php

namespace App\Livewire\Cp\Settings;

use Livewire\Attributes\Url;
use Livewire\Component;

class SettingsComponent extends Component
{
    public $navigate = 'general';
    protected $queryString = ['navigate'];

    public function mount()
    {
        $this->navigate = request()->query('navigate', 'general');
    }

    #[Url]
    public function navigateTo($page)
    {
        $this->navigate = $page;
        $this->dispatch('update-url', navigate: $page);
    }
    public function render()
    {
        return view('livewire.cp.settings.settings-component')->extends('layouts.app');
    }
}
