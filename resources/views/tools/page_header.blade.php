<div class="row page-titles mx-0">
    <div class="col-sm-6 p-md-0">
        <div class="welcome-text">
            <?php
                $date = Carbon\Carbon::now()->format('a');
            ?>
            @if($date == 'am')
            <h3 class="text-primary">{{ __('Good Mornign') }}&nbsp;{{ Auth::user()->name }}</h3>
            @else
            <h3 class="text-primary">{{ __('Good Afternoon') }}&nbsp;{{ Auth::user()->name }}</h3>
            @endif

            {{-- <p class="mb-0 text-danger" wire:poll.1s><b>{{ Carbon\Carbon::now() }}</b></p> --}}
        </div>
    </div>
    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="javascript:void(0)">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">{{ __('Home') }}</a></li>
        </ol>
    </div>
</div>
