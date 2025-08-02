<?php

namespace App\Livewire\Cp\Settings\PaymentsPlan;

use App\Models\payment_plans;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use  WithPagination;
    protected $paginationTheme = 'bootstrap';
    public  $pageNumber = 5 ,$paymentsId,$name,$years,$down_payment_percent,$installment_count;

    public function mount()
    {
        $this->resetPage();
        $this->pageNumber = 5;
    }
    public function create()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'years' => 'required|numeric',
            'down_payment_percent' => 'required|numeric|between:0,100',
            'installment_count' => 'required|integer|min:1'
        ]);

        payment_plans::create([
            'name' => $this->name,
            'years' => $this->years,
            'down_payment_percent' => $this->down_payment_percent,
            'installments_count' => $this->installment_count
        ]);

        $this->reset();
        $this->dispatch('message' ,message: __('Done Save'));
    }

    public function edit($id)
    {
        $payment_plan = payment_plans::findOrFail($id);
        $this->paymentsId = $id;
        $this->name = $payment_plan->name;
        $this->years = $payment_plan->years;
        $this->down_payment_percent = $payment_plan->down_payment_percent;
        $this->installment_count = $payment_plan->installments_count;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'years' => 'required|numeric',
            'down_payment_percent' => 'required|numeric|between:0,100',
            'installment_count' => 'required|integer|min:1'
        ]);

        $payment_plan = payment_plans::findOrFail($this->paymentsId);
        $payment_plan->update([
            'name' => $this->name,
            'years' => $this->years,
            'down_payment_percent' => $this->down_payment_percent,
            'installments_count' => $this->installment_count
        ]);

        $this->reset();
        $this->dispatch('message' ,message: __('Done Update'));
    }

    public function delete($id)
    {
        $payment_plan = payment_plans::findOrFail($id);
        $payment_plan->delete();
        session()->flash('success', 'Payment plan deleted successfully.');
    }
    public function render()
    {
        $payments_plan = payment_plans::query()->paginate($this->pageNumber);
        return view('livewire.cp.settings.payments-plan.index',['payments_plan' => $payments_plan]);
    }
}
