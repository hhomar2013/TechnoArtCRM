<div>
    <div class="container-fluid text-dark" style="font-weight: bold">
        <div class="col-12">
                      <button class="btn btn-primary" id="printButton" onclick="printDiv()">طباعة</button>

        </div>
        <div class="card shadow-lg p-3"  id="printArea">
            <div class="p-2">
                <br>
                <h3 class="">
                    {{-- <i class="fa fa-user"></i> --}}
                    <b>{{ __('Name') }}</b>&nbsp;:&nbsp;
                    {{ $header->customer_name }}
                </h3>
                <h4 class=""><b>{{ __('Customer ID') }}</b>&nbsp;:&nbsp;{{ $header->code }}</h4>
                <p class=""> <b>{{ __('Project Name') }}</b> : {{ $header->project_name }}</p>
                <p class=""><b>{{ __('Phase Name') }}</b> : {{ $header->phase_name }}</p>
            </div>
            <div class="card-body">
                <br>
                <div class="row">
                    <div class="col-12">
                        <h3>{{ __('Costs') }}</h3>
                        <table class="table table-bordered text-dark">
                            <thead>
                                <tr>
                                    <th style="font-weight: bold;font-size: 18px">{{ __('type') }}</th>
                                    <th style="font-weight: bold;font-size: 18px">{{ __('Amount') }}</th>
                                    <th style="font-weight: bold;font-size: 18px">{{ __('status') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($costs as $cost)
                                    <tr>
                                        <td>{{ $cost->cost_name }}</td>
                                        <td>{{ $cost->value }}</td>
                                        @if ($cost->status == 'pending')
                                            <td>{{ __('pending') }}</td>
                                        @else
                                            <td>{{ __('Paid') }}</td>
                                    <tr>
                                        <td>
                                            <h4> بيان التحصيل</h4>
                                            <hr>
                                            <h6>البنك : {{ $cost->banke_name }}</h6>
                                            <h6>رقم الإيصال : {{ $cost->transaction_id }}</h6>
                                            <h6>التاريخ : {{ $cost->transaction_date }}</h6>
                                            <h6>الوقت : {{ $cost->time }}</h5>
                                        </td>

                                    </tr>
                                @endif

                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12">
                        <h3>{{ __('Installments') }}</h3>
                        {{-- <table class="table table-bordered text-dark">
                                <thead>
                                    <tr>
                                        <th>{{ __('#') }}</th>
                                        <th>{{ __('Amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($installments as $installment)
                                    <tr>
                                        <td>{{ $installment->installment_number }}</td>
                                        <td>{{ $installment->amount }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table> --}}
                    </div>
                </div>
            </div>

        </div>
    </div>


</div>
@section('title', __('Customers'))


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
