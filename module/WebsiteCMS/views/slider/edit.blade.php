@extends('layouts.master')

@section('title')
        Edit Slider
@endsection

@section('page-header')
    <i class="fa fa-plus"></i> Edit Slider

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
                        <i class="ace-icon fa fa-plus-circle"></i>Create Slider
                    </h5>
                    <span class="widget-toolbar">
                        <!--------------- INDEX---------------->
                        @if(hasPermission("website-cms.index", $slugs))
                            <a href="{{ route('website.sliders.index') }}">
                                <i class="fa fa-list-alt"></i> Slider List
                            </a>
                        @endif
                    </span>

                </div>

                <form action="{{ route('website.sliders.update',$slider->id) }}" id="Form" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="widget-body">

                        <div class="row pt-2 pr-2">

                            <!-- Left side -->
                            <div class="col-sm-7">

                                <div class="row">
                                    <div class="col-sm-12 px-3">

                                        <!-- NAME -->
                                        <div class="input-group width-100 mb-1">
                                            <span class="input-group-addon width-30" style="text-align: left">
                                                Name <span class="label-required"></span>
                                            </span>
                                            <input type="text" class="form-control @error('title') has-error @enderror" name="name" id="name" value="{{ $slider->name }}">
                                            @error('title')<br>
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>


                                          <!-- SLUG -->
                                          <div class="input-group width-100 mb-1">
                                            <span class="input-group-addon width-30" style="text-align: left">
                                                 Slug <span class="label-required"></span>
                                            </span>
                                            <input type="text" class="form-control @error('slug') has-error @enderror" name="slug" id="slug" value="{{ $slider->slug }}">
                                            @error('slug')<br>
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>









                                        <div class="input-group width-100">
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
                                        <div class="input-group width-100 mb-1">
                                            <span class="input-group-addon width-30" style="background-color: transparent !important; border:none !important;"></span>
                                            <small style="margin-left: 13px;"><b>Image size must be 1140x280. </b><b style="color: red"> (NB: Slider "height" must be 280px)</b></small>
                                        </div>
                                        <div class="input-group width-100 mb-3">
                                            <span class="input-group-addon width-30" style="background-color: transparent !important; border:none !important; text-align: left">Previous Image</span>
                                            <img class="pt-1" src="{{ asset($slider->image) }}" width="300" height="100" style="margin-left: 13px;">
                                        </div>



                                        <div class="input-group width-100">
                                            <span class="input-group-addon width-30" style="text-align: left">
                                                Status
                                            </span>
                                            <label style="margin: 5px 0 0 8px">
                                                <input name="status" class="ace ace-switch ace-switch-6" type="checkbox" {{ $slider->status == 1 ? 'checked' : '' }}>
                                                <span class="lbl"></span>
                                            </label>
                                        </div>

                                    </div>
                                </div>
                            </div>


                            <!-- Right Side -->
                            <div class="col-xs-5">
                                <div class="row" style="margin:0px">


                                    @if (hasAnyPermission(['website-cms.meta-tag'], $slugs))
                                        <!-- META TITLE  -->
                                        <div class="form-group">
                                            <div class="input-group width-100">
                                                <span class="input-group-addon width-30" style="text-align: left">Meta Title</span>
                                                <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title', $slider->meta_title) }}" placeholder="Meta Title Title">
                                            </div>
                                        </div>


                                        <!-- META DESCRIPTION -->
                                        <div class="form-group">
                                            <div class="input-group width-100">
                                                <span class="input-group-addon width-30" style="text-align: left">Meta Description</span>
                                                <textarea style="min-height: 70px" class="form-control" placeholder="Type Meta Description" name="meta_description">{{ old('meta_description', $slider->meta_description) }}</textarea>
                                            </div>
                                        </div>



                                        <!-- IMAGE ALT TAGE  -->
                                        <div class="form-group">
                                            <div class="input-group width-100">
                                                <span class="input-group-addon width-30" style="text-align: left">Alt Text</span>
                                                <input type="text" class="form-control" name="alt_text" value="{{ old('alt_text', $slider->alt_text) }}" placeholder="Meta Alt Text">
                                            </div>
                                        </div>
                                    @endif



                                    <!-- Title -->
                                    <div class="input-group width-100 mb-1">
                                        <span class="input-group-addon width-30" style="text-align: left">
                                            Button Title <span class="label-required"></span>
                                        </span>
                                        <input type="text" class="form-control @error('button_title') has-error @enderror" name="button_title" id="button_title" value="{{ $slider->button_title }}">
                                        @error('title')<br>
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>



                                    <!-- Title -->
                                    <div class="input-group width-100 mb-1">
                                        <span class="input-group-addon width-30" style="text-align: left">
                                            Button Icon<span class="label-required"></span>
                                        </span>
                                        <input type="text" class="form-control @error('button_icon') has-error @enderror" name="button_icon" id="button_icon" value="">
                                        @error('icon')<br>
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>


                                    <!-- Title -->
                                    <div class="input-group width-100 mb-1">
                                        <span class="input-group-addon width-30" style="text-align: left">
                                            Button Url<span class="label-required"></span>
                                        </span>
                                        <input type="text" class="form-control @error('button_url') has-error @enderror" name="button_url" id="button_url" value="{{ $slider->button_url }}">
                                        @error('title')<br>
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">
                                            Button Status
                                        </span>
                                        <label style="margin: 5px 0 0 8px">
                                            <input name="status" class="ace ace-switch ace-switch-6" type="checkbox" {{ $slider->button_status == 1 ? 'checked' : '' }}>
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
                                                <i class="fa fa-save"></i> Update
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
