<div>
    <div class="col-12 p-4">
        <button class="btn btn-primary btn-rounded" id="printButton" onclick="printDiv()"> <i class="fas fa-print"> </i> {{ __('Print report') }}</button>

    </div>
    <div class="container-fluid" id="printArea">
        <div class="row">

            <div class="col-lg-12">
                <h4><i class="fa fa-home"></i> {{ __('Total of each project') }}</h4>
                <hr>
                <div class="table-responsive" style="overflow-y: auto; height: auto;">
                    <table class="table table-bordered text-dark  text-center">
                        <thead>
                            <tr class=" text-danger bg-light">
                                <th>#</th>
                                <th>{{ __('Customer ID') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Project Name') }}</th>
                                <th>{{ __('Phases') }}</th>
                                <th>{{ __('Area') }}</th>
                                <th>{{ __('Customers Types') }}</th>
                                <th>{{ __('Sales') }}</th>
                                <th>{{ __('Monthly payment') }}</th>
                                <th>{{ __('Total Payments') }}</th>
                                <th>{{ __('Total Costs') }}</th>
                                <th>{{ __('Grand Total') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $i = 1; @endphp
                            @foreach ($totalProjects as $customer)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $customer->code }}</td>
                                <td>{{ $customer->name }}</td>
                                <td>{{ $customer->project_name }}</td>
                                <td>{{ $customer->phase_name }}</td>
                                <td>{{ $customer->area }}</td>
                                <td>{{ $customer->customer_type_name }}</td>
                                <td>{{ $customer->sales_name }}</td>
                                <td>{{ number_format($customer->monthly_payment, 0) }}</td>
                                <td>{{ number_format($customer->total_payments, 0) }}</td>
                                <td>{{ number_format($customer->total_costs, 0) }}</td>
                                <td class="fw-bold">{{ number_format($customer->grand_total, 0) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-12">
                <h3><b class="text-dark">
                        <i class="fa-solid fa-building"></i>
                        {{ __('Total Reservations') }} :
                        {{ number_format($totalProjects->count(), 0) }}
                    </b></h3>
                <hr>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12">
                <h3><b class="text-danger">{{ __('Total installments') }} :
                        {{ number_format($total_payment_pending, 2) }}
                        جنيه</b></h3><br>
                <h3><b class="text-danger">{{ __('Total installment paid') }} :
                        {{ number_format($total_payment_paid, 2) }}
                        جنيه</b></h3><br>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12">
                <h3><b class="text-primary">{{ __('Total Costs') }} :
                        {{ number_format($total_cost_pending, 2) }}جنيه</b></h3><br>
                <h3><b class="text-primary">{{ __('Total Costs Paid') }} :
                        {{ number_format($total_cost_paid, 2) }}جنيه</b></h3><br></h3>

            </div>

            <div class="col-lg-12">
                <hr>
                <h3><b class="text-dark">{{ __('Grand Total') }} :
                        {{ number_format($total_cost_paid + $total_payment_pending, 2) }}جنيه</b></h3><br></h3>

            </div>

        </div>
    </div>

</div>
@section('title', __('Total of each project'))
<script>
    function printDiv() {
        var printContents = document.getElementById('printArea').innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
        location.reload(); // يعيد تحميل الصفحة بعد الطباعة
    }

</script>
