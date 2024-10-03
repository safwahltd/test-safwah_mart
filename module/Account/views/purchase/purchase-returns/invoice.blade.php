@extends('layouts.master')

@section('title', 'Purchase Return Invoice')

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
                <h1><strong>{{ optional($purchaseReturn->company)->name }}</strong></h1>
                <span>{{ optional($purchaseReturn->company)->head_office }}</span><br>
                <span><strong>Email: </strong>{{ optional($purchaseReturn->company)->email }}</span><br>
                <span><strong>Phone: </strong>{{ optional($purchaseReturn->company)->phone_number }}</span>
            </div>
        </div>

        <div class="row" id="printDiv">
            <div class="col-md-12">
                <div class="tile" style="border: 0 !important;">

                    <div class="row mb-3">
                        <div class="column-a" style="text-align: left">
                            Return For
                            <address>
                                <strong>{{ optional($purchaseReturn->supplier)->name }}</strong><br>
                                <span>{{ optional($purchaseReturn->supplier)->address }}</span>
                                <span>{{ optional($purchaseReturn->supplier)->mobile }}</span>
                                <span>{{ optional($purchaseReturn->supplier)->email }}</span>
                            </address>
                        </div>
                        <div class="column-a" style="text-align: right">
                            <span class="text-secondary">Invoice No:</span>
                            {{ $purchaseReturn->invoice_no }}<br>
                            <span class="text-secondary">Date :</span>
                            {{ $purchaseReturn->date }}
                        </div>
                    </div>



                    <table class="table table-bordered table-sm border-none" style="border: 0 !important; width: 100% !important;">
                        <h3>Product Return Information</h3>
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
                            @foreach($purchaseReturn->return_details ?? [] as $detail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ optional($detail->product)->name }}</td>
                                    <td>{{ optional(optional($detail->product)->unit)->name }}</td>
                                    <td class="text-center">{{ $detail->quantity }}</td>
                                    <td class="text-right">{{ $detail->price }}</td>
                                    <td class="text-right">{{ $detail->subtotal }}</td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>


                    <br>

                    <table class="table table-bordered table-sm border-none" style="border: 0 !important; width: 100% !important;">
                        <h3>Product Exchange Information</h3>
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
                            @foreach($purchaseReturn->exchange_details ?? [] as $detail)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ optional($detail->product)->name }}</td>
                                    <td>{{ optional(optional($detail->product)->unit)->name }}</td>
                                    <td class="text-center">{{ $detail->quantity }}</td>
                                    <td class="text-right">{{ $detail->price }}</td>
                                    <td class="text-right">{{ $detail->subtotal }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>






                    <div class="col-sm-12 mt-3">

                        <!-- Total Amount -->
                        <div class="row">
                            <div class="col-md-3 pull-right">
                                <div class="form-group">
                                    <label class="col-sm-8 control-label text-right">Total Amount</label>
                                    <div class="col-xs-4">{{ $purchaseReturn->total_payable }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Paid -->
                        <div class="row">
                            <div class="col-md-3 pull-right">
                                <div class="form-group">
                                    <label class="col-sm-8 control-label text-right">Paid Amount</label>
                                    <div class="col-xs-4">{{ $purchaseReturn->total_paid_amount }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Total Due -->
                        <div class="row">
                            <div class="col-md-3 pull-right">
                                <div class="form-group">
                                    <label class="col-sm-8 control-label text-right">Due Amount</label>
                                    <div class="col-xs-4">{{ $purchaseReturn->total_due_amount }}</div>
                                </div>
                            </div>
                        </div>
                    </div>





                    <div class="row mt-5 mb-5" style="margin-top: 20px">
                        <br>
                        <br>
                        <div class="hidden-print" style="float: right; padding-right: 10px !important;">
                            <div class="btn-group btn-group-xs">
                                <a class="btn btn-primary btn-xs" href="javascript:window.print();">
                                    <i class="fa fa-print"></i> Print
                                </a>
                                <a class="btn btn-danger btn-xs" href="{{ route('acc-purchase-returns.index') }}">
                                    <i class=" fa fa-backward"></i> 
                                    Back To List
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-5 mb-5 signature-row">
                        <div class="column" style="text-align: left">
                            Supplier <br><b>{{ optional($purchaseReturn->supplier)->name }} </b><br>
                            <hr>
                            Signature and Date
                        </div>
                        <div class="column">
                        </div>
                        <div class="column" style="text-align: right">
                            Issued By <br><b>{{ optional($purchaseReturn->company)->name }} </b> <br>
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
{{--    <script type="text/javascript">--}}
{{--        @if (session('success'))--}}
{{--        setTimeout(() => { window.print() }, 3000)--}}
{{--        @else--}}
{{--        // window.print()--}}
{{--        @endif--}}
{{--    </script>--}}
@stop
