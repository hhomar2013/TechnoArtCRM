<div class="row">
    <div class="col">
        <h5 class="card-title text-uppercase p-2">
            {{ $pageTitleNew}}
        </h5>
    </div>
    <div class="col text-center">
        @include('tools.spinner')
    </div>
    <div class="col text-right text-dark">
        <button class="btn btn-primary btn-rounded text-white" wire:click="$set('add',true)">
           <i class="fa fa-plus"></i> {{ __('Add New') }}
        </button>
    </div>
</div>

    <div class="input-group p-2">
        <div class="input-group-append">
            <select class="form-control" wire:model="numbers" wire:change="paginateNumber">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="30">30</option>
                <option value="50">50</option>
                <option value="100000000000">{{ __('Select all') }}</option>
            </select>
        </div>

        {{-- <div class="col-md-6 ">
            <div class="input-group-append">
                <span class="input-group-text bg-dark text-white"><i class="fa fa-search"></i></span>
                <input type="text" name="" id="search" class="form-control" wire:model.live="search"/>

            </div>
        </div> --}}
        <!--End of search  -->

    </div>
<hr>
