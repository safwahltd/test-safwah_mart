@extends('layouts.master')

@section('title', 'Stock Request List')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
    </div>

    @include('partials._alert_message')

    <div class="row">
        <form action="" method="GET">
            <div class="col-sm-12">
                <table class="table table-bordered">
                    <tr>
                        <!-- PRODUCT TYPE -->
                        <td width="30%">
                            <select name="customer_id" id="customer_id" class="form-control select2" style="width: 100%">
                                <option value="">All Customer</option>
                                @foreach($customers as $customer)
                                    <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->name }} -> {{ $customer->mobile }}</option>
                                @endforeach
                            </select>
                        </td>





                        <!-- DISTRICT -->
                        <td width="20%">
                            <select name="district_id" id="district_id" class="form-control select2" style="width: 100%">
                                <option value="" selected>All District</option>
                                @foreach($districts as $id => $name)
                                    <option value="{{ $id }}" {{ request('district_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </td>


                        


                        <!-- AREA -->
                        <td width="20%">
                            <select name="area_id" id="area_id" class="form-control select2" style="width: 100%">
                                <option value="" selected>All Area</option>
                                @foreach($areas as $id => $name)
                                    <option value="{{ $id }}" {{ request('area_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </td>


                        


                        <!-- PRODUCT -->
                        <td width="30%">
                            <select name="product_id" id="product_id" class="form-control select2" style="width: 100%">
                                <option value="" selected>All Product</option>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}" {{ request('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }} -> {{ $product->code }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>





                    <tr>
                        <!-- ACTION -->
                        <td colspan="4" class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary" style="padding-top: 6px; padding-bottom: 6px;"><i class="fa fa-search"></i> SEARCH</button>
                                <a href="{{ request()->url() }}" class="btn btn-sm btn-light" style="width: 49%; padding-top: 6px; padding-bottom: 6px;"><i class="fa fa-refresh"></i> REFRESH</a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </form>

        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="table-header-bg">
                            <th width="3%" class="text-center">SL</th>
                            <th width="33%">Customer</th>
                            <th width="10%">District</th>
                            <th width="10%">Area</th>
                            <th width="40%">Product</th>
                            <th width="5%" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($stockRequests as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ optional($item->customer)->name }} -> {{ optional($item->customer)->mobile }}</td>
                                <td>{{ optional(optional($item->customer)->district)->name }}</td>
                                <td>{{ optional(optional($item->customer)->area)->name }}</td>
                                <td>{{ optional($item->product)->name }}</td>
                                <td class="text-center">
                                    <button class="btn btn-xs btn-danger" title="Delete" onclick="delete_item('{{ route('inv.stock-requests.destroy', $item->id) }}')" type="button">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @include('partials._paginate', ['data'=> $stockRequests])
            </div>
        </div>
    </div>
@endsection