<?php

namespace App\Livewire\Cp\Settings\Marketing;

use App\Models\CustomizeFor;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use  WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name, $code, $notes, $pageNumber = 5;
    public  $marketingId;
    public function createMarketing()
    {
        $this->validate([
            'name' => 'required',
            'code' => 'required',
        ]);
        CustomizeFor::create([
            'name' => $this->name,
            'code' => $this->code,
            'notes' => $this->notes
        ]);
        $this->reset(['name', 'code', 'notes']);
        $this->dispatch('message', message: __('Done Save'));
        $this->dispatch('backToMainData');
    }

    public function editMarketing($id)
    {
        $marketing = CustomizeFor::findOrFail($id);
        $this->marketingId = $marketing->id;
        $this->name = $marketing->name;
        $this->code = $marketing->code;
        $this->notes = $marketing->notes;
    }

    public function updateMarketing()
    {
        $this->validate([
            'name' => 'required',
            'code' => 'required',
        ]);
        $marketing = CustomizeFor::findOrFail($this->marketingId);
        $marketing->update([
            'name' => $this->name,
            'code' => $this->code,
            'notes' => $this->notes
        ]);
        $this->reset(['name', 'code', 'notes']);
        $this->dispatch('message', message: __('Done Save'));
        $this->dispatch('backToMainData');
    }
    public function deleteMarketing($id)
    {
        $marketing = CustomizeFor::findOrFail($id);
        $marketing->delete();
        $this->reset(['name', 'code', 'notes']);
        $this->dispatch('message', message: __('Done Delete'));
    }
    public function render()
    {
        $marketings = CustomizeFor::paginate($this->pageNumber);
        return view('livewire.cp.settings.marketing.index',['marketings'=>$marketings]);
    }
}
