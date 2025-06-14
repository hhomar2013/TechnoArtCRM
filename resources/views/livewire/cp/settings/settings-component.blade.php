<div>
    @section('title')
        {{ __('Settings') }}
    @endsection
    <div class="row">
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <div class="list-group list-group-flush pb-1">
                        <a href="#"
                            class="list-group-item list-group-item-action rounded {{ $navigate == 'general' ? 'active' : '' }}"
                            wire:click.prevent="navigateTo('general')">
                            <i class="fa-solid fa-earth-asia"></i>
                            &nbsp; <span class="nav-text">{{ __('General Settings') }}</span>
                        </a>
                        @can('usersManagement')
                            <a href="#"
                                class="list-group-item list-group-item-action rounded {{ $navigate == 'users' ? 'active' : '' }}"
                                wire:click.prevent="navigateTo('users')">
                                <i
                                    class="{{ $navigate == 'users' ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle' }}"></i>
                                &nbsp; <span class="nav-text">{{ __('users') }}</span>
                            </a>
                        @endcan
                        <a href="#"
                            class="list-group-item list-group-item-action rounded {{ $navigate == 'roles' ? 'active' : '' }}"
                            wire:click.prevent="navigateTo('roles')">
                            <i
                                class="{{ $navigate == 'roles' ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle' }}"></i>
                            &nbsp; <span class="nav-text">{{ __('Role') }}</span>
                        </a>

                        <a href="#"
                            class="list-group-item list-group-item-action rounded {{ $navigate == 'permissions' ? 'active' : '' }}"
                            wire:click.prevent="navigateTo('permissions')">
                            <i
                                class="{{ $navigate == 'permissions' ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle' }}"></i>
                            &nbsp; <span class="nav-text">{{ __('Permissions') }}</span>
                        </a>
                        <a href="#"
                            class="list-group-item list-group-item-action rounded {{ $navigate == 'projects' ? 'active' : '' }}"
                            wire:click.prevent="navigateTo('projects')">
                            <i
                                class="{{ $navigate == 'projects' ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle' }}"></i>
                            &nbsp; <span class="nav-text">{{ __('Projects') }}</span>
                        </a>
                        <a href="#"
                            class="list-group-item list-group-item-action rounded {{ $navigate == 'goverments' ? 'active' : '' }}"
                            wire:click.prevent="navigateTo('goverments')">
                            <i
                                class="{{ $navigate == 'goverments' ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle' }}"></i>
                            &nbsp; <span class="nav-text">{{ __('Goverments Management') }}</span>
                        </a>
                        <a href="#"
                            class="list-group-item list-group-item-action rounded {{ $navigate == 'districts' ? 'active' : '' }}"
                            wire:click.prevent="navigateTo('districts')">
                            <i
                                class="{{ $navigate == 'districts' ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle' }}"></i>
                            &nbsp; <span class="nav-text">{{ __('Districts Management') }}</span>
                        </a>

                        <a href="#"
                            class="list-group-item list-group-item-action rounded {{ $navigate == 'owners' ? 'active' : '' }}"
                            wire:click.prevent="navigateTo('owners')">
                            <i
                                class="{{ $navigate == 'owners' ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle' }}"></i>
                            &nbsp; <span class="nav-text">{{ __('Owner Management') }}</span>
                        </a>

                        <a href="#"
                            class="list-group-item list-group-item-action rounded {{ $navigate == 'banks' ? 'active' : '' }}"
                            wire:click.prevent="navigateTo('banks')">
                            <i
                                class="{{ $navigate == 'banks' ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle' }}"></i>
                            &nbsp; <span class="nav-text">{{ __('Banks Management') }}</span>
                        </a>


                        <a href="#"
                            class="list-group-item list-group-item-action rounded {{ $navigate == 'marketing' ? 'active' : '' }}"
                            wire:click.prevent="navigateTo('marketing')">
                            <i
                                class="{{ $navigate == 'marketing' ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle' }}"></i>
                            &nbsp; <span class="nav-text">{{ __('Marketing Companies Management') }}</span>
                        </a>

                        <a href="#"
                            class="list-group-item list-group-item-action rounded {{ $navigate == 'developers' ? 'active' : '' }}"
                            wire:click.prevent="navigateTo('developers')">
                            <i
                                class="{{ $navigate == 'developers' ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle' }}"></i>
                            &nbsp; <span class="nav-text">{{ __('Developers Management') }}</span>
                        </a>

                        <a href="#"
                            class="list-group-item list-group-item-action rounded {{ $navigate == 'consultant' ? 'active' : '' }}"
                            wire:click.prevent="navigateTo('consultant')">
                            <i
                                class="{{ $navigate == 'consultant' ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle' }}"></i>
                            &nbsp; <span class="nav-text">{{ __('Consultant Management') }}</span>
                        </a>

                        <a href="#"
                        class="list-group-item list-group-item-action rounded {{ $navigate == 'phase' ? 'active' : '' }}"
                        wire:click.prevent="navigateTo('phase')">
                        <i
                            class="{{ $navigate == 'phase' ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle' }}"></i>
                        &nbsp; <span class="nav-text">{{ __('Phase Management') }}</span>
                    </a>


                    </div>
                </div>
            </div>
        </div>

        <div class="col-9">

            @switch($navigate)
                @case('users')
                    @livewire('cp.settings.users.index')
                @break

                @case('permissions')
                    @livewire('cp.settings.users.permissions')
                @break

                @case('roles')
                    @livewire('cp.settings.users.roles')
                @break

                @case('general')
                    @livewire('cp.settings.general.index')
                @break

                @case('projects')
                    @livewire('cp.settings.project.index')
                @break

                @case('goverments')
                    @livewire('cp.settings.goverments.index')
                @break

                @case('districts')
                    @livewire('cp.settings.districts.index')
                @break

                @case('owners')
                    @livewire('cp.settings.owners.index')
                @break

                @case('marketing')
                    @livewire('cp.settings.marketing.index')
                @break

                @case('developers')
                    @livewire('cp.settings.developers.index')
                @break

                @case('banks')
                    @livewire('cp.settings.banks.index')
                @break

                @case('consultant')
                    @livewire('cp.settings.consultants.index')
                @break

                @case('phase')
                    @livewire('cp.settings.phases.index')
                @break

                @default
            @endswitch
        </div>
    </div>
</div>
@script
    @include('tools.message')
@endscript
@script
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('update-url', (navigate) => {
                history.pushState(null, '', `?navigate=${navigate.navigate}`);
            });
        });
    </script>
@endscript
