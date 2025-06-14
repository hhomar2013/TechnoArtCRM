<?php

namespace App\Livewire\Cp\Settings\Developers;

use App\Models\developers;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use  WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name, $code, $notes, $pageNumber = 5;
    public  $developersId;
    public function createDevelopers()
    {
        $this->validate([
            'name' => 'required',
            'code' => 'required',
        ]);
        developers::create([
            'name' => $this->name,
            'code' => $this->code,
            'notes' => $this->notes
        ]);
        $this->reset(['name', 'code', 'notes']);
        $this->dispatch('message', message: __('Done Save'));
    }

    public function editDevelopers($id)
    {
        $developers = developers::findOrFail($id);
        $this->developersId = $developers->id;
        $this->name = $developers->name;
        $this->code = $developers->code;
        $this->notes = $developers->notes;
    }

    public function updateDevelopers()
    {
        $this->validate([
            'name' => 'required',
            'code' => 'required',
        ]);
        $developers = developers::findOrFail($this->developersId);
        $developers->update([
            'name' => $this->name,
            'code' => $this->code,
            'notes' => $this->notes
        ]);
        $this->reset(['name', 'code', 'notes']);
        $this->dispatch('message', message: __('Done Save'));
    }
    public function deleteDevelopers($id)
    {
        $Developers = developers::findOrFail($id);
        $Developers->delete();
        $this->reset(['name', 'code', 'notes']);
        $this->dispatch('message', message: __('Done Delete'));
    }
    public function render()
    {
        $developers = developers::paginate($this->pageNumber);
        return view('livewire.cp.settings.developers.index', ['developers' => $developers]);
    }
}
