<?php

namespace App\Livewire\Cp\Settings\Sales;

use App\Models\sales;
use Livewire\Component;

class Index extends Component
{
    public $pageNumber = 5;
    public $code, $name, $jop, $mobile, $idCard, $address, $salesId;



    public function lastCode()
    {
        $lastCode = sales::query()->latest()->first()->code;
        $this->code = $lastCode ? $lastCode + 1 : 1;
    }

    public function mount()
    {
        $this->lastCode();
    }

    public function store()
    {
        $this->validate([
            'code' => 'required|unique:sales,code',
            'name' => 'required|string|max:255',
            'jop' => 'required|string|max:255',
        ]);
        sales::create([
            'code' => $this->code,
            'name' => $this->name,
            'jop' => $this->jop,
            'mobile' => $this->mobile,
            'idCard' => $this->idCard,
            'address' => $this->address
        ]);
        $this->reset();
        $this->dispatch('message', message: __('Done Save'));
    }

    public function edit($id)
    {
        $this->reset('code');
        $sale = sales::findOrFail($id);
        $this->salesId = $sale->id;
        $this->code = $sale->code;
        $this->name = $sale->name;
        $this->jop = $sale->jop;
        $this->mobile = $sale->mobile;
        $this->idCard = $sale->idCard;
        $this->address = $sale->address;
    }

    public function update()
    {
        $this->validate([
            'code' => 'required|unique:sales,code,' . $this->salesId,
            'name' => 'required|string|max:255',
            'jop' => 'required|string|max:255',
        ]);

        $sale = sales::findOrFail($this->salesId);
        $sale->update([
            'code' => $this->code,
            'name' => $this->name,
            'jop' => $this->jop,
            'mobile' => $this->mobile,
            'idCard' => $this->idCard,
            'address' => $this->address
        ]);

        $this->reset();
        $this->dispatch('message', message: __('Done Update'));
        $this->lastCode();
    }

    public function delete($id)
    {
        $sale = sales::findOrFail($id);
        $sale->delete();
        $this->dispatch('message', message: __('Done Delete'));
        $this->reset();
        $this->lastCode();
    }

    public function render()
    {
        $sales = sales::query()->latest()->paginate($this->pageNumber);

        return view('livewire.cp.settings.sales.index', compact('sales'))->extends('layouts.app');
    }
}
