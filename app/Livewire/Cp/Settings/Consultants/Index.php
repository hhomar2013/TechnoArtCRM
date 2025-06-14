<?php

namespace App\Livewire\Cp\Settings\Consultants;

use App\Models\consultant;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use  WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name, $code, $notes, $pageNumber = 5;
    public  $consultantId;
    public function createConsultant()
    {
        $this->validate([
            'name' => 'required',
            'code' => 'required',
        ]);
        consultant::create([
            'name' => $this->name,
            'code' => $this->code,
            'notes' => $this->notes
        ]);
        $this->dispatch('backToMainData');
        $this->reset(['name', 'code', 'notes']);
        $this->dispatch('message', message: __('Done Save'));
    }

    public function editConsultant($id)
    {
        $consultant = consultant::findOrFail($id);
        $this->consultantId = $consultant->id;
        $this->name = $consultant->name;
        $this->code = $consultant->code;
        $this->notes = $consultant->notes;
    }

    public function updateConsultant()
    {
        $this->validate([
            'name' => 'required',
            'code' => 'required',
        ]);
        $consultant = consultant::findOrFail($this->consultantId);
        $consultant->update([
            'name' => $this->name,
            'code' => $this->code,
            'notes' => $this->notes
        ]);
        $this->dispatch('backToMainData');
        $this->reset(['name', 'code', 'notes']);
        $this->dispatch('message', message: __('Done Save'));
    }
    public function deleteConsultant($id)
    {
        $consultant = consultant::findOrFail($id);
        $consultant->delete();
        $this->dispatch('backToMainData');
        $this->reset(['name', 'code', 'notes']);
        $this->dispatch('message', message: __('Done Delete'));
    }

    public function render()
    {
        $consultants = consultant::paginate($this->pageNumber);
        return view('livewire.cp.settings.consultants.index',['consultants'=>$consultants]);
    }
}
