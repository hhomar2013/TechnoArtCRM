<?php

namespace App\Livewire\Cp\ProjectManagement;

use App\Models\phases;
use App\Models\Project;
use App\Models\ProjectPhase;
use Livewire\Component;

class ProjectPhaseComponent extends Component
{
    public $code,$name,$phase,$page,$pageNumber = 5 ,$phaseId;
    public $project_phases = [];
    protected $listeners = ['backToPphase', 'refreshProject' => '$refresh'];

    public function backToPphase()
    {
        $this->dispatch('refreshProject');
        $this->page = '';
    }
    public function navigate($page)
    {
        $this->page = $page;
    }
    public function mount(){

    }

    public function updateCode()
    {
        $project = Project::find($this->name);
        $this->code = $project ? $project->code : '';

    }

    public function save()
    {
        $this->validate([
            'name'=>'required',
            'phase'=>'required',
        ]);
        ProjectPhase::create([
            'project_id'=>$this->name,
            'phase_id'=>$this->phase,
        ]);
        $this->dispatch('message', message: __('Done Save'));
        $this->reset(['phase']);
    }

    public function edit($id)
    {
        $projectPhase = ProjectPhase::findOrFail($id);
        $this->phaseId = $projectPhase->id;
        $this->name = $projectPhase->project_id;
        $this->phase = $projectPhase->phase_id;
    }

public function update()
{

    $this->validate([
        'name' => 'required',
        'phase' => 'required',
    ]);

    $projectPhase = ProjectPhase::findOrFail($this->phaseId);

    if ($projectPhase) {
        $projectPhase->update([
            'project_id' => $this->name,
            'phase_id' => $this->phase,
        ]);

        $this->dispatch('message', message: __('Done Update'));
        $this->reset(['phase','phaseId']);
    }
}


    public function delete($id)
    {
        ProjectPhase::findOrFail($id)->delete();
        $this->dispatch('message', message: __('Done Delete'));
    }

    public function render()
    {
        $this->project_phases = [];
        $this->project_phases = ProjectPhase::query()->where('project_id',$this->name)->get();
        $projects = Project::all();
        $phases = phases::all();
        return view('livewire.cp.project-management.project-phase-component',
        [
            'projects'=>$projects,
            'phases'=>$phases,
        ]);
    }
}
