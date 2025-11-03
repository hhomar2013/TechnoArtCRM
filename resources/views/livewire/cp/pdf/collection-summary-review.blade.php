<div>
    <div class="col-12 p-4">
        <button class="btn btn-primary btn-rounded" id="printButton" onclick="printDiv()"> <i class="fas fa-print"> </i> {{ __('Print report') }}</button>
    </div>
    <div class="card text-dark p-4" id="printArea">
        <div class="card-header">
            <h3>
                {{ __('Summary of the next monthly collections') }}
            </h3>
            @include('tools.spinner')
        </div>
        <div class="card-body">
            <div class="table-responsive" style="overflow-y: auto; height: auto;">
                <table class="table table-bordered text-dark  text-start" style="font-weight: bold; font-size: 17px;">
                    <thead>
                        <tr class=" text-danger bg-light">
                            <th style="font-weight: bold; font-size: 17px;">#</th>
                            <th style="font-weight: bold; font-size: 17px;">{{ __('Customer Name') }}</th>
                            <th style="font-weight: bold; font-size: 17px;">{{ __('type') }}</th>
                            <th style="font-weight: bold; font-size: 17px;">{{ __('Amount') }}</th>
                            <th style="font-weight: bold; font-size: 17px;">{{ __('t.date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" class="text-center text-danger" style="background-color: rgb(171, 177, 202);"><b>{{ __('Installments') }}</b></td>
                        </tr>
                        @foreach ($payments as $payment)
                        @php
                        $customers = json_decode($payment->installmentPlan->customers, true);
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if(!empty($customers))
                                {{ $customers[0]['name'] ?? '-' }}
                                @else
                                -
                                @endif
                            </td>
                            <td>{{ __('Installment') }}</td>
                            <td>{{ number_format($payment->amount, 2) }}</td>
                            <td>{{ $payment->due_date }}</td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="5" class="text-center text-danger" style="background-color: rgb(171, 177, 202);"><b>{{ __('Costs') }}</b></td>
                        </tr>
                        @foreach ($costInstallments as $costInstallment)
                        @php
                        $customers = json_decode($costInstallment->installmentPlan->customers, true);
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if(!empty($customers))
                                {{ $customers[0]['name'] ?? '-' }}
                                @else
                                -
                                @endif
                            </td>
                            <td>{{$costInstallment->costs->name }}</td>
                            <td>{{ number_format($costInstallment->value, 2) }}</td>
                            <td>{{ $costInstallment->date }}</td>
                        </tr>


                        @endforeach
                        {{-- <tr></tr> --}}
                    </tbody>
                </table>

            </div>


        </div>
        <div class="card-footer">
            @if ($costInstallments || $payments)
            <div class="row">
                <div class="col-lg-6">
                    <h2><b class="text-danger">{{ __('Total Costs') }} : {{ number_format($costInstallments->sum('value'), 2) }} جنيه</b></h2> <br>
                    <h3><b class="text-primary">{{ __('Count') }} : {{ $costInstallments->count() }}</b></h3>
                </div>
                <div class="col-lg-6">
                    <h2><b class="text-danger">{{ __('Total installments') }} : {{ number_format($payments->sum('amount'), 2) }} جنيه</b></h2><br>
                    <h3><b class="text-primary">{{ __('Count') }} : {{ $payments->count() }}</b></h3>
                </div>

            </div>
            @endif

        </div>
    </div>
</div>

@section('title', __('Collection Summary'))
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
