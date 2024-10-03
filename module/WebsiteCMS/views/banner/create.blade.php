@extends('layouts.master')

@section('title')
    Add New Slider
@endsection

@section('page-header')
    <i class="fa fa-plus"></i> Add New Slider

@endsection



@section('css')
    <script src="https://cdn.ckeditor.com/4.17.2/standard/ckeditor.js"></script>
@endsection

@section('content')
    <div class="page-content no-print">
        <div class="row">

            @include('partials._alert_message')

            <div class="widget-box">
                <div class="widget-header">
                    <h5 class="widget-title">
                        <i class="ace-icon fa fa-plus-circle"></i>Add New Slider
                    </h5>
                    <span class="widget-toolbar">
                        <a href="{{ route('website.sliders.index') }}">
                            <i class="fa fa-list-alt"></i> Slider List
                        </a>
                    </span>

                </div>

                <form action="{{ route('website.sliders.store') }}" id="Form" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="widget-body">

                        <div class="row pt-2 pr-2">

                            <!-- Left side -->
                            <div class="col-sm-9">

                                <div class="row">
                                    <div class="col-sm-12 px-3">

                                        <!-- Title -->
                                        <div class="input-group width-100 mb-1">
                                            <span class="input-group-addon width-30" style="text-align: left">
                                                Name <span class="label-required"></span>
                                            </span>
                                            <input type="text" class="form-control @error('name') has-error @enderror" name="name" id="name" value="{{ old('name') }}">
                                            @error('name')<br>
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>

                                        <!-- Url -->
                                        <div class="form-group">
                                            <div class="input-group width-100">
                                                <span class="input-group-addon width-30" style="text-align: left">Banner Url <sup class="text-danger">*</sup></span>
                                                <input type="text" class="form-control" name="url" placeholder="Banner Url" required>
                                            </div>

                                            @error('url')
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>

                                        <!-- SHORT DESCRIPTION -->
                                        <div class="input-group width-100 mb-1">
                                            <span class="input-group-addon width-30" style="text-align: left">
                                                 Slug <span class="label-required"></span>
                                            </span>
                                            <input type="text" class="form-control @error('slug') has-error @enderror" name="slug" id="slug" value="{{ old('slug') }}">
                                            @error('slug')<br>
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Right Side -->
                            <div class="col-xs-3">
                                <div class="row" style="margin:0px">
                                        <!-- IMAGE -->
                                        <div class="input-group width-100 mb-1">
                                            <span class="input-group-addon width-30" style="text-align: left">
                                                Image
                                            </span>
                                            <input type="file" class="form-control @error('image') has-error @enderror" name="image" id="image">
                                            @error('image')<br>
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="input-group width-100">
                                            <span class="input-group-addon width-30" style="background-color: transparent !important; border:none !important;"></span>
                                            <small style="margin-left: 13px;"><b>Image size must be 550x125.</b></small>
                                        </div>

                                        <div class="input-group width-100 mb-1">
                                            <span class="input-group-addon width-30" style="text-align: left;backgroun-color:white;">
                                                Status
                                            </span>
                                            <label class="input-group-addon" style="margin-top: 7px">
                                                <input name="status" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                                                <span class="lbl"></span>
                                            </label>
                                        </div>
                                </div>
                            </div>




                            <div class="col-xs-12">

                                <!-- Add Page -->
                                <h5 class="widget-title">
                                    <div class="row" style="margin-top: 10px;padding:5px">

                                        <div class="col-md-12 text-right pr-2">
                                            <button type="submit" class="btn btn-primary btn-sm btn-block"
                                                style="max-width: 150px">
                                                <i class="fa fa-save"></i> Add New
                                            </button>
                                        </div>
                                    </div>
                                    <div class="space-10"></div>
                                </h5>
                            </div>

                        </div>
                    </div>
                </form>


            </div>

        </div>
    </div>
@endsection


@section('js')
    <script src="{{ asset('admin/assets/js/bootstrap-tag.min.js') }}"></script>


    <script src="{{ asset('admin/assets/custom_js/file_upload.js') }}"></script>


    <script>
        CKEDITOR.replace('summernote');
    </script>

    <script>
        var tag_input = $('#form-field-tags');
        try {
            tag_input.tag({
                placeholder: tag_input.attr('placeholder'),
                // source: ace.vars['US_STATES'],
                /**
                //or fetch data from database, fetch those that match "query"
                source: function(query, process) {
                  $.ajax({url: 'remote_source.php?q='+encodeURIComponent(query)})
                  .done(function(result_items){
                	process(result_items);
                  });
                }
                */
            })

            var $tag_obj = $('#form-field-tags').data('tag');
            var index = $tag_obj.inValues('some tag');
            $tag_obj.remove(index);
        } catch (e) {
            tag_input.after('<textarea id="' + tag_input.attr('id') + '" name="' + tag_input.attr('name') + '" rows="3">' +
                tag_input.val() + '</textarea>').remove();
        }
    </script>
@endsection
