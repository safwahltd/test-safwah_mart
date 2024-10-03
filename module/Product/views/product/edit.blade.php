@extends('layouts.master')
@section('title', 'Edit Product')


@section('css')
    <link rel="stylesheet" href="{{ asset('assets/custom_css/image-plugin.css') }}">

    <style>
        .show-multiple-image {
            position: relative;
            /* width: 80px;
            height: 80px; */
            border: 1px solid #ccc;
        }

        .show-multiple-image .image {
            opacity: 1;
            display: block;
            width: 80px;
            height: 80px;
            transition: .5s ease;
            backface-visibility: hidden;
        }

        .action {
            transition: .5s ease;
            opacity: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
        }

        .show-multiple-image:hover .image {
            opacity: 0.1;
        }

        .show-multiple-image:hover .action {
            opacity: 1;
        }

        .show-multiple-image .action a {
            color: red;
            font-size: 16px;
        }
    </style>
@endsection


@section('content')




<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <h4 class="pl-2"><i class="fa fa-edit"></i> @yield('title')</h4>

    <ul class="breadcrumb mb-1">
        <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
        <li>Product Config</li>
        <li><a class="text-muted" href="{{ route('pdt.products.index') }}">Product</a></li>
        <li class=""><a href="javascript:void(0)">Edit</a></li>
    </ul>
</div>




<div class="row">
    <div class="col-12">

        <div class="widget-body">
            <div class="widget-main">
                <form id="productEditForm" class="form-horizontal mt-2" action="{{ route('pdt.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    @include('partials._alert_message')

                    <ul class="nav nav-tabs" style="position: relative">
                        <li class="{{ !request()->filled('tab') ? 'active' : '' }}"><a href="javascript:void(0)">BASIC INFORMATION</a></li>
                        <li class="{{ request('tab') === 'price' ? 'active' : '' }}"><a href="javascript:void(0)">Price</a></li>
                        <li class="{{ request('tab') === 'description' ? 'active' : '' }}"><a href="javascript:void(0)">Description</a></li>
                        <li class="{{ request('tab') === 'file' ? 'active' : '' }}"><a href="javascript:void(0)">File</a></li>
                        <li class="{{ request('tab') === 'advance' ? 'active' : '' }}"><a href="javascript:void(0)">Advance</a></li>
                        <li class="{{ request('tab') === 'finish' ? 'active' : '' }}"><a href="javascript:void(0)">Finish</a></li>
                    </ul>

                    <div class="tab-content">
                        @if (!request()->filled('tab') || request('tab') === '')
                            <input type="hidden" class="form-control" name="next_tab" value="price">
                            <div class="tab-pane active" id="navBasicInformation">

                                @include('product._inc.edit._basic-information')

                                <div class="pull-right btn-group mt-4">
                                    <a class="btn btn-sm btn-theme mr-1" href="{{ route('pdt.products.index') }}"><i class="fa fa-long-arrow-left"></i> BACK TO LIST</a>
                                    <button class="btn btn-sm btn-next" type="submit">SAVE AND NEXT <i class="fa fa-long-arrow-right"></i></button>
                                </div>
                            </div>
                        @elseif (request('tab') === 'price')
                            <input type="hidden" class="form-control" name="next_tab" value="description">
                            <div class="tab-pane active" id="navPrice">

                                @include('product._inc.edit._price')

                                <div class="row">
                                    <div class="col-md-6 col-md-offset-3">
                                        <div class="pull-right btn-group mt-2">
                                            <a class="btn btn-sm btn-theme mr-1" href="{{ route('pdt.products.edit', ['tab' => '', 'product' => $product->id]) }}"><i class="fa fa-long-arrow-left"></i> PREVIOUS</a>
                                            <button class="btn btn-sm btn-next" onclick="priceValidation(event)" type="button">SAVE AND NEXT <i class="fa fa-long-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif (request('tab') === 'description')
                            <input type="hidden" class="form-control" name="next_tab" value="file">
                            <div class="tab-pane active" id="navFile">

                                @include('product._inc.edit._description')

                                <div class="pull-right btn-group mt-4 mr-1">
                                    <a class="btn btn-sm btn-theme mr-1" href="{{ route('pdt.products.edit', ['tab' => 'price', 'product' => $product->id]) }}"><i class="fa fa-long-arrow-left"></i> PREVIOUS</a>
                                    <button class="btn btn-sm btn-next" type="submit">SAVE AND NEXT <i class="fa fa-long-arrow-right"></i></button>
                                </div>
                            </div>
                        @elseif (request('tab') === 'file')
                            <input type="hidden" class="form-control" name="next_tab" value="advance">
                            <div class="tab-pane active" id="navDescription">

                                @include('product._inc.edit._file')

                                <div class="row">
                                    <div class="col-md-6 col-md-offset-3">
                                        <div class="pull-right btn-group mt-2">
                                            <a class="btn btn-sm btn-theme mr-1" href="{{ route('pdt.products.edit', ['tab' => 'description', 'product' => $product->id]) }}"><i class="fa fa-long-arrow-left"></i> PREVIOUS</a>
                                            <button class="btn btn-sm btn-next" type="submit">SAVE AND NEXT <i class="fa fa-long-arrow-right"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @elseif (request('tab') === 'advance')
                            <input type="hidden" class="form-control" name="next_tab" value="finish">
                            <div class="tab-pane active" id="navAdvance">

                                @include('product._inc.edit._advance')

                                <div class="pull-right btn-group mt-4 mr-1">
                                    <a class="btn btn-sm btn-theme mr-1" href="{{ route('pdt.products.edit', ['tab' => 'file', 'product' => $product->id]) }}"><i class="fa fa-long-arrow-left"></i> PREVIOUS</a>
                                    <button class="btn btn-sm btn-next" type="submit">SAVE AND NEXT <i class="fa fa-long-arrow-right"></i></button>
                                </div>
                            </div>
                        @elseif (request('tab') === 'finish')
                            <input type="hidden" class="form-control" name="tab" value="finish">
                            <div class="tab-pane active" id="navFinish">

                                @include('product._inc._finish')

                            </div>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


{{-- @include('product._inc.edit._view-multiple-image') --}}

@endsection


@section('js')

    <script src="{{ asset('assets/custom_js/image-plugin.js') }}"></script>
    <script src="{{ asset('assets/js/markdown.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-markdown.min.js') }}"></script>

    <script src="{{ asset('assets/js/bootstrap-wysiwyg.min.js') }}"></script>

    <script>

        $('#sidebar').addClass('menu-min');

        $(document).ready(function() {
            loadProductMultipleImage(`{{ $product->id }}`);
        });
    </script>

    @include('product/_inc/_script')

    <script type="text/javascript">
        $(document).ready(function() {



            // DISCOUNT PERCENT TO FLAT AMOUNT
            $(document).on('keyup', '.discount-percentage, .sale-price', function() {
                let percent = Number($('.discount-percentage').val())
                let price   = Number($('.sale-price').val())

                if(percent > 100) {
                    percent = 100
                    $(this).val(100)
                }

                let discount = ((price * percent) / 100)

                $('.discount-flat').val(Math.round(discount))
            })


            // DISCOUNT PERCENT TO FLAT AMOUNT
            $(document).on('keyup', '.discount-flat', function() {
                let flat = Number($(this).val())
                let price   = Number($('.sale-price').val())

                if(flat < 0) {
                    flat = 0
                    $(this).val(0)
                }

                let discount = ((flat * 100) / price).toFixed(2)

                $('.discount-percentage').val(discount)
            })
        })
    </script>
@stop
