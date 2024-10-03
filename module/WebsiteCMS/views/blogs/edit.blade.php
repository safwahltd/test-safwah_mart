@extends('layouts.master')

@section('title', 'Edit Article')


@section('content')
    <div class="row">
        <div class="col-12">

            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <h4 class="pl-2"><i class="fa fa-plus"></i> Edit Article</h4>

                <ul class="breadcrumb mb-1">
                    <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
                    <li><a class="text-muted" href="{{ route('website.blogs.index') }}">Article</a></li>
                    <li class=""><a href="javascript:void(0)">Create</a></li>
                </ul>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('website.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @include('partials._alert_message')

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">

                                <!-- NAME -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Name <sup class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $blog->name) }}" placeholder="Article Name" required>
                                    </div>

                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <!-- SLUG -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Slug <sup class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug', $blog->slug) }}" placeholder="Article Slug" required>
                                    </div>

                                    @error('slug')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <!-- Description -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Description <sup class="text-danger"></sup></span>
                                        <textarea name="description" id="description" class="summernote form-control" placeholder="Article description">{{ old('description', $blog->description) }}</textarea>
                                    </div>

                                    @error('description')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>


                                <!-- IMAGE -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Image <sup class="text-danger"></sup></span>
                                        <input type="file" class="form-control" name="image" @if(empty($blog->image)) @endif>
                                    </div>
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="background-color: transparent !important; border:none !important;"></span>
                                        <small style="margin-left: 13px;"><b>Image size must be 550x350.</b></small>
                                    </div>

                                    @if(!empty($blog->image))
                                        <div class="input-group width-100">
                                            <span class="input-group-addon width-30" style="background-color: transparent !important; border:none !important; text-align: left">Previous Image</span>
                                            <img class="pt-1" src="{{ asset($blog->image) }}" width="100" style="margin-left: 13px;">
                                        </div>
                                     @endif

                                    @error('title')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>




                                
                                @if (hasAnyPermission(['website-cms.meta-tag'], $slugs))
                                    <!-- META TITLE  -->
                                    <div class="form-group">
                                        <div class="input-group width-100">
                                            <span class="input-group-addon width-30" style="text-align: left">Meta Title</span>
                                            <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title', $blog->meta_title) }}" placeholder="Meta Title Title">
                                        </div>
                                    </div>


                                    <!-- META DESCRIPTION -->
                                    <div class="form-group">
                                        <div class="input-group width-100">
                                            <span class="input-group-addon width-30" style="text-align: left">Meta Description</span>
                                            <textarea style="min-height: 70px" class="form-control" placeholder="Type Meta Description" name="meta_description">{{ old('meta_description', $blog->meta_description) }}</textarea>
                                        </div>
                                    </div>



                                    <!-- IMAGE ALT TAGE  -->
                                    <div class="form-group">
                                        <div class="input-group width-100">
                                            <span class="input-group-addon width-30" style="text-align: left">Alt Text</span>
                                            <input type="text" class="form-control" name="alt_text" value="{{ old('alt_text', $blog->alt_text) }}" placeholder="Meta Alt Text">
                                        </div>
                                    </div>
                                @endif 



                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-sm-9 col-xs-4 text-right" for="form-field-1-1"> Status </label>
                                            <div class="col-sm-3 col-xs-8">
                                                <label>
                                                    <input name="status" class="ace ace-switch ace-switch-6" type="checkbox" @if(!empty($blog->status)) checked @endif>
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- ACTION -->
                                <div class="btn-group pull-right">
                                    <button class="btn btn-sm btn-primary"> <i class="fa fa-save"></i> Save </button>
                                    <a href="{{ route('website.blogs.index') }}" class="btn btn-sm btn-secondary"> <i class="fa fa-list"></i> List </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
