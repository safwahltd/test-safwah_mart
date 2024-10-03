@extends('layouts.master')
@section('title', 'P.O. No: '.$purchase->p_o_no)



@section('content')
    <div class="row">
        <div class="col-12">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <h4 class="pl-2"><i class="far fa-receipt"></i> @yield('title')</h4>

                <ul class="breadcrumb mb-1">
                    <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
                    <li><a class="text-muted" href="javascript:void(0)">Purchase</a></li>
                    <li><a class="text-muted" href="javascript:void(0)">P.O.</a></li>
                    <li><a class="text-muted" href="{{ route('inv.purchases.p-o.list') }}">P.O. List</a></li>
                    <li>@yield('title')</li>
                </ul>
            </div>

            <div class="widget-body">
                <div class="widget-main">


                    <!-- PURCHASE CREATE FORM -->
                    <form id="" class="form-horizontal" action="{{ route('inv.purchases.p-o.verification', $purchase->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <input type="hidden" name="p_o_no" value="">
                        
                        
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="input-group mb-2 width-100" style="width: 100%">
                                    <span class="input-group-addon" style="width: 40%; text-align: left">
									    Supplier
                                    </span>
                                    <select name="supplier_id" id="supplier_id" class="form-control" style="width: 100%" readonly required>
                                        <option value="{{ $purchase->supplier_id }}">{{ optional($purchase->supplier)->name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-2 width-100" style="width: 100%">
                                    <span class="input-group-addon" style="width: 40%; text-align: left">
									    Warehouse
                                    </span>
                                    <select name="warehouse_id" id="warehouse_id" class="form-control" style="width: 100%" readonly required>
                                        <option value="{{ $purchase->supplier_id }}">{{ optional($purchase->supplier)->name }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group mb-2 width-100" style="width: 100%">
                                    <span class="input-group-addon" style="width: 40%; text-align: left">
									    P.O. Date
                                    </span>
                                    <input type="text" name="p_o_date" id="p_o_date" tabindex="3" class="form-control" value="{{ $purchase->p_o_date }}" autocomplete="off" data-date-format="yyyy-mm-dd" readonly>
                                </div>
                            </div>
                        </div>

                    
                        <!-- PURCHASE TABLE -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="purchaseTable">
                                        <thead>
                                            <tr class="table-header-bg">
                                                <th width="35%">Product</th>
                                                <th width="10%">Category</th>
                                                <th width="10%">Unit</th>
                                                <th width="15%">Variation</th>
                                                <th width="5%">Lot</th>
                                                <th width="10%" class="text-center">Qty</th>
                                                <th width="15%">Comment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($purchase->purchaseDetails as $purchaseDetail)
                                                <tr>
                                                    <input type="hidden" name="purchase_detail_id[]" value="{{ $purchaseDetail->id }}">
                                                    <th width="35%">
                                                        <input type="hidden" class="product_is_variation" value="{{ $purchaseDetail->product_variation_id != null ? 'true' : 'false' }}">
                                                        <select name="product_id[]" id="product_id" class="form-control products" data-placeholder="- Select -" readonly required>
                                                            <option value="{{ $purchaseDetail->product_id }}">{{ optional($purchaseDetail->product)->name }} - {{ optional($purchaseDetail->product)->code }}</option>
                                                        </select>
                                                    </th>
                                                    <th width="10%">
                                                        <input type="text" name="category_id[]" id="category_id" class="form-control category" value="{{ optional(optional($purchaseDetail->product)->category)->name }}" readonly>
                                                    </th>
                                                    <th width="10%">
                                                        <input type="text" name="unit_measure_id[]" id="unit_measure_id" class="form-control unit-measure" value="{{ optional(optional($purchaseDetail->product)->unitMeasure)->name }}" readonly>
                                                    </th>
                                                    <th width="15%">
                                                        <select name="product_variation_id[]" id="product_variation_id" class="form-control product-variations" data-placeholder="- Select -" readonly>
                                                            <option value="{{ $purchaseDetail->product_variation_id }}">{{ optional($purchaseDetail->productVariation)->name }}</option>
                                                        </select>
                                                    </th>
                                                    <th width="10%">
                                                        <input type="text" name="lot[]" id="lot" class="form-control lot" value="{{ $purchaseDetail->lot }}" autocomplete="off" readonly>
                                                    </th>
                                                    <th width="10%">
                                                        <input type="number" name="quantity[]" id="quantity" class="form-control text-center quantity" value="{{ number_format($purchaseDetail->quantity, 2, '.', '') }}" autocomplete="off" readonly required>
                                                    </th>
                                                    <th width="10%">
                                                        <input type="text" name="special_comment[]" id="special_comment" class="form-control special_comment" value="{{ $purchaseDetail->special_comment }}" autocomplete="off" readonly>
                                                    </th>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <div class="btn-group" style="float: right">
                            <button class="btn btn-sm btn-success"> <i class="fad fa-thumbs-up"></i> APPROVED </button>
                            <a class="btn btn-sm btn-info" href="{{ route('inv.purchases.p-o.list') }}"> <i class="fa fa-bars"></i> LIST </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('script')
    <script>
        $(document).ready(function () {
            $('#sidebar').addClass('menu-min');
        })
    </script>
@endsection