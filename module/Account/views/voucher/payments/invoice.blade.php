@extends('layouts.master')
@section('title', 'Payment Voucher Invoice')
@push('style')
    <style type="text/css">
        @media print {
            .d-none {
                display: block !important;
            }

            .d-print {
                display: block !important;
            }

            .signature-row {
                display: unset !important; ;
            }
        }

        @page {
            margin: 1in;
        }

        .d-print {
            display: none;
        }

        .signature-row {
            display: none;
        }

        .note-bar {
            border-left: 5px solid #f2f2f2;
            min-height: 32px;
            line-height: 10px;
            width: 60%;
            margin-top: -60px;
        }

        .note-bar p {
            padding-top: 1px;
            margin-left: 10px !important;
        }

        * {
            box-sizing: border-box;
        }

        .column {
            float: left;
            width: 33.33%;
            padding: 10px;
        }

        .column-a {
            float: left;
            width: 50%;
            padding: 10px;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

    </style>
@endpush

@section('content')
    <main class="app-content">
        <div class="row" style="display: inline">
            <div class="col-md-12 text-center">
                <h1><strong>{{ optional($voucher->company)->name }}</strong></h1>
                <span>{{ optional($voucher->company)->head_office }}</span><br>
                <span><strong>Email: </strong>{{ optional($voucher->company)->email }}</span><br>
                <span><strong>Phone: </strong>{{ optional($voucher->company)->phone_number }}</span>
            </div>
        </div>

        <div style="border-top: 1px solid #F2F2F2 !important;"></div>

        <div class="row" style="display: inline;">
            <div class="col-md-12 text-center">
                <h3 style="color: #7592a5; margin-top: -10px !important;"><strong>Payment Voucher</strong></h3>
            </div>
        </div>

        <div class="row" id="printDiv">
            <div class="col-md-12">
                <div class="tile" style="border: 0 !important;">

                    <div class="row mb-3">
                        <div class="column-a" style="text-align: left">
                        </div>
                        <div class="column-a" style="text-align: right">
                            <span class="text-secondary">Invoice No:</span>
                            {{ $voucher->invoice_no }}<br>
                            @if(!empty($voucher->reference))
                            <span class="text-secondary">Reference:</span>
                            {{ $voucher->reference }}<br>
                            @endif
                            <span class="text-secondary">Date :</span>
                            {{ $voucher->date }}
                        </div>
                    </div>



                    <table class="table table-bordered table-sm border-none" style="border: 0 !important; width: 100% !important;">
                        <tbody style="background-color: #7592A5 !important; color: #ffffff">
                            <tr>
                                <th width="5%" class="text-center">Sl</th>
                                <th width="75%">Account</th>
                                <th width="10%" class="text-right">Debit</th>
                                <th width="10%" class="text-right">Credit</th>
                            </tr>
                        </tbody>

                        <tbody>
                        @foreach($voucher->details ?? [] as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    {{ optional($item->account)->name }}
                                </td>
                                <td class="text-right">
                                    @if($item->balance_type == 'Debit')
                                        {{ number_format($item->amount, 2) }}
                                    @endif
                                </td>
                                <td class="text-right">
                                    @if($item->balance_type == 'Credit')
                                        {{ number_format($item->amount, 2) }}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                        @php
                            $totalAmount = $voucher->details->sum('amount') > 0 ? $voucher->details->sum('amount') / 2 : 0;
                        @endphp

                        <tfoot style="font-weight: bold !important;" class="text-right">
                            <tr>
                                <th class="text-right" style="border: 0 !important; padding: 0 !important;" colspan="2">Total :</th>
                                <th class="text-right" style="border: 0 !important; padding: 0 !important; padding-right: 8px !important;">{{ number_format($totalAmount, 2) }}</th>
                                <th class="text-right" style="border: 0 !important; padding: 0 !important; padding-right: 8px !important;">{{ number_format($totalAmount, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>

                    @if(!empty($voucher->description))
                        <div class="row my-5">
                            <div class="col-md-12">
                                <div class="note-bar">
                                    <p><b>Note </b></p>
                                    <p>{{ $voucher->description }}</p>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row mt-5 mb-5">
                        <div class="hidden-print" style="float: right; padding-right: 10px !important;">
                            <div class="btn-group btn-group-xs">
                                <a class="btn btn-primary btn-xs" href="javascript:window.print();"><i class="fa fa-print"></i> Print</a>
                                <a class="btn btn-danger btn-xs" href="{{ route('voucher-payments.index') }}"><i class=" fa fa-backward"></i> Back To List</a>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5 mb-5 signature-row">
                        <div class="column" style="text-align: left">
                            Prepared By <br><b>{{ optional($voucher->created_user)->name }} </b><br>
                            <hr>
                            Signature and Date
                        </div>
                        <div class="column">
                        </div>
                        <div class="column">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection


@section('js')
{{--    <script type="text/javascript">--}}
{{--        @if (session('success'))--}}
{{--        setTimeout(() => { window.print() }, 3000)--}}
{{--        @else--}}
{{--        // window.print()--}}
{{--        @endif--}}
{{--    </script>--}}
@stop
