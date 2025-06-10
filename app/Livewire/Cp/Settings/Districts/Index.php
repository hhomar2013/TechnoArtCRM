<?php

namespace App\Livewire\Cp\Settings\Districts;

use App\Models\districts;
use App\Models\Goverment;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use  WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name, $code, $notes, $pageNumber = 5 ,$goverment;
    public $districtstId;

    public function createDistricts()
    {

        $this->validate([
            'name' => 'required',
            'code' => 'required',
            'goverment'=>'required'
        ]);
        districts::create([
            'name' => $this->name,
            'code' => $this->code,
            'notes' => $this->notes,
            'gov_id' => $this->goverment,
        ]);
        $this->dispatch('message', message: __('Done Save'));
        $this->reset();
    }

    public function editDistricts($id)
    {
        $districts = districts::findOrFail($id);
        $this->districtstId = $districts->id;
        $this->name = $districts->name;
        $this->code = $districts->code;
        $this->notes = $districts->notes;
        $this->goverment = $districts->gov_id;
    }

    public function updateDistricts()
    {
        $this->validate([
            'name' => 'required',
            'code' => 'required',
            'goverment'=>'required'
        ]);
        districts::find($this->districtstId)->update([
            'name' => $this->name,
            'code' => $this->code,
            'notes' => $this->notes,
            'gov_id' => $this->goverment,
        ]);
        $this->dispatch('message', message: __('Done Save'));
        $this->reset();
    }

    public function deleteDistricts($id)
    {
        districts::findOrFail($id)->delete();
        $this->dispatch('message', message: __('Done Delete'));
        $this->reset();
    }

    public function render()
    {
        $goverments = Goverment::query()->get();
        $districts = districts::with('governement')->paginate($this->pageNumber);
        return view('livewire.cp.settings.districts.index', ['districts' => $districts , 'goverments' =>$goverments]);
    }
}
