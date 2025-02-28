@extends('layouts.master')
@section('title', 'Purchase Invoice')
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
            min-height: 35px;
            line-height: 15px;
            width: 60%;
            margin-top: -190px;
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
                <h1><strong>{{ optional($purchase->company)->name }}</strong></h1>
                <span>{{ optional($purchase->company)->head_office }}</span><br>
                <span><strong>Email: </strong>{{ optional($purchase->company)->email }}</span><br>
                <span><strong>Phone: </strong>{{ optional($purchase->company)->phone_number }}</span>
            </div>
        </div>

        <div class="row" id="printDiv">
            <div class="col-md-12">
                <div class="tile" style="border: 0 !important;">

                    <div class="row mb-3">
                        <div class="column-a" style="text-align: left">
                            Bill From
                            <address>
                                <strong>{{ optional($purchase->supplier)->name }}</strong><br>
                                <span>{{ optional($purchase->supplier)->address }}</span>
                                <span>{{ optional($purchase->supplier)->mobile }}</span>
                                <span>{{ optional($purchase->supplier)->email }}</span>
                            </address>
                        </div>
                        <div class="column-a" style="text-align: right">
                            <span class="text-secondary">Invoice No:</span>
                            {{ $purchase->invoice_no }}<br>
                            <span class="text-secondary">Date :</span>
                            {{ $purchase->date }}
                        </div>
                    </div>



                    <table class="table table-bordered table-sm border-none" style="border: 0 !important; width: 100% !important;">
                        <tbody style="background-color: #7592A5 !important; color: #ffffff">
                        <tr>
                            <th width="5%">Sl</th>
                            <th width="55%">Product Name</th>
                            <th width="10%">Unit</th>
                            <th width="10%" class="text-center">Quantity</th>
                            <th width="10%" class="text-right">Price</th>
                            <th width="10%" class="text-right">Amount</th>
                        </tr>
                        </tbody>

                        <tbody>
                        @foreach($purchase->details ?? [] as $details)
                            @php
                                $unit = \Module\Account\Models\Product::select('unit_id')->whereId(optional($details->product)->id)->first();
                                $unit = \Module\Account\Models\Unit::select('name')->whereId($unit->unit_id)->first();
                            @endphp
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    {{ optional($details->product)->name }}
                                </td>
                                <td>
                                    {{ $unit->name }}
                                </td>
                                <td class="text-center">
                                    {{ $details->quantity }}
                                </td>
                                <td class="text-right">
                                    {{ $details->price }}
                                </td>
                                <td class="text-right">
                                    {{ $details->amount }}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>

                        <tfoot style="font-weight: bold !important;" class="text-right">
                            <tr>
                                <th style="border: 0 !important; padding: 0 !important;" colspan="3"></th>
                                <th class="text-right" style="border: 0 !important; padding: 0 !important;" colspan="2">Discount Amount :</th>
                                <th class="text-right" style="border: 0 !important; padding: 0 !important; padding-right: 8px !important;">{{ $purchase->discount_amount }}</th>
                            </tr>
                            <tr>
                                <th style="border: 0 !important; padding: 0 !important;" colspan="3"></th>
                                <th class="text-right" style="border: 0 !important; padding: 0 !important;" colspan="2">Payable Amount :</th>
                                <th class="text-right" style="border: 0 !important; padding: 0 !important; padding-right: 8px !important;">{{ $purchase->total_amount }}</th>
                            </tr>
                            <tr>
                                <th style="border: 0 !important; padding: 0 !important;" colspan="3"></th>
                                <th class="text-right" style="border: 0 !important; padding: 0 !important;" colspan="2">Paid Amount :</th>
                                <th class="text-right" style="border: 0 !important; padding: 0 !important; padding-right: 8px !important;">{{ $purchase->paid_amount }}</th>
                            </tr>
                            <tr>
                                <th style="border: 0 !important; padding: 0 !important;" colspan="3"></th>
                                <th class="text-right" style="border: 0 !important; padding: 0 !important;" colspan="2">Due Amount :</th>
                                <th class="text-right" style="border: 0 !important; padding: 0 !important; padding-right: 8px !important;">{{ $purchase->due_amount }}</th>
                            </tr>
                        </tfoot>
                    </table>

                    <div class="row mt-5 mb-5">
                        <div class="hidden-print" style="float: right; padding-right: 10px !important;">
                            <div class="btn-group btn-group-xs">
                                <a class="btn btn-primary btn-xs" href="javascript:window.print();"><i class="fa fa-print"></i> Print</a>
                                <a class="btn btn-danger btn-xs" href="{{ route('acc-purchases.index') }}"><i class=" fa fa-backward"></i> Back To List</a>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5 mb-5 signature-row">
                        <div class="column" style="text-align: left">
                            Supplier <br><b>{{ optional($purchase->supplier)->name }} </b><br>
                            <hr>
                            Signature and Date
                        </div>
                        <div class="column">
                        </div>
                        <div class="column" style="text-align: right">
                            Company <br><b>{{ optional($purchase->company)->name }} </b> <br>
                            <hr>
                            Signature and Date
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

@endsection


@section('js')
    <script type="text/javascript">
        @if (session('success'))
        setTimeout(() => { window.print() }, 3000)
        @else
        // window.print()
        @endif
    </script>
@stop
