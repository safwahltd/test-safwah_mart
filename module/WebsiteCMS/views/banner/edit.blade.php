@extends('layouts.master')
@section('title', 'Edit Banner')


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <h4 class="pl-2"><i class="fa fa-plus"></i> @yield('title')</h4>

                <ul class="breadcrumb mb-1">
                    <li><a href="{{ route('home') }}"><i class="ace-icon fa fa-home"></i></a></li>
                    <li>Inventory</li>
                    <li><a class="text-muted" href="{{ route('website.banners.index') }}">Banner</a></li>
                    <li class=""><a href="javascript:void(0)">Edit</a></li>
                </ul>
            </div>


            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('website.banners.update', $banner->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('partials._alert_message')

                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">


                                <!-- NAME -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Banner Name <sup class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="name" value="{{ old('name', $banner->name) }}" placeholder="Banner Name" readonly required>
                                    </div>

                                    @error('name')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- Url -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Banner Url <sup class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="url" value="{{ old('url', $banner->url) }}" placeholder="Banner Url" required>
                                    </div>

                                    @error('url')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>




                                @if (hasAnyPermission(['website-cms.meta-tag'], $slugs))
                                    <!-- META TITLE  -->
                                    <div class="form-group">
                                        <div class="input-group width-100">
                                            <span class="input-group-addon width-30" style="text-align: left">Meta Title</span>
                                            <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title', $banner->meta_title) }}" placeholder="Meta Title Title">
                                        </div>
                                    </div>


                                    <!-- META DESCRIPTION -->
                                    <div class="form-group">
                                        <div class="input-group width-100">
                                            <span class="input-group-addon width-30" style="text-align: left">Meta Description</span>
                                            <textarea style="min-height: 70px" class="form-control" placeholder="Type Meta Description" name="meta_description">{{ old('meta_description', $banner->meta_description) }}</textarea>
                                        </div>
                                    </div>



                                    <!-- IMAGE ALT TAGE  -->
                                    <div class="form-group">
                                        <div class="input-group width-100">
                                            <span class="input-group-addon width-30" style="text-align: left">Alt Text</span>
                                            <input type="text" class="form-control" name="alt_text" value="{{ old('alt_text', $banner->alt_text) }}" placeholder="Meta Alt Text">
                                        </div>
                                    </div>
                                @endif 

                                <!-- IMAGE -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Image</span>
                                        <input type="file" class="form-control ace-file-upload" name="image">
                                    </div>
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="background-color: transparent !important; border:none !important;"></span>
                                        <small style="margin-left: 13px;"><b>Image size must be 540x120.</b></small>
                                    </div>
                                    @error('image')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                <div class="input-group width-100 mb-2">
                                    <span class="input-group-addon width-30" style="background-color: transparent !important; border:none !important; text-align: left">Previous Image</span>
                                    <img src="{{ asset($banner->image) }}" width="220" height="50" style="margin-left: 11px;">
                                </div>
                                <div class="input-group width-100">
                                    <span class="input-group-addon width-30" style="background-color: transparent !important; border:none !important;"></span>
                                    <small style="margin-left: 13px;"><b>Image size must be 550x125.</b></small>
                                </div>

                                <!-- Status -->
                                <div class="form-group">
                                    <label class="col-sm-2 col-xs-4 control-label" for="form-field-1-1"> Status </label>
                                    <div class="col-sm-4 col-xs-8">
                                        <label style="margin-left:-5px; margin-top: 7px">
                                            <input name="status" class="ace ace-switch ace-switch-6" type="checkbox" @if(!empty($banner->status)) checked @endif>
                                            <span class="lbl"></span>
                                        </label>
                                    </div>
                                </div>

                                <!-- ACTION -->
                                <div class="btn-group pull-right">
                                    <button class="btn btn-sm btn-primary"> <i class="fa fa-save"></i> Update </button>
                                    <a href="{{ route('website.banners.index') }}" class="btn btn-sm btn-secondary"> <i class="fa fa-list"></i> List </a>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
