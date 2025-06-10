<?php

namespace App\Livewire\Cp\Settings\Goverments;

use App\Models\Goverment;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use  WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name, $code, $notes, $pageNumber = 5;
    public $govermentId;

    public function createGoverment()
    {

        $this->validate([
            'name' =>'required',
            'code' =>'required',

        ]);
        Goverment::create([
            'name' => $this->name,
            'code' => $this->code,
            'notes' => $this->notes,
        ]);
        $this->dispatch('message', message: __('Done Save'));
        $this->reset();
    }

    public function editGoverment($id)
    {
        $goverment = Goverment::findOrFail($id);
        $this->govermentId = $goverment->id;
        $this->name = $goverment->name;
        $this->code = $goverment->code;
        $this->notes = $goverment->notes;
    }

    public function updateGoverment()
    {
        $this->validate([
            'name' =>'required',
            'code' =>'required',
        ]);
        Goverment::find($this->govermentId)->update([
            'name' => $this->name,
            'code' => $this->code,
            'notes' => $this->notes,
        ]);
        $this->dispatch('message', message: __('Done Save'));
        $this->reset();
    }

    public function deleteGoverment($id)
    {
        Goverment::findOrFail($id)->delete();
        $this->dispatch('message', message: __('Done Delete'));
        $this->reset();
    }

    public function render()
    {
        $goverments = Goverment::paginate($this->pageNumber);
        return view(
            'livewire.cp.settings.goverments.index',
            ['goverments' => $goverments]
        );
    }
}
