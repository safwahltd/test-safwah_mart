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

                        <form class="form-horizontal mt-2" action="{{ route('pdt.product-uploads.update', $product->id) }}" enctype="multipart/form-data" method="POST">
                            @csrf
                            @method('PUT')
                                    <div class="row my-1">
                                        <div class="col-md-5">
                                            <div class="row">
                                                <!-- VAT APPLICABLE -->
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-md-5 col-xs-6 control-label" for="form-field-1-1"> Variation </label>
                                                        <div class="col-md-7 col-xs-6">
                                                            <label style="margin-top: 6px">
                                                                <input type="checkbox" class="ace ace-switch ace-switch-6" name="is_variation" id="is_variation" @if($product->is_variation == 'Yes') checked @endif disabled>
                                                                <span class="lbl"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                                


                                                

                                                <!-- REFUNDABLE -->
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-md-4 col-xs-6 control-label" for="form-field-1-1"> VAT </label>
                                                        <div class="col-md-8 col-xs-6">
                                                            <label style="margin-top: 6px">
                                                                <input type="checkbox" class="ace ace-switch ace-switch-6" name="vat_applicable" id="vat_applicable" @if(@old('vat_applicable') == true || $product->vat_applicable == 'Yes') checked @endif>
                                                                <span class="lbl"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>





                                        <div class="col-md-2">
                                            <div class="form-group row">
                                                <label class="col-md-6 col-xs-6 control-label" for="form-field-1-1"> Refundable </label>
                                                <div class="col-md-6 col-xs-6">
                                                    <label style="margin-top: 6px">
                                                        <input type="checkbox" class="ace ace-switch ace-switch-6" name="is_refundable" id="is_refundable" @if(@old('is_refundable') == true || $product->is_refundable == 'Yes') checked @endif>
                                                        <span class="lbl"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        




                                        <div class="col-md-5">
                                            <div class="row">
                                                <!-- HIGHLIGHT -->
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-md-8 col-xs-6 control-label" for="form-field-1-1"> Highlight </label>
                                                        <div class="col-md-4 col-xs-6">
                                                            <label style="margin-top: 6px">
                                                                <input type="checkbox" class="ace ace-switch ace-switch-6" name="is_highlight" id="is_highlight"  @if(@old('is_highlight') == true || $product->is_highlight == 'Yes') checked @endif>
                                                                <span class="lbl"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>





                                                <!-- STATUS -->
                                                <div class="col-md-6">
                                                    <div class="form-group row">
                                                        <label class="col-md-8 col-xs-6 control-label" for="form-field-1-1"> Status </label>
                                                        <div class="col-md-4 col-xs-6">
                                                            <label style="margin-top: 6px">
                                                                <input type="checkbox" class="ace ace-switch ace-switch-6" name="status" id="status" @if(@old('status') == true || $product->status == 1) checked @endif>
                                                                <span class="lbl"></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>




                                    <div class="row">


                                        <div class="col-md-6">


                                            <!-- PRODUCT TYPE -->
                                            <div class="input-group width-100 mb-1">
                                                <span class="input-group-addon width-30" style="text-align: left">
                                                    Product Type <span class="label-required">*</span>
                                                </span>
                                                <select name="product_type" id="product_type" class="form-control select2" data-placeholder="--- Select ---" required style="width: 100%">
                                                    <option></option>
                                                    <option value="{{ $productType->id }}" 
                                                        data-categories="{{ $productType->categories }}"
                                                        data-brands="{{ $productType->brands }}" selected readonly
                                                        >{{ $productType->name }}
                                                    </option>
                                                </select> 
                                            </div>





                                            <!-- CATEGORY -->
                                            <div class="input-group width-100 mb-1">
                                                <span class="input-group-addon width-30" style="text-align: left">
                                                    Category <span class="label-required">*</span>
                                                </span>
                                                <input type="text" class="form-control only-number" name="category" id="category" value="{{ $product->category }}" autocomplete="off">
                                            </div>





                                            <!-- BRAND -->
                                            <div class="input-group width-100 mb-1">
                                                <span class="input-group-addon width-30" style="text-align: left">
                                                    Brand
                                                </span>
                                                <input type="text" class="form-control only-number" name="brand" id="brand" value="{{ $product->brand }}" autocomplete="off">
                                            </div>





                                            <!-- UNIT -->
                                            <div class="input-group width-100 mb-1">
                                                <span class="input-group-addon width-30" style="text-align: left">
                                                    Unit <span class="label-required">*</span>
                                                </span>
                                                <input type="text" class="form-control only-number" name="unit_measure" id="unit_measure" value="{{ $product->unit_measure }}" autocomplete="off">
                                            </div>





                                            <!-- NAME -->
                                            <div class="input-group width-100 mb-1">
                                                <span class="input-group-addon width-30" style="text-align: left">
                                                    Product Name <span class="label-required">*</span>
                                                </span>
                                                <input type="text" class="form-control" name="name" id="name" value="{{ $product->name }}" required>
                                            </div>





                                            <!-- CODE -->
                                            <div class="input-group width-100">
                                                <span class="input-group-addon width-30" style="text-align: left">
                                                    Product Code
                                                </span>
                                                <input type="text" class="form-control" name="code" id="code" value="{{ $product->code }}">
                                            </div>
                                            <span id="code_error" class="text-danger"></span>

                                        </div>





                                        <div class="col-md-6">


                                            <!-- SLUG -->
                                            <div class="input-group width-100">
                                                <span class="input-group-addon width-30" style="text-align: left">
                                                    Product Slug
                                                </span>
                                                <input type="text" class="form-control" name="slug" id="slug" value="{{ $product->slug }}">
                                            </div>
                                            <span id="slug_error" class="text-danger"></span>





                                            <!-- PURCHASE PRICE -->
                                            <div class="input-group width-100 my-1">
                                                <span class="input-group-addon width-30" style="text-align: left">
                                                    Purchase Price
                                                </span>
                                                <input type="text" class="form-control only-number" name="purchase_price" id="purchase_price" value="{{ $product->purchase_price }}" autocomplete="off">
                                            </div>





                                            <!-- SALE PRICE -->
                                            <div class="input-group width-100 mb-1">
                                                <span class="input-group-addon width-30" style="text-align: left">
                                                    Sale Price
                                                </span>
                                                <input type="text" class="form-control only-number" name="sale_price" id="sale_price" value="{{ $product->sale_price }}" autocomplete="off">
                                            </div>





                                            <!-- WEIGHT -->
                                            <div class="input-group width-100 mb-1">
                                                <span class="input-group-addon width-30" style="text-align: left">
                                                    Weight (KG)
                                                </span>
                                                <input type="text" class="form-control" name="weight" id="weight" value="{{ $product->weight }}">
                                            </div>





                                            <!-- COUNTRY ORIGIN -->
                                            <div class="input-group width-100 mb-1">
                                                <span class="input-group-addon width-30" style="text-align: left">
                                                    Country Origin
                                                </span>
                                                <input type="text" class="form-control" name="country" id="country" value="{{ $product->country }}" autocomplete="off">
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
