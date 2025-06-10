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
                            <i class="ti-shopping-cart-full text-dark border-dark"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">{{ __('Stores') }}</div>
                            <div class="stat-digit" >100</div>
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
                            <div class="stat-text">{{ __('Vendors') }}</div>
                            <div class="stat-digit">100</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="stat-icon d-inline-block">
                            <i class="ti-layout-grid2 text-pink border-pink"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">{{ __('Products') }}</div>
                            <div class="stat-digit">100</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="stat-icon d-inline-block">
                            <i class="ti-ticket text-success border-success"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">{{ __('Coupons') }}</div>
                            <div class="stat-digit">100</div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-lg-3 col-sm-6">
                <div class="card">
                    <div class="stat-widget-one card-body">
                        <div class="stat-icon d-inline-block">
                            <i class="ti-gift text-info border-info"></i>
                        </div>
                        <div class="stat-content d-inline-block">
                            <div class="stat-text">{{ __('Offers') }}</div>
                            <div class="stat-digit">100</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    {{-- Start Table --}}
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Bordered Table</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered verticle-middle table-responsive-sm text-dark">
                    <thead>
                        <tr>
                            <th scope="col">Task</th>
                            <th scope="col">Progress</th>
                            <th scope="col">Deadline</th>
                            <th scope="col">Label</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Air Conditioner</td>
                            <td>
                                <div class="progress" style="background: rgba(127, 99, 244, .1)">
                                    <div class="progress-bar bg-primary" style="width: 70%;" role="progressbar"><span class="sr-only">70% Complete</span>
                                    </div>
                                </div>
                            </td>
                            <td>Apr 20,2018</td>
                            <td><span class="badge badge-primary">70%</span>
                            </td>
                            <td>
                                <span>
                                    <a href="javascript:void()" class="mr-4" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i> </a>
                                    <a href="javascript:void()" data-toggle="tooltip" data-placement="top" title="Close"><i class="fa fa-close color-danger"></i></a>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>Textiles</td>
                            <td>
                                <div class="progress" style="background: rgba(76, 175, 80, .1)">
                                    <div class="progress-bar bg-success" style="width: 70%;" role="progressbar"><span class="sr-only">70% Complete</span>
                                    </div>
                                </div>
                            </td>
                            <td>May 27,2018</td>
                            <td><span class="badge badge-success">70%</span>
                            </td>
                            <td><span><a href="javascript:void()" class="mr-4" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i> </a><a href="javascript:void()" data-toggle="tooltip" data-placement="top" title="Close"><i class="fa fa-close color-danger"></i></a></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Milk Powder</td>
                            <td>
                                <div class="progress" style="background: rgba(70, 74, 83, .1)">
                                    <div class="progress-bar bg-dark" style="width: 70%;" role="progressbar"><span class="sr-only">70% Complete</span>
                                    </div>
                                </div>
                            </td>
                            <td>May 18,2018</td>
                            <td><span class="badge badge-dark">70%</span>
                            </td>
                            <td><span><a href="javascript:void()" class="mr-4" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i> </a><a href="javascript:void()" data-toggle="tooltip" data-placement="top" title="Close"><i class="fa fa-close color-danger"></i></a></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Vehicles</td>
                            <td>
                                <div class="progress" style="background: rgba(255, 87, 34, .1)">
                                    <div class="progress-bar bg-danger" style="width: 70%;" role="progressbar"><span class="sr-only">70% Complete</span>
                                    </div>
                                </div>
                            </td>
                            <td>Mar 27,2018</td>
                            <td><span class="badge badge-danger">70%</span>
                            </td>
                            <td><span><a href="javascript:void()" class="mr-4" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i> </a><a href="javascript:void()" data-toggle="tooltip" data-placement="top" title="Close"><i class="fa fa-close color-danger"></i></a></span>
                            </td>
                        </tr>
                        <tr>
                            <td>Boats</td>
                            <td>
                                <div class="progress" style="background: rgba(255, 193, 7, .1)">
                                    <div class="progress-bar bg-warning" style="width: 70%;" role="progressbar"><span class="sr-only">70% Complete</span>
                                    </div>
                                </div>
                            </td>
                            <td>Jun 28,2018</td>
                            <td><span class="badge badge-warning">70%</span>
                            </td>
                            <td><span><a href="javascript:void()" class="mr-4" data-toggle="tooltip" data-placement="top" title="Edit"><i class="fa fa-pencil color-muted"></i> </a><a href="javascript:void()" data-toggle="tooltip" data-placement="top" title="Close"><i class="fa fa-close color-danger"></i></a></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{-- End Table --}}
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

