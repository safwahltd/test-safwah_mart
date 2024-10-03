@extends('layouts.master')

@section('title')
        Create Page Section
@endsection

@section('page-header')
    <i class="fa fa-plus"></i> Create Page Section
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
                        <i class="ace-icon fa fa-plus-circle"></i>Create Page Section
                    </h5>
                    <span class="widget-toolbar">

                        <!--------------- INDEX---------------->
                        @if(hasPermission("website-cms.index", $slugs))
                            <a href="{{ route('website.page-sections.index') }}">
                                <i class="fa fa-list-alt"></i> Page Section List
                            </a>
                        @endif

                    </span>

                </div>

                <form action="{{ route('website.page-sections.store') }}" id="Form" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="widget-body">

                        <div class="row pt-2 pr-2">

                            <!-- Left side -->
                            <div class="col-sm-7">

                                <div class="row">
                                    <div class="col-sm-12 px-3">

                                        {{-- Page --}}
                                        <div class="input-group width-100 mb-1">
                                            <span class="input-group-addon width-30" style="text-align: left">
                                                Page <span class="label-required"></span>
                                            </span>
                                            <select name="page_id" id="page_id" class="form-control select2" value="{{ old('page_id') }}" data-placeholder="--- Select Country ---" style="width: 100%" required>
                                                <option value="">--- Select ---</option>
                                                @foreach ($pages ?? [] as $page)
                                                    <option value="{{ $page->id }}">{{ $page->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <!-- Title -->
                                        <div class="input-group width-100 mb-1">
                                            <span class="input-group-addon width-30" style="text-align: left">
                                                Title <span class="label-required"></span>
                                            </span>
                                            <input type="text" class="form-control @error('title') has-error @enderror" name="title" value="">
                                            @error('title')<br>
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>

                                        <!-- Short Description -->
                                        <div class="input-group width-100 mb-1">
                                            <span class="input-group-addon width-30" style="text-align: left">
                                                Short Description <span class="label-required"></span>
                                            </span>
                                            <textarea class="form-control" name="short_description" id="short_description" cols="30" rows="2" placeholder="Short Description" required></textarea>
                                            {{-- <textarea class="form-control" name="seo_description" id="seo_description" cols="30" rows="2" placeholder="SEO Description">{{ old('seo_description', $page->seo_description) }}</textarea> --}}
                                            @error('short_description')<br>
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>



                                        <div class="input-group width-100">
                                            <span class="input-group-addon width-30" style="text-align: left">
                                                background Image
                                            </span>
                                            <input type="file" class="form-control @error('background_image') has-error @enderror" name="background_image" id="background_image">
                                            @error('background_image')<br>
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="input-group width-100 mb-1">
                                            <span class="input-group-addon width-30" style="background-color: transparent !important; border:none !important;"></span>
                                            <small style="margin-left: 13px;"><b>Image size must be 1200x400.</b></small>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-9 col-xs-4 text-right" for="form-field-1-1"> Status </label>
                                            <div class="col-sm-3 col-xs-8">
                                                <label>
                                                    <input name="status" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <!-- Right Side -->
                            <div class="col-xs-5">
                                <div class="row" style="margin:0px">

                                        <!-- Show Quantity -->
                                        <div class="input-group width-100 mb-1">
                                            <span class="input-group-addon width-30" style="text-align: left">
                                                Show Quantity<span class="label-required"></span>
                                            </span>
                                            <input type="text" class="form-control @error('show_quantity') has-error @enderror" name="show_quantity" id="show_quantity" value="">
                                            @error('show_quantity')<br>
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>

                                        <!-- Title -->
                                        <div class="input-group width-100 mb-1">
                                            <span class="input-group-addon width-30" style="text-align: left">
                                                Button Title <span class="label-required"></span>
                                            </span>
                                            <input type="text" class="form-control @error('button_name') has-error @enderror" name="button_name" id="name" value="">
                                            @error('title')<br>
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>



                                        <!-- Button Slug -->
                                        <div class="input-group width-100 mb-1">
                                            <span class="input-group-addon width-30" style="text-align: left">
                                                Button Slug<span class="label-required"></span>
                                            </span>
                                            <input type="text" class="form-control @error('button_slug') has-error @enderror" name="button_slug" id="slug" value="">
                                            @error('button_slug')<br>
                                                <span class="text-danger">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-9 col-xs-4 text-right" for="form-field-1-1"> Button Status </label>
                                            <div class="col-sm-3 col-xs-8">
                                                <label>
                                                    <input name="button_status" class="ace ace-switch ace-switch-6" type="checkbox">
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
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
                                                <i class="fa fa-save"></i> Create
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
