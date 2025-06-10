
@isset($action)
<div wire:loading wire:target="{{ $action ?? '' }}">
    <div class="spinner-border" role="status">
        <span class="sr-only">Loading...</span>
      </div>
  </div>

  @else
    <div wire:loading>
        <div class="spinner-border" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
@endisset
