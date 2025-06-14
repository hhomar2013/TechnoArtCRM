<?php

namespace App\Livewire\Cp\Settings\Phases;

use App\Models\phases;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use  WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name, $code, $notes, $pageNumber = 5;
    public  $phaseId;

    public function createPhase()
    {
        $this->validate([
            'name' => 'required',
            'code' => 'required',
        ]);
        phases::create([
            'name' => $this->name,
            'code' => $this->code,
            'notes' => $this->notes
        ]);
        $this->dispatch('backToMainData');
        $this->dispatch('backToPphase');
        $this->reset(['name', 'code', 'notes']);
        $this->dispatch('message', message: __('Done Save'));
    }

    public function editPhase($id)
    {
        $Phases = phases::findOrFail($id);
        $this->phaseId = $Phases->id;
        $this->name = $Phases->name;
        $this->code = $Phases->code;
        $this->notes = $Phases->notes;
    }

    public function updatePhase()
    {
        $this->validate([
            'name' => 'required',
            'code' => 'required',
        ]);
        $Phases = phases::findOrFail($this->phaseId);
        $Phases->update([
            'name' => $this->name,
            'code' => $this->code,
            'notes' => $this->notes
        ]);
        $this->dispatch('backToMainData');
        $this->dispatch('backToPphase');
        $this->reset(['name', 'code', 'notes']);
        $this->dispatch('message', message: __('Done Save'));
    }
    public function deletePhases($id)
    {
        $Phases = phases::findOrFail($id);
        $Phases->delete();
        $this->dispatch('backToMainData');
        $this->dispatch('backToPphase');
        $this->reset(['name', 'code', 'notes']);
        $this->dispatch('message', message: __('Done Delete'));
    }

    public function render()
    {
        $phases = phases::query()->paginate($this->pageNumber);
        return view('livewire.cp.settings.phases.index',['phases'=>$phases]);
    }
}
