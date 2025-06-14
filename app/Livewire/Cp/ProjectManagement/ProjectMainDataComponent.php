<?php

namespace App\Livewire\Cp\ProjectManagement;

use App\Models\Banks;
use App\Models\consultant;
use App\Models\CustomizeFor;
use App\Models\developers;
use App\Models\districts;
use App\Models\Goverment;
use App\Models\Owner;
use App\Models\Project;
use App\Models\ProjectData;
use Livewire\Component;

class ProjectMainDataComponent extends Component
{
    public $code, $name, $page, $goverment, $district, $consultant, $owner, $marketing, $bank, $developer, $projectId, $notes, $searchName = '%';
    protected $listeners = ['backToMainData', 'refreshProject' => '$refresh'];
    public $projectData = [];

    public function searchProject()
    {
        $this->projectData = [];
        if ($this->searchName == '%') {
            $this->projectData = ProjectData::get();
        } else {
            $this->projectData = ProjectData::where('id', $this->searchName)->get();
        }
    }
    public function updateCode()
    {
        $project = Project::find($this->name);
        $this->code = $project ? $project->code : '';
    }

    public function backToMainData()
    {
        $this->dispatch('refreshProject');
        $this->page = '';
    }

    public function navigate($page)
    {
        $this->page = $page;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required',
            'goverment' => 'required',
            'district' => 'required',
            'consultant' => 'required',
            'owner' => 'required',
            'marketing' => 'required',
            'bank' => 'required',
            'developer' => 'required'
        ]);

        ProjectData::create([
            'project_id' => $this->name,
            'gov_id' => $this->goverment,
            'district_id' => $this->district,
            'owner_id' => $this->owner,
            'bank_id' => $this->bank,
            'customize_for_id' => $this->marketing,
            'consultant_id' => $this->consultant,
            'developer_id' => $this->developer,
            'notes' => $this->notes,
        ]);

        $this->reset();
        $this->dispatch('message', message: __('Done Save'));
        $this->dispatch('refreshProject');
    }

    public function edit($id)
    {
        $project = ProjectData::findOrFail($id);
        $this->projectId = $id;
        $this->code = $project->project->code;
        $this->name = $project->project_id;
        $this->goverment = $project->gov_id;
        $this->district = $project->district_id;
        $this->consultant = $project->consultant_id;
        $this->owner = $project->owner_id;
        $this->marketing = $project->customize_for_id;
        $this->bank = $project->bank_id;
        $this->developer = $project->developer_id;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'goverment' => 'required',
            'district' => 'required',
            'consultant' => 'required',
            'owner' => 'required',
            'marketing' => 'required',
            'bank' => 'required',
            'developer' => 'required'
        ]);

        $project = ProjectData::find($this->projectId);
        $project->update([
            'project_id' => $this->name,
            'gov_id' => $this->goverment,
            'district_id' => $this->district,
            'owner_id' => $this->owner,
            'bank_id' => $this->bank,
            'customize_for_id' => $this->marketing,
            'consultant_id' => $this->consultant,
            'developer_id' => $this->developer,
            'notes' => $this->notes,
        ]);

        $this->reset();
        $this->dispatch('message', message: __('Done Save'));
        $this->dispatch('refreshProject');
    }

    public function delete($id)
    {
        $project = ProjectData::find($id);
        if ($project) {
            $project->delete();
            $this->dispatch('message', message: __('Done Save'));
            $this->dispatch('refreshProject');
        }
    }

    public function render()
    {
        $projects = Project::all();
        $goverments = Goverment::all();
        $districts = districts::query()->where('gov_id', '=', $this->goverment)->get();
        $consultants = consultant::all();
        $owners = Owner::all();
        $banks = Banks::all();
        $marketings = CustomizeFor::all();
        $developers = developers::all();
        $projectsData = ProjectData::all();
        return view(
            'livewire.cp.project-management.project-main-data-component',
            [
                'projects' => $projects,
                'goverments' => $goverments,
                'districts' => $districts,
                'consultants' => $consultants,
                'owners' => $owners,
                'banks' => $banks,
                'marketings' => $marketings,
                'developers' => $developers,
                'projectsData' => $projectsData,
            ]
        );
    }
}
