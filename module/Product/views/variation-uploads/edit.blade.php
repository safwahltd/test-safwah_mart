@extends('layouts.master')

@section('title', 'Edit Product')

@section('page-header')
    <i class="fa fa-plus-circle"></i> Edit Product
@stop



@section('content')

    <div class="row">
        <div class="col-md-12">


            @include('partials._alert_message')




            <div class="widget-box">


                <!-- header -->
                <div class="widget-header">
                    <h4 class="widget-title"> @yield('page-header')</h4>
                    <span class="widget-toolbar">
                        <a href="{{ route('pdt.product-uploads.index') }}" class="">
                            <i class="fa fa-list-alt"></i> Product List
                        </a>
                    </span>
                </div>



                <!-- body -->
                <div class="widget-body">
                    <div class="widget-main">

                        <form class="form-horizontal mt-2" action="{{ route('pdt.product-variation-uploads.update', $variation->id) }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            @method('PUT')
                                
                                    <div class="row">


                                        <div class="col-md-6">


                                            <!-- PRODUCT UPLOAD ID -->
                                            <div class="input-group width-100 mb-1">
                                                <span class="input-group-addon width-30" style="text-align: left">
                                                    Pdt Upload Id  <span class="label-required">*</span>
                                                </span>
                                                <input type="text" class="form-control" name="product_upload_id" id="product_upload_id " value="{{ $variation->product_upload_id  }}" required>
                                            </div>


                                            <!-- NAME -->
                                            <div class="input-group width-100 mb-1">
                                                <span class="input-group-addon width-30" style="text-align: left">
                                                    Product Name <span class="label-required">*</span>
                                                </span>
                                                <input type="text" class="form-control" name="name" id="name" value="{{ $variation->name }}" required>
                                            </div>


                                            <!-- Opening Stock -->
                                            <div class="input-group width-100 mb-1">
                                                <span class="input-group-addon width-30" style="text-align: left">
                                                    Opening Stock <span class="label-required">*</span>
                                                </span>
                                                <input type="text" class="form-control" name="opening_stock" id="name" value="{{ $variation->opening_stock}}" required>
                                            </div>




                                            <!-- CODE -->
                                            <div class="input-group width-100">
                                                <span class="input-group-addon width-30" style="text-align: left">
                                                    SKU
                                                </span>
                                                <input type="text" class="form-control" name="sku" id="sku" value="{{ $variation->sku }}">
                                            </div>
                                            <span id="code_error" class="text-danger"></span>


                                     

                                        </div>





                                        <div class="col-md-6">


                                            <!-- PURCHASE PRICE -->
                                            <div class="input-group width-100 my-1 mt-0">
                                                <span class="input-group-addon width-30" style="text-align: left">
                                                    Purchase Price
                                                </span>
                                                <input type="text" class="form-control only-number" name="purchase_price" id="purchase_price" value="{{ $variation->purchase_price }}" autocomplete="off">
                                            </div>





                                            <!-- SALE PRICE -->
                                            <div class="input-group width-100 mb-1">
                                                <span class="input-group-addon width-30" style="text-align: left">
                                                    Sale Price
                                                </span>
                                                <input type="text" class="form-control only-number" name="sale_price" id="sale_price" value="{{ $variation->sale_price }}" autocomplete="off">
                                            </div>


                                            <!-- WAREHOUSE ID -->
                                            <div class="input-group width-100 mb-1">
                                                <span class="input-group-addon width-30" style="text-align: left">
                                                    Warehouse Id
                                                </span>
                                                <input type="text" class="form-control only-number" name="warehouse_id" id="warehouse_id" value="{{ $variation->warehouse_id }}" autocomplete="off">
                                            </div>
                                   

                                            <!-- IMAGE -->
                                            {{-- <div class="input-group width-100 mb-1">
                                                <span class="input-group-addon width-30" style="text-align: left">
                                                    Image <span class="label-required">*</span>
                                                </span>
                                                <input type="file" class="form-control" onchange="convertImageToBase64(this)" required>
                                                <textarea id="productImage" style="display: none"></textarea>
                                            </div> --}}


                                        </div>


                                    </div>


                                </div>

                            </div>

                            <!-- Action -->
                            <div class="form-group">
                                <div class="text-center col-md-2 col-md-offset-10 mt-3">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Update
                                    </button>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('js')


    <script src="{{ asset('assets/custom_js/file_upload.js') }}"></script>

    <script>
        function barcode_generate(length) {
            var result = '';
            var characters = '0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }
        $('#barcode_generate').on('click', function() {
            $('#product_barcode').val(barcode_generate(5));
        })



        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $(".ace-file-upload").change(function() {
            readURL(this);
        });
    </script>
@endsection
