<?php

namespace App\Livewire\Cp\Installments\Customers;

use App\Models\Customers;
use App\Models\customerTypes;
use App\Models\sales;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class CustomersComponent extends Component
{
    use  WithPagination;
    protected $listeners = ['CustomerEdit' => 'editCustomer'];
    protected $paginationTheme = 'bootstrap';
    public $name, $code, $idCard,
        $address, $mobile, $phone,
        $area, $floor, $other, $total,
        $pageNumber = 5;
    public  $customersId, $edit_form, $customersTypeId, $salesId;


    public function resetForm()
    {
        $this->reset(['name', 'code', 'idCard', 'address', 'mobile', 'phone', 'area', 'floor', 'other', 'total', 'customersId', 'customersTypeId', 'salesId']);
        $this->code = Customers::query()->orderBy('id', 'desc')->first()->code + 1;
    }
    #[Url]
    public function mount()
    {
        $this->resetForm();
        if (session()->has('edit_id')) {
            $this->editCustomer(session('edit_id'));
            $this->edit_form = session('edit_id');
        }
    }
    public function createCustomer()
    {
        $this->validate([
            'name' => 'required',
            'code' => 'required',
            'idCard' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            // 'customersType' => 'required',
            // 'phone' => 'required',
            // 'area' => 'required',
            // 'floor' => 'required',
            // 'total' => 'required',
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
            'customer_type' => $this->customersTypeId ? $this->customersTypeId : 1,
            'sales_id' => $this->salesId ? $this->salesId : 1,
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
        $this->salesId = $customer->sales_id;
        $this->customersTypeId = $customer->customer_type;
    }

    public function updateCustomer()
    {
        $this->validate([
            'name' => 'required',
            'code' => 'required',
            'idCard' => 'required',
            'address' => 'required',
            'mobile' => 'required',
            // 'customersTypeId' => 'required',
            // 'salesId' => 'required',
            // 'phone' => 'required',
            // 'area' => 'required',
            // 'floor' => 'required',
            // 'total' => 'required',
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
            'customer_type' => $this->customersTypeId ? $this->customersTypeId : 1,
            'sales_id' => $this->salesId ? $this->salesId : 1,
        ]);
        $this->resetForm();
        $this->dispatch('message', message: __('Done Save'));
        if ($this->edit_form) {
            return redirect()->to('/reports/customer-data');
        }
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
        $sales = sales::query()->get();
        $customersType = customerTypes::query()->get();
        return view(
            'livewire.cp.installments.customers.customers-component',
            [
                'customers' => $customers,
                'sales' => $sales,
                'customersType' => $customersType,
            ]
        )->extends('layouts.app');
    }
}
