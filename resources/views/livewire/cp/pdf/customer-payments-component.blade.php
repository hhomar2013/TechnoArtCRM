<div>
    <div class="col-12 p-4">
        <button class="btn btn-primary" id="printButton" onclick="printDiv()">طباعة</button>
        <hr>
    </div>
    <div class="container-fluid text-dark" style="font-weight: bold">

        <div class="card shadow-lg p-3" id="printArea">
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
                <br>
                <p><b>عدد الأقساط</b> : {{ $payments->count() }}</p>
                <p><b>قيمة القسط</b> : {{ $payments->last()->amount }}</p>

            </div>
            <div class="card-body">
                <br>
                {{-- Start Costs --}}
                <div class="row">
                    <div class="col-lg-6 col-sm-8">
                        <h3>{{ __('Costs') }}</h3>
                        <table class="table table-bordered text-dark  text-center" style="border: 3px solid black;">
                            <thead style="border: 3px solid black;">
                                <tr style="border: 3px solid black;">
                                    <th style="font-weight: bold;font-size: 18px; border: 3px solid black;">
                                        {{ __('t.date') }}</th>
                                    <th style="font-weight: bold;font-size: 18px; border: 3px solid black;">
                                        {{ __('Statement') }}</th>
                                    <th style="font-weight: bold;font-size: 18px; border: 3px solid black;">
                                        {{ __('bank') }}</th>
                                    <th style="font-weight: bold;font-size: 18px; border: 3px solid black;">
                                        {{ __('Time') }}</th>
                                    <th style="font-weight: bold;font-size: 18px; border: 3px solid black;">
                                        {{ __('Amount') }}</th>
                                    <th style="font-weight: bold;font-size: 18px; border: 3px solid black;">
                                        {{ __('Receipt Date') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($costs as $cost)
                                    @if ($cost->status == 'partiallycollected')
                                        @php
                                            $remaing_costs = $cost->value - $cost->remaining;
                                            $cost->value = $cost->value - $cost->remaining;
                                            $total_costs += $remaing_costs;
                                        @endphp
                                    @elseif($cost->status == 'paid')
                                        @php
                                            $total_costs += $cost->value;
                                        @endphp
                                    @endif

                                    <tr style="border: 3px solid black;">
                                        <td style="border: 3px solid black;">{{ str_replace('-', '/', $cost->date) }}
                                        </td>
                                        <td style="border: 3px solid black;">{{ $cost->cost_name }}</td>
                                        <td style="border: 3px solid black;">{{ $cost->banke_name }}</td>
                                        <td style="border: 3px solid black;">{{ $cost->time }}</td>
                                        <td style="border: 3px solid black;">{{ number_format($cost->value, 1) }}
                                            {{ $cost->status == 'partiallycollected' ? '(محصل جزئيا)' : null }}</td>
                                        <td style="border: 3px solid black;">
                                            {{ str_replace('-', '/', $cost->transaction_date) }}</td>
                                    </tr>
                                @endforeach
                                <tr style="border: 3px solid black;">
                                    <td colspan="4" class="text-center" style="border: 3px solid black;">
                                        <b>{{ __('Total Costs Paid') }}</b>
                                    </td>
                                    <td style="border: 3px solid black;">
                                        {{ number_format($total_costs, 1) }}
                                        &nbsp;
                                        جنيه
                                    </td>
                                </tr>
                                <tr style="border: 3px solid black;">
                                    <td colspan="4" class="text-center" style="border: 3px solid black;">
                                        <b>{{ __('Total Costs') }}</b>
                                    </td>
                                    <td style="border: 3px solid black;">
                                        {{ number_format($costs->sum('value'), 1) }} &nbsp; جنيه
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>{{-- End Costs --}}
                <br>
                <hr><br>
                {{-- Start Installments --}}
                <div class="row">
                    <div class="col-lg-6 col-sm-8">
                        <h3>{{ __('Installments') }}</h3>
                        <table class="table table-bordered text-dark text-center" style="border: 3px solid black;">
                            <thead style="border: 3px solid black;">
                                <tr style="border: 3px solid black;">
                                    <th style="font-weight: bold;font-size: 18px; border: 3px solid black;">
                                        {{ __('م') }}</th>
                                    <th style="font-weight: bold;font-size: 18px; border: 3px solid black;">
                                        {{ __('t.date') }}</th>
                                    <th style="font-weight: bold;font-size: 18px; border: 3px solid black;">
                                        {{ __('bank') }}</th>
                                    <th style="font-weight: bold;font-size: 18px; border: 3px solid black;">
                                        {{ __('Time') }}</th>
                                    <th style="font-weight: bold;font-size: 18px; border: 3px solid black;">
                                        {{ __('Amount') }}</th>
                                    <th style="font-weight: bold;font-size: 18px; border: 3px solid black;">
                                        {{ __('Receipt Date') }}</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php $i = 1; ?>
                                @foreach ($payments as $payment)
                                    @if ($payment->status == 'partiallycollected')
                                        @php
                                            $remaing_costs = $payment->amount - $payment->remaining;
                                            $payment->amount = $payment->amount - $payment->remaining;
                                            $total_payment += $remaing_costs;
                                        @endphp
                                    @elseif($payment->status == 'paid')
                                        @php
                                            $total_payment += $payment->amount;
                                        @endphp
                                    @endif

                                    <tr style="border: 3px solid black;">
                                        <td style="border: 3px solid black;">{{ $i++ }}</td>
                                        <td style="border: 3px solid black;">
                                            {{ str_replace('-', '/', $payment->due_date) }} </td>
                                        <td style="border: 3px solid black;">{{ $payment->bank_name }}</td>
                                        <td style="border: 3px solid black;">{{ $payment->paid_at }}</td>
                                        <td style="border: 3px solid black;">{{ number_format($payment->amount, 1) }}
                                            {{ $payment->status == 'partiallycollected' ? '(محصل جزئيا)' : null }}
                                        </td>
                                        <td style="border: 3px solid black;">
                                            {{ str_replace('-', '/', $payment->transaction_date) }}</td>
                                    </tr>
                                @endforeach
                                <tr style="border: 3px solid black;">
                                    <td colspan="4" class="text-center" style="border: 3px solid black;">
                                        <b>{{ __('Total installment paid') }}</b>
                                    </td>
                                    <td style="border: 3px solid black;">
                                        {{ number_format($total_payment, 1) }}
                                        &nbsp;
                                        جنيه
                                    </td>
                                </tr>
                                <tr style="border: 3px solid black;">
                                    <td colspan="4" class="text-center" style="border: 3px solid black;">
                                        <b>{{ __('Total installments') }}</b>
                                    </td>
                                    <td style="border: 3px solid black;">
                                        {{ number_format($payments->sum('amount'), 1) }} &nbsp; جنيه
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>{{-- End Installments --}}

            </div>

            <div class="card-footer">

                <h3><b>إجمالى المحصل</b>: {{ number_format($total_payment + $total_costs, 1) }} &nbsp; جنيه</h3>
                <h3><b>إجمالى التكاليف & الأقساط</b>: {{ number_format($payments->sum('amount') + $costs->sum('value'), 1) }} &nbsp; جنيه</h3>
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
