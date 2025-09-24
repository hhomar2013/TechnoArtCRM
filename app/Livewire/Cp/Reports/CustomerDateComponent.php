<?php

namespace App\Livewire\Cp\Reports;

use App\Models\CustomerNotes;
use App\Models\Customers;
use App\Models\customerTypes;
use Livewire\Component;
use Livewire\WithPagination;

class CustomerDateComponent extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $pageNumber, $search, $customersData;
    // public $customers = [];
    public $customer_id;
    public $customer_details, $customerTypesId, $isShowNotes, $customerNotes = [];

    public function mount()
    {
        $this->pageNumber = 20;
        $this->resetPage();
    }

    public function updatedSearch()
    {
        if (!$this->search) {
            $this->resetPage();
        }
    }
    public function updatedCustomerTypesId()
    {
        // dd($this->customerTypesId);
    }

    public function resetSearch()
    {
        $this->customerTypesId = null;
        $this->search = null;
    }

    public function customerdEdit($id)
    {
        session()->flash('edit_id', $id);
        return redirect()->to('/customers');
    }

    public function showNotes($id)
    {
        $this->customer_id = $id;
        $this->customerNotes = CustomerNotes::query()->with('user')->where('customer_id', $id)->orderBy('id','desc')->get();
        $this->isShowNotes = true;
    }

    public function render()
    {
        $customers = [];
        $cutomerTypes = customerTypes::query()->get();
        $search = str_replace(' ', '%', $this->search);
        if (!$this->search && !$this->customerTypesId) {
            $customers = '';
            $customers = Customers::query()
                ->with('notes')
                ->paginate($this->pageNumber);
        } elseif ($this->customerTypesId) {
            $customers = Customers::query()
                ->with('notes')
                ->where('customer_type', $this->customerTypesId)
                ->paginate($this->pageNumber);
        } else {
            $customers = '';
            $customers = Customers::query()
                ->with('notes')
                // ->where('id', 'like', '%' . $search . '%')
                // ->orWhere('code', 'like', '%' . $search . '%')
                // ->orWhere('name', 'like', '%' . $search . '%')
                // ->orWhere('mobile', 'like', '%' . $search . '%')
                ->where(function ($q) use ($search) {
                    $q->where('id', 'like', '%' . $search . '%')
                        ->orWhere('code', 'like', '%' . $search . '%')
                        ->orWhere('name', 'like', '%' . $search . '%')
                        ->orWhere('mobile', 'like', '%' . $search . '%');
                })
                ->orderBy('id', 'asc')
                ->paginate($this->pageNumber);
        }
        // dd($customers);
        return view('livewire.cp.reports.customer-date-component', compact('customers', 'cutomerTypes'))->extends('layouts.app');
    }
}
