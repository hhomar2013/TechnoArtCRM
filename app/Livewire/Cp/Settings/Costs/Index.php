<?php

namespace App\Livewire\Cp\Settings\Costs;

use App\Models\costs;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $pageNumber = 5, $name, $costId;

      public function createCosts()
    {
        $this->validate([
            'name' => 'required',
        ]);
        costs::create([
            'name' => $this->name,
        ]);
        $this->reset(['name','costId']);
        $this->dispatch('message', message: __('Done Save'));
    }

    public function editCosts($id)
    {
        $costs = costs::findOrFail($id);
        $this->costId = $costs->id;
        $this->name = $costs->name;
    }

    public function updateCosts()
    {
        $this->validate([
            'name' => 'required',

        ]);
        $costs = costs::findOrFail($this->costId);
        $costs->update([
            'name' => $this->name,
        ]);
        $this->reset(['name','costId']);
        $this->dispatch('message', message: __('Done Save'));
    }
    public function deleteCosts($id)
    {
        $costs = costs::findOrFail($id);
        $costs->delete();
        $this->reset(['name','costId']);
        $this->dispatch('message', message: __('Done Delete'));
    }


    public function render()
    {
        $costs = costs::query()->paginate($this->pageNumber);
        return view('livewire.cp.settings.costs.index',['costs'=>$costs])->extends('layouts.app');
    }
}
