@extends('layouts.master')
@section('title', 'Invoice No: ' . $purchase->invoice_no . ' Approve & Receive')



@section('content')
    <div class="row">
        <div class="col-12">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <h4 class="pl-2"><i class="far fa-receipt"></i> @yield('title')</h4>

                <ul class="breadcrumb mb-1">
                    <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
                    <li><a class="text-muted" href="{{ route('inv.purchases.index') }}">Purchase</a></li>
                    <li>{{ $purchase->invoice_no }}</li>
                </ul>
            </div>

            <div class="widget-body">
                <div class="widget-main">


                    <!-- PURCHASE APPROVE FORM -->
                    <form class="form-horizontal" action="{{ route('inv.purchases.approve-and-receive', $purchase->id) }}" onsubmit="return confirm('Are You Sure to Approve & Receive This Purchase?')" method="POST" enctype="multipart/form-data">
                        @csrf



                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group mb-2 width-100">
                                    <span class="input-group-addon" style="width: 40%; text-align: left">
									    Supplier
                                    </span>
                                    <select name="supplier_id" id="supplier_id" class="form-control" style="width: 100%" readonly required>
                                        <option value="{{ $purchase->supplier_id }}">{{ optional($purchase->supplier)->name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-2 width-100">
                                    <span class="input-group-addon" style="width: 40%; text-align: left">
									    Warehouse
                                    </span>
                                    <select name="warehouse_id" id="warehouse_id" class="form-control" style="width: 100%" readonly required>
                                        <option value="{{ $purchase->warehouse_id }}">{{ optional($purchase->warehouse)->name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-2 width-100">
                                    <span class="input-group-addon" style="width: 40%; text-align: left">
									    Date
                                    </span>
                                    <input type="text" name="date" id="date" tabindex="3" class="form-control" value="{{ $purchase->date }}" autocomplete="off" data-date-format="yyyy-mm-dd" readonly>
                                </div>
                            </div>
                        </div>


                        <!-- PURCHASE TABLE -->
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="purchaseTable">
                                        <thead>
                                            <tr class="table-header-bg">
                                                <th width="15%">Product</th>
                                                <th width="10%">Category</th>
                                                <th width="10%">Unit</th>
                                                <th width="12%">Variation</th>
                                                <th width="5%">Lot</th>
                                                <th width="10%" class="text-center">Unit Cost</th>
                                                <th width="10%" class="text-center">Qty</th>
                                                <th width="10%" class="text-center">Expired</th>
                                                <th width="15%">Comment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($purchase->purchaseDetails as $purchaseDetail)
                                                <tr>
                                                    <input type="hidden" name="purchase_detail_id[]" value="{{ $purchaseDetail->id }}">
                                                    <th>
                                                        <input type="hidden" class="product_is_variation" value="{{ $purchaseDetail->product_variation_id != null ? 'true' : 'false' }}">
                                                        <select name="product_id[]" id="product_id" class="form-control products" data-placeholder="- Select -" readonly required>
                                                            <option value="{{ $purchaseDetail->product_id }}">{{ optional($purchaseDetail->product)->name }} - {{ optional($purchaseDetail->product)->code }}</option>
                                                        </select>
                                                    </th>
                                                    <th>
                                                        <input type="text" name="category_id[]" id="category_id" class="form-control category" value="{{ optional(optional($purchaseDetail->product)->category)->name }}" readonly>
                                                    </th>
                                                    <th>
                                                        <input type="text" name="unit_measure_id[]" id="unit_measure_id" class="form-control unit-measure" value="{{ optional(optional($purchaseDetail->product)->unitMeasure)->name }}" readonly>
                                                    </th>
                                                    <th>
                                                        <select name="product_variation_id[]" id="product_variation_id" class="form-control product-variations" data-placeholder="- Select -" readonly>
                                                            <option value="{{ $purchaseDetail->product_variation_id }}">{{ optional($purchaseDetail->productVariation)->name }}</option>
                                                        </select>
                                                    </th>
                                                    <th>
                                                        <input type="text" name="lot[]" id="lot" class="form-control lot" value="{{ $purchaseDetail->lot }}" autocomplete="off" readonly>
                                                    </th>
                                                    <th>
                                                        <input type="text" name="purchase_price[]" id="purchase_price" class="form-control text-center only-number purchase_price" value="{{ number_format($purchaseDetail->purchase_price, 2, '.', '') }}" readonly required>
                                                    </th>
                                                    <th>
                                                        <input type="number" name="quantity[]" id="quantity" class="form-control text-center quantity" value="{{ number_format($purchaseDetail->quantity, 2, '.', '') }}" autocomplete="off" readonly required>
                                                    </th>
                                                    <th>
                                                        <input type="text" name="expired_dates[]" data-date-format="yyyy-mm-dd" class="form-control date-picker" readonly value="{{ $purchaseDetail->expired_date }}" autocomplete="off">
                                                    </th>
                                                    <th>
                                                        <input type="text" name="special_comment[]" id="special_comment" class="form-control special_comment" value="{{ $purchaseDetail->special_comment }}" autocomplete="off" readonly>
                                                    </th>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>







                            <div class="col-md-9">
                                <input type="file" name="attachment" id="attachment"/>
                            </div>

                            <div class="col-md-3">
                                <div class="input-group mb-1 width-100">
                                    <span class="input-group-addon" style="width: 40%; text-align: left">
									    Subtotal
                                    </span>
                                    <input type="text" class="form-control text-right" name="subtotal" id="subtotal" value="{{ number_format($purchase->subtotal, 2, '.', '') }}" readonly required>
                                </div>
                                <div class="input-group mb-1 width-100">
                                    <span class="input-group-addon" style="width:40%; text-align: left">
									    Discount
                                    </span>
                                    <input type="text" class="form-control text-right" name="total_discount_percent" id="total_discount_percent" onkeyup="calculateDiscountAmount(this)" placeholder="%" autocomplete="off">
                                    <span class="input-group-addon width-10" style="width:10%; text-align: left">
									    <i class="far fa-exchange-alt"></i>
                                    </span>
                                    <input type="text" class="form-control text-right" name="total_discount_amount" id="total_discount_amount" onkeyup="calculateDiscountPercent(this)" placeholder="Amount" autocomplete="off">
                                </div>
                                <div class="input-group mb-1 width-100">
                                    <span class="input-group-addon" style="width: 40%; text-align: left">
									    Payable
                                    </span>
                                    <input type="text" class="form-control text-right" name="payable_amount" id="payable_amount" value="{{ number_format($purchase->subtotal, 2, '.', '') }}" readonly required>
                                </div>
                                <div class="input-group mb-1 width-100">
                                    <span class="input-group-addon" style="width: 40%; text-align: left">
									    Paid Amount
                                    </span>
                                    <input type="text" class="form-control text-right" name="paid_amount" id="paid_amount" onkeyup="calculateAmount(this)" autocomplete="off">
                                </div>
                                <div class="input-group mb-1 width-100">
                                    <span class="input-group-addon" style="width: 40%; text-align: left">
									    Due Amount
                                    </span>
                                    <input type="text" class="form-control text-right" name="due_amount" id="due_amount" readonly>
                                </div>




                                <div class="btn-group width-100">
                                    <button class="btn btn-sm btn-success" style="width: 70%"> <i class="fad fa-thumbs-up"></i> APPROVE & RECEIVE </button>
                                    <a class="btn btn-sm btn-info" style="width: 29%" href="{{ route('inv.purchases.index') }}"> <i class="fa fa-bars"></i> LIST </a>
                                </div>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection





@section('script')
    @include('purchases._inc.script')
@endsection
