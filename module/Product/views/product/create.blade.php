@extends('layouts.master')
@section('title', 'Add New Product')

@section('content')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <h4 class="pl-2"><i class="fa fa-plus"></i> @yield('title')</h4>

    <ul class="breadcrumb mb-1">
        <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
        <li>Product Config</li>
        <li><a class="text-muted" href="{{ route('pdt.products.index') }}">Product</a></li>
        <li class=""><a href="javascript:void(0)">Create</a></li>
    </ul>
</div>


<div class="row">
    <div class="col-12">

        <div class="widget-body">
            <div class="widget-main">

                @if (request()->filled('upload'))
                    @include('product/_inc/create/_upload')
                @elseif(request()->filled('upload-variation'))
                    @include('product/_inc/create/_upload-variation')
                @else
                    <form class="form-horizontal mt-2" action="{{ route('pdt.products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        @include('partials._alert_message')
                        <ul class="nav nav-tabs" style="position: relative">
                            <li class="active"><a href="javascript:void(0)">BASIC INFORMATION</a></li>
                            <li><a href="javascript:void(0)">Price</a></li>
                            <li><a href="javascript:void(0)">Description</a></li>
                            <li><a href="javascript:void(0)">File</a></li>
                            <li><a href="javascript:void(0)">Advance</a></li>
                            <li><a href="javascript:void(0)">Finish</a></li>
                        </ul>

                        <div class="tab-content">
                            <input type="hidden" class="form-control" name="next_tab" value="price">
                            <div class="tab-pane active" id="navBasicInformation">
                                @include('product._inc.create._basic-information')
                                <div class="pull-right btn-group mt-4">
                                    <a class="btn btn-sm btn-theme mr-1" href="{{ route('pdt.products.index') }}"><i class="fa fa-long-arrow-left"></i> BACK TO LIST</a>
                                    <button class="btn btn-sm btn-next" type="submit">SAVE AND NEXT <i class="fa fa-long-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

@endsection


@section('js')

    <script>
        function getProductType(obj)
        {
            let productTypeId = $(obj).find('option:selected').data('product_type_id');

            $("#product_type_id option").each(function() {
                if ($(this).val() == productTypeId) {

                    $("#product_type_id option[value='" + productTypeId + "']").attr("selected", "selected");
                    productTypeData($('#product_type_id'))
                }
            });

            $('.select2').select2();
        }
    </script>


    <script src="{{ asset('assets/js/markdown.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-markdown.min.js') }}"></script>

    <script src="{{ asset('assets/js/bootstrap-wysiwyg.min.js') }}"></script>

    <script>
        $('#csv_upload').ace_file_input({
            style: 'well',
            btn_choose: 'Attach Product CSV file',
            btn_change: null,
            no_icon: 'ace-icon fa fa-cloud-upload',
            droppable: true,
            thumbnail: 'small',
            preview_error : function(filename, error_code) {}
        }).on('change', function() {});

        $('#sidebar').addClass('menu-min');
    </script>

    @include('product._inc._script')

    <script type="text/javascript">
        $(document).ready(function() {



            // DISCOUNT PERCENT TO FLAT AMOUNT
            $(document).on('keyup', '.discount-percentage', function() {
                let percent = Number($(this).val())
                let price   = Number($('.sale-price').val())

                if(percent > 100) {
                    percent = 100
                    $(this).val(100)
                }

                let discount = ((price * percent) / 100).toFixed(2)

                $('.discount-flat').val(discount)
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
