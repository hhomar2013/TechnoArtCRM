<?php

namespace App\Livewire\Cp\Settings\General;

use App\Models\mySettings;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Index extends Component
{

    use WithFileUploads;
    public $name;
    public $email;
    public $phone;
    public $logo;
    public $favicon;
    public $mySettings;
    public $old_logo;
    public $old_favicon;
    protected $listeners = ['refresh-general' => '$refresh'];

    public function mount(mySettings $mySettings)
    {
        $mySettings = mysettings::query()->latest()->first();
        $this->mySettings = $mySettings;
        if ($mySettings) {
            $this->name = $mySettings->app_name;
            $this->email = $mySettings->app_email;
            $this->phone = $mySettings->app_phone;
            $this->logo = $mySettings->logo;
            $this->favicon = $mySettings->favicon;
        } else {
            $this->mySettings = [
                'name' => null,
                'app_email' => null,
                'app_phone' => null,
                'app_logo' => null,
                'app_favicon' => null,
            ];
        }
    } //mount

    public function store()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $logo = $this->logo->store('logo', 'public');
        $favicon = $this->favicon->store('favicon', 'public');
        mysettings::create([
            'app_name' => $this->name,
            'app_email' => $this->email,
            'app_phone' => $this->phone,
            'app_logo' => $logo,
            'app_favicon' => $favicon,
        ]);
        $this->dispatch('refresh-general');
        $this->dispatch('message', message: __('Done Save'));
        return redirect()->route('settings');
    } //store

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'currency' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $mySettings = $this->mySettings;

        if ($this->logo) {
            $logo = $this->logo->store('logo', 'public');
            $mySettings->app_logo = $logo;
        }

        if ($this->favicon) {
            $favicon = $this->favicon->store('favicon', 'public');
            $mySettings->app_favicon = $favicon;
        }

        $mySettings->app_name = $this->name;
        $mySettings->app_email = $this->email;
        $mySettings->app_phone = $this->phone;
        $mySettings->save();

        $this->dispatch('refresh-general');
        $this->dispatch('message', message: __('Done Save'));
    } //update

    public function render()
    {
        return view('livewire.cp.settings.general.index');
    }
}
