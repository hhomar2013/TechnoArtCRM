<?php

namespace App\Livewire\Cp\Installments\Customers;

use App\Models\Customers;
use Livewire\Component;
use Livewire\WithPagination;

class CustomersComponent extends Component
{
    use  WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name, $code, $idCard,
        $address, $mobile, $phone,
        $area, $floor, $other, $total,
        $pageNumber = 5;
    public  $customersId;


    public function resetForm()
    {
        $this->reset(['name', 'code', 'idCard', 'address', 'mobile', 'phone', 'area', 'floor', 'other', 'total', 'customersId']);
    }
    public function createCustomer()
    {
        $this->validate([
            'name' => 'required',
            'code' => 'required',
            'idCard' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            'phone' => 'required',
            'area' => 'required',
            'floor' => 'required',
            'total' => 'required',
        ]);
        Customers::create([
            'code' => $this->code,
            'name' => $this->name,
            'idCard' => $this->idCard,
            'address' => $this->address,
            'mobile' => $this->mobile,
            'phone' => $this->phone,
            'area' => $this->area,
            'floor' => $this->floor,
            'other' => $this->other,
            'total' => $this->total,
        ]);
        $this->resetForm();
        $this->dispatch('message', message: __('Done Save'));
    }

    public function editCustomer($id)
    {
        $customer = Customers::findOrFail($id);
        $this->customersId = $customer->id;
        $this->name = $customer->name;
        $this->code = $customer->code;
        $this->idCard = $customer->idCard;
        $this->address = $customer->address;
        $this->mobile = $customer->mobile;
        $this->phone = $customer->phone;
        $this->area = $customer->area;
        $this->floor = $customer->floor;
        $this->other = $customer->other;
        $this->total = $customer->total;
    }

    public function updateCustomer()
    {
        $this->validate([
            'name' => 'required',
            'code' => 'required',
            'idCard' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            'phone' => 'required',
            'area' => 'required',
            'floor' => 'required',
            'total' => 'required',
        ]);
        $customer = Customers::findOrFail($this->customersId);
        $customer->update([
            'code' => $this->code,
            'name' => $this->name,
            'idCard' => $this->idCard,
            'address' => $this->address,
            'mobile' => $this->mobile,
            'phone' => $this->phone,
            'area' => $this->area,
            'floor' => $this->floor,
            'other' => $this->other,
            'total' => $this->total,
        ]);
        $this->resetForm();
        $this->dispatch('message', message: __('Done Save'));
    }
    public function deleteCustomer($id)
    {
        $banks = Customers::findOrFail($id);
        $banks->delete();
        $this->resetForm();
        $this->dispatch('message', message: __('Done Delete'));
    }

    public function render()
    {
        $customers = Customers::query()->paginate($this->pageNumber);
        return view(
            'livewire.cp.installments.customers.customers-component',
            [
                'customers' => $customers
            ]
        )->extends('layouts.app');
    }
}
