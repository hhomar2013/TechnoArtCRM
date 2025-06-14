<?php

namespace App\Livewire\Cp\Settings\Banks;

use App\Models\Banks;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use  WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name, $code, $notes, $pageNumber = 5 ,$account_number,$other;
    public  $banksId;
    public function createBanks()
    {
        $this->validate([
            'name' => 'required',
            'code' => 'required',
            'account_number'=>'required'
        ]);
        Banks::create([
            'name' => $this->name,
            'code' => $this->code,
            'notes' => $this->notes,
            'account_number'=>$this->account_number,
            'other' => $this->other,

        ]);
        $this->reset(['name', 'code', 'notes' ,'account_number','other','banksId']);
        $this->dispatch('message', message: __('Done Save'));
    }

    public function editBanks($id)
    {
        $banks = Banks::findOrFail($id);
        $this->banksId = $banks->id;
        $this->name = $banks->name;
        $this->code = $banks->code;
        $this->notes = $banks->notes;
        $this->account_number = $banks->account_number;
        $this->other = $banks->other;
    }

    public function updateBanks()
    {
        $this->validate([
            'name' => 'required',
            'code' => 'required',
            'account_number'=>'required'
        ]);
        $banks = Banks::findOrFail($this->banksId);
        $banks->update([
            'name' => $this->name,
            'code' => $this->code,
            'notes' => $this->notes,
            'account_number'=>$this->account_number,
            'other' => $this->other,
        ]);
        $this->reset(['name', 'code', 'notes' ,'account_number','other','banksId']);
        $this->dispatch('message', message: __('Done Save'));
    }
    public function deleteBanks($id)
    {
        $banks = Banks::findOrFail($id);
        $banks->delete();
        $this->reset(['name', 'code', 'notes' ,'account_number','other','banksId']);
        $this->dispatch('message', message: __('Done Delete'));
    }
    public function render()
    {
        $Banks=Banks::paginate($this->pageNumber);
        return view('livewire.cp.settings.banks.index',['banks'=>$Banks]);
    }
}
