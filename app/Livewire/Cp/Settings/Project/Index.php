<?php

namespace App\Livewire\Cp\Settings\Project;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use  WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $name, $code, $notes, $pageNumber = 5;
    public  $projectId;
    public function createProject()
    {
        $this->validate([
            'name' => 'required',
            'code' => 'required',
        ]);
        Project::create([
            'name' => $this->name,
            'code' => $this->code,
            'notes' => $this->notes
        ]);
        $this->dispatch('backToMainData');
        $this->reset(['name', 'code', 'notes']);
        $this->dispatch('message', message: __('Done Save'));
    }

    public function editProject($id)
    {
        $project = Project::findOrFail($id);
        $this->projectId = $project->id;
        $this->name = $project->name;
        $this->code = $project->code;
        $this->notes = $project->notes;
    }


    public function updateProject()
    {
        $this->validate([
            'name' => 'required',
            'code' => 'required',
        ]);
        $project = Project::findOrFail($this->projectId);
        $project->update([
            'name' => $this->name,
            'code' => $this->code,
            'notes' => $this->notes
        ]);
        $this->dispatch('backToMainData');
        $this->reset(['name', 'code', 'notes']);
        $this->dispatch('message', message: __('Done Save'));
    }
    public function deleteProject($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        $this->reset(['name', 'code', 'notes']);
        $this->dispatch('message', message: __('Done Delete'));
    }
    public function render()
    {
        $projects = Project::paginate($this->pageNumber);
        return view('livewire.cp.settings.project.index', ['projects' => $projects]);
    }
}
