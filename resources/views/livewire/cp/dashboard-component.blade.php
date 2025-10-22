<div>
    @section('title')
            {{ __('Dashboard') }}
    @endsection
        @include('tools.page_header')

        <div class="row" >
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="stat-icon d-inline-block">
                            <i class="ti-home text-dark border-dark"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">{{ __('Total Projects') }}</div>
                            <div class="stat-digit" >{{ $projects }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="stat-icon d-inline-block">
                            <i class="ti-user text-primary border-primary"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">{{ __('Total Customers') }}</div>
                            <div class="stat-digit">{{ $customers }}</div>
                        </div>
                    </div>
                </div>
            </div>

       
</div>

@script
    <script>
    $wire.on('message' , (event)=>{
        Swal.fire({
            position: "top-start",
            icon: "success",
            title: event.message,
            showConfirmButton: false,
            timer: 1500
            });
    });
    </script>
@endscript

