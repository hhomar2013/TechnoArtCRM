<?php

namespace App\Livewire\Cp\Settings\Owners;

use App\Models\Owner;
use Livewire\Component;
use Livewire\WithPagination;
class Index extends Component
{
    use  WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name, $code, $notes, $pageNumber = 5;
    public  $ownersId;
    public function createOwners()
    {
        $this->validate([
            'name' => 'required',
            'code' => 'required',
        ]);
        Owner::create([
            'name' => $this->name,
            'code' => $this->code,
            'notes' => $this->notes
        ]);
        $this->reset(['name', 'code', 'notes']);
        $this->dispatch('message', message: __('Done Save'));
    }

    public function editOwners($id)
    {
        $owners = Owner::findOrFail($id);
        $this->ownersId = $owners->id;
        $this->name = $owners->name;
        $this->code = $owners->code;
        $this->notes = $owners->notes;
    }

    public function updateOwners()
    {
        $this->validate([
            'name' => 'required',
            'code' => 'required',
        ]);
        $owners = Owner::findOrFail($this->ownersId);
        $owners->update([
            'name' => $this->name,
            'code' => $this->code,
            'notes' => $this->notes
        ]);
        $this->reset(['name', 'code', 'notes']);
        $this->dispatch('message', message: __('Done Save'));
    }
    public function deleteOwners($id)
    {
        $owners = Owner::findOrFail($id);
        $owners->delete();
        $this->reset(['name', 'code', 'notes']);
        $this->dispatch('message', message: __('Done Delete'));
    }
    public function render()
    {
        $Owners = Owner::paginate($this->pageNumber);
        return view('livewire.cp.settings.owners.index', ['owners' => $Owners]);
    }
}
