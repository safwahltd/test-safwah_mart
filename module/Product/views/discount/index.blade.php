@extends('layouts.master')

@section('title', 'Discounts Product')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">

            <!------------- CREATE ---------------->
            @if ((hasPermission("discounts.create", $slugs)))
                <a class="btn btn-sm btn-primary" href="{{ route('discounts.create') }}">
                    <i class="fa fa-plus-circle"></i>
                    Add New
                </a>
            @endif

            @if (hasAnyPermission(['website-cms.meta-tag'], $slugs))
                <a class="btn btn-sm btn-info" href="{{ route('website.seo-infos.create', 'Discount') }}?previous_url=discount">
                    <i class="fa fa-plus-circle"></i>
                    Seo Info
                </a>
            @endif

        </div>
    </div>

    @include('partials._alert_message')

    <div class="row">
        <form action="" method="GET">
            <div class="col-sm-12">
                <table class="table table-bordered">
                    <tr>
                        <!-- PRODUCT TYPE -->
                        {{-- <td width="25%">
                            <select name="product_type_id" id="product_type_id" class="form-control select2" style="width: 100%">
                                <option value="">All Type</option>
                                @foreach($types as $id => $name)
                                    <option value="{{ $id }}" {{ request('product_type_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </td> --}}

                        <!-- OFFERS -->
                        <td width="25%">
                            <select name="offer_id" id="offer_id" class="form-control select2" style="width: 100%">
                                <option value="">All Offer</option>
                                @foreach($offers as $id => $name)
                                    <option value="{{ $id }}" {{ request('offer_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </td>





                        <!-- BRAND -->
                        <td width="25%">
                            <select name="brand_id" id="brand_id" class="form-control select2" style="width: 100%">
                                <option value="" selected>All Brand</option>
                                @foreach($brands as $id => $name)
                                    <option value="{{ $id }}" {{ request('brand_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </td>





                        <!-- CATEGORY -->
                        <td width="25%">
                            <select name="category_id" id="category_id" class="form-control select2" style="width: 100%">
                                <option value="" selected>All Category</option>
                                @foreach($categories as $id => $name)
                                    <option value="{{ $id }}" {{ request('category_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                                @endforeach
                            </select>
                        </td>





                        <!-- PRODUCT -->
                        <td width="25%">
                            <select name="id" id="id" class="form-control select2" style="width: 100%">
                                <option value="" selected>All Product</option>
                                @foreach($products as $id => $name)
                                    <option value="{{ $id }}" {{ request('id') == $id ? 'selected' : '' }}>{{ $name }}</option>
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
                            <th width="14%">Product</th>
                            <th width="8%">Category</th>
                            <th width="8%">Unit</th>
                            <th width="5%" class="text-right">MRP</th>
                            <th width="5%" class="text-right">Discount(%)</th>
                            <th width="5%" class="text-right">Discount(Flat)</th>
                            <th width="10%">From Date</th>
                            <th width="10%">To Date</th>
                            <th width="10%" class="text-center">Offer</th>
                            <th width="11%" class="text-center">Show in Offer</th>
                            <th width="5%" class="text-center">Status</th>
                            <th width="5%" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($discounts as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ optional($item->product)->name }}</td>
                                <td>{{ optional($item->product->category)->name }}</td>
                                <td>{{ optional($item->product->unitMeasure)->name }}</td>
                                <td class="text-right">{{ number_format($item->product->sale_price, 2, '.', '') }}</td>
                                <td class="text-right">{{ $item->discount_percentage }}</td>
                                <td class="text-right">{{ $item->discount_flat }}</td>
                                <td>{{ $item->start_date }}</td>
                                <td>{{ $item->end_date }}</td>
                                <td class="text-center">
                                    <span class="label label-yellow">
                                        {{ optional($item->offer)->name }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="label label-{{ $item->show_in_offer == 1 ? 'primary' : 'danger' }}">
                                        {{ $item->show_in_offer == 1 ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td class="text-center">

                                    <!------------- EDIT ---------------->
                                    @if ((hasPermission("discounts.edit", $slugs)))
                                        <x-status status="{{ $item->status }}" id="{{ $item->id }}" table="{{ $table }}" />
                                    @endif

                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="javascript:void(0)" class="text-danger fas fa-ellipsis-h" type="button" data-toggle="dropdown"></a>
                                        <ul class="dropdown-menu dropdown-menu-right">

                                            <!------------- EDIT ---------------->
                                            @if ((hasPermission("discounts.edit", $slugs)))
                                                <li>
                                                    <a href="{{ route('discounts.edit', $item->id) }}" title="Edit">
                                                        <i class="fa fa-pencil-square-o"></i> Edit
                                                    </a>
                                                </li>
                                            @endif

                                            <!------------- DELETE ---------------->
                                            @if ((hasPermission("discounts.delete", $slugs)))
                                                <li>
                                                    <a href="javascript:void(0)" title="Delete" onclick="delete_item('{{ route('discounts.destroy', $item->id) }}')" type="button">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </a>
                                                </li>
                                            @endif
                                            <li class="divider"></li>
                                            <li>
                                                @include('partials._new-user-log', ['data' => $item])
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @include('partials._paginate', ['data'=> $discounts])
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function cantDeleteAlert() {
            Swal.fire('<p style="font-size:15px;">You can\'t delete this Product. Because there are one or more time Purchased this Product.</p>')
        }
    </script>
@endsection
