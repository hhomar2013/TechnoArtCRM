<?php

namespace App\Livewire\Cp\Settings\CustomerTypes;

use App\Models\customerTypes;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $pageNumber = 5 ,$customerTypeId ,$name;

    public function createCustomerType(){
        $this->validate([
            'name'=>'required',
        ]);
        customerTypes::query()->create([
            'name' => $this->name,
        ]);
        $this->dispatch('message',message: __('Done Save'));
        $this->reset();
    }
    public function edit($id)
    {
        $customerType = customerTypes::findOrFail($id);
        $this->customerTypeId = $customerType->id;
        $this->name = $customerType->name;
    }
    public function updateCustomerType()
    {
        $this->validate([
            'name' => 'required',
        ]);
        $customerType = customerTypes::findOrFail($this->customerTypeId);
        $customerType->update([
            'name' => $this->name,
        ]);
        $this->dispatch('message', message: __('Done Update'));
        $this->reset();
    }
    public function delete($id)
    {
        $customerType = customerTypes::findOrFail($id);
        $customerType->delete();
        $this->dispatch('message', message: __('Done Delete'));
        $this->reset();
    }
    public function render()
    {
        $customer_types = customerTypes::query()->paginate($this->pageNumber);
        return view('livewire.cp.settings.customer-types.index' ,compact('customer_types'))->extends('layouts.app');
    }
}
