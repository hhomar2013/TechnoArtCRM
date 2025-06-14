@section('title', __('Project Main Data'))
<div>
<div class="card">
    <div class="card-header">
        <h3>{{ __('Project Main Data') }}</h3>
        <div class="text-center">
            @include('tools.spinner')
        </div>
        <div class="btn-group">
            @foreach ($ListAction as $key => $value )
            <label for="{{ $key }}" class="btn btn-primary {{ $navigate === $key ? 'btn-danger' : '' }}">{{ __($value) }}</label>
            <input type="radio" name="{{ $key }}"  id="{{ $key }}"
             wire:model="navigate"
              {{-- wire:click.prevent="$set('action_btn', '{{ $key }}')" --}}
              wire:click.prevent="navigateTo('{{ $key }}')"
              hidden/>
            @endforeach
        </div>
    </div>
    <div class="card-body">
      @if($navigate === 'main')
      @livewire('cp.project-management.project-main-data-component')
      @elseif($navigate === 'phase')
      @livewire('cp.project-management.project-phase-component')
      @endif
    </div>

</div>
</div>

@script

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('update-url', (navigate) => {
                history.pushState(null, '', `?navigate=${navigate.navigate}`);
            });
        });
    </script>
@endscript
