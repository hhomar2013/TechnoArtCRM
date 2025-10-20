<div>
    <div class="col-12 p-4">
        <button class="btn btn-primary" id="printButton" onclick="printDiv()">طباعة</button>
        <hr>
    </div>
    <div class="container-fluid text-dark " style="font-weight: bold">

        <div class="card shadow-lg p-3 {{ $transfer ? 'bg-warning' : '' }}" id="printArea">
            <div class="p-2">
                <br>
                <div class="row">
                    @foreach ($header as $val_customer)
                        <div class="row-lg-6 p-2">
                            <h5 class="">
                                <b>{{ __('Name') }}</b>&nbsp;:&nbsp;{{ $val_customer->customer_name }}
                            </h5>
                            <h6 class=""><b>{{ __('Customer ID') }}</b>&nbsp;:&nbsp;{{ $val_customer->code }}</h6>
                        </div>
                    @endforeach
                </div>
                <hr />
                <div class="row p-2">
                    <div class="col-lg-2" style="border-left: black 1px solid">
                        <p class=""><b>{{ __('Project Name') }}</b> : {{ $header[0]->project_name }}</p>
                        <p class=""><b>{{ __('Phase Name') }}</b> : {{ $header[0]->phase_name }}</p>
                    </div>
                    <div class="col-lg-2 ">
                        <p><b>عدد الأقساط</b> : {{ $payments->count() }}</p>
                        <p><b>قيمة القسط</b> : {{ $payments->last()->amount }}</p>
                    </div>
                    <div class="col-lg-6">
                        @if ($transfer)
                            <label for=""> {{ __('موقف العميل') }} </label>
                            <p><b> {{ $transfer->note }} </b></p>
                        @else
                        @endif

                    </div>
                </div>
            </div>
            <div class="card-body">

                {{-- Start Costs --}}
                <div class="row">
                    <div class="col-lg-6 col-sm-8">
                        <h3>{{ __('Costs') }}</h3>
                        <table class="table table-bordered text-dark  text-center" style="border: 3px solid black;">
                            <thead style="border: 3px solid black;">
                                <tr style="border: 3px solid black;">
                                    <th style="font-weight: bold;font-size: 15px; border: 3px solid black;">
                                        {{ __('#') }}</th>
                                    <th style="font-weight: bold;font-size: 15px; border: 3px solid black;">
                                        {{ __('t.date') }}</th>
                                    <th style="font-weight: bold;font-size: 15px; border: 3px solid black;">
                                        {{ __('Statement') }}</th>
                                    <th style="font-weight: bold;font-size: 15px; border: 3px solid black;">
                                        {{ __('bank') }}</th>
                                    <th style="font-weight: bold;font-size: 15px; border: 3px solid black;">
                                        {{ __('Time') }}</th>
                                    <th style="font-weight: bold;font-size: 15px; border: 3px solid black;">
                                        {{ __('Amount') }}</th>
                                    <th style="font-weight: bold;font-size: 12px; border: 3px solid black;">
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
                                        <td>
                                            {{ $cost->id }}
                                        </td>
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
                                    {{-- شوف لو فيه reaming بنفس cost_id --}}
                                    @foreach ($costs_reaming as $reaming)
                                        @if ($reaming->cost_id == $cost->id)
                                            <tr style="border: 3px solid black; background-color: rgb(164, 237, 153);">
                                                <td>
                                                    {{ $cost->id }}
                                                </td>
                                                <td style="border: 3px solid black;">
                                                    {{-- {{ str_replace('-', '/', $reaming->updated_at) }} --}}
                                                </td>
                                                <td style="border: 3px solid black;">{{ __('Partial payment') }}</td>
                                                <td style="border: 3px solid black;">{{ $reaming->banke_name }}</td>
                                                <td style="border: 3px solid black;">{{ $reaming->time }}</td>
                                                <td style="border: 3px solid black;">
                                                    {{ number_format($reaming->remaining, 2) . __('EGP') }}
                                                </td>
                                                <td style="border: 3px solid black;">
                                                    {{ str_replace('-', '/', $reaming->transaction_date) }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
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
                                    <th style="font-weight: bold;font-size: 15px; border: 3px solid black;">
                                        {{ __('م') }}</th>
                                    <th style="font-weight: bold;font-size: 15px; border: 3px solid black;">
                                        {{ __('t.date') }}</th>
                                    <th style="font-weight: bold;font-size: 15px; border: 3px solid black;">
                                        {{ __('bank') }}</th>
                                    <th style="font-weight: bold;font-size: 15px; border: 3px solid black;">
                                        {{ __('Time') }}</th>
                                    <th style="font-weight: bold;font-size: 15px; border: 3px solid black;">
                                        {{ __('Amount') }}</th>
                                    <th style="font-weight: bold;font-size: 12px; border: 3px solid black;">
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
                <h3><b>إجمالى التكاليف & الأقساط</b>:
                    {{ number_format($payments->sum('amount') + $costs->sum('value'), 1) }} &nbsp; جنيه</h3>
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
