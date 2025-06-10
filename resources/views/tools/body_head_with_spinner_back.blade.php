<div class="row">
    <div class="col text-left">
        <h5 class="card-title">
            {{ $pageTiltleBack }}
        </h5>
    </div>
    <div class="col text-center">
        @include('tools.spinner')
    </div>
    <div class="col text-right">
        <button wire:click="$set('add',false)" class="btn btn-danger btn-rounded text-white">
            {{__('Back')}}
            <i class="fa fa-arrow-left"></i>
        </button>
    </div>
</div>
<hr>
