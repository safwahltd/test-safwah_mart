@extends('layouts.master')
@section('title', 'Edit Page')


@section('content')

    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-edit"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li>Website CMS</li>
            <li>

                <!--------------- INDEX---------------->
                @if(hasPermission("website-cms.index", $slugs))
                     <a class="text-muted" href="{{ route('website.pages.index') }}">Page</a>
                @endif
                
            </li>
            <li class=""><a href="javascript:void(0)">Edit</a></li>
        </ul>
    </div>


    <div class="row">
        <div class="col-12">


            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('website.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('partials._alert_message')

                        <div class="row ml-0 mr-0" style="display: flex; justify-content:space-between">
                            <div class="col-md-5">

                                <!-- NAME -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-35" style="text-align: left">Page Name <sup class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $page->name) }}" placeholder="Page Name" autocomplete="off" required>
                                    </div>

                                    @error('name')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>





                                <!-- SLUG -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-35" style="text-align: left">Page Slug <sup class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug', $page->slug) }}" placeholder="Page Slug" autocomplete="off" required>
                                    </div>

                                    @error('slug')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>





                                <!-- IMAGE -->
                                {{-- <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-35" style="text-align: left">Image</span>
                                        <input type="file" class="form-control" name="image">
                                    </div>

                                    @error('image')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                    @if(file_exists($page->image))
                                        <div class="my-1">
                                            <img src="{{ asset($page->image) }}" width="100px" height="100px" alt="Banner Image">
                                        </div>
                                    @endif
                                </div> --}}





                                <!-- BANNER IMAGE -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-35" style="text-align: left">Banner Image</span>
                                        <input type="file" class="form-control" name="banner_image">
                                    </div>
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-35" style="background-color: transparent !important; border:none !important;"></span>
                                        <small style="margin-left: 13px;"><b>Image size must be 1200x400.</b></small>
                                    </div>
                                    @error('banner_image')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                    @if(file_exists($page->banner_image))
                                        <div class="input-group width-100">
                                            <span class="input-group-addon width-35" style="background-color: transparent !important; border:none !important; text-align: left">Previous Image</span>
                                            <img class="pt-1" src="{{ asset($page->banner_image) }}" width="80" height="60" style="margin-left: 13px;">
                                        </div>
                                    @endif
                                </div>
                            </div>
                            



                            <div class="col-md-5">

                                @if (hasAnyPermission(['website-cms.meta-tag'], $slugs))
                                    <!-- SEO TITLE -->
                                    <div class="form-group mb-1">
                                        <div class="input-group width-100">
                                            <span class="input-group-addon width-35" style="text-align: left">SEO Title</span>
                                            <input type="text" class="form-control" name="seo_title" id="seo_title" value="{{ old('seo_title', $page->seo_title) }}" placeholder="SEO Title" autocomplete="off">
                                        </div>

                                        @error('seo_title')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>





                                    <!-- SEO DESCRIPTION -->
                                    <div class="form-group mb-1">
                                        <div class="input-group width-100">
                                            <span class="input-group-addon width-35" style="text-align: left">SEO Description</span>
                                            <textarea class="form-control" name="seo_description" id="seo_description" cols="30" rows="2" placeholder="SEO Description">{{ old('seo_description', $page->seo_description) }}</textarea>
                                        </div>

                                        @error('seo_description')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                @endif





                                <!-- SERIAL NO -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-35" style="text-align: left">Serial No <sup class="text-danger">*</sup></span>
                                        <input type="number" class="form-control" name="serial_no" value="{{ old('serial_no', $page->serial_no) }}" placeholder="Serial No" autocomplete="off" required>
                                    </div>

                                    @error('serial_no')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                
                                



                                <!-- STATUS & SHOW IN QUICK LINKS -->
                                <div class="form-group" style="margin-top: -5px">
                                    <div class="row">
                                        <label class="col-sm-2 control-label" for="form-field-1-1" style="margin-left:-5px"> Status </label>
                                        <div class="col-sm-2">
                                            <div class="material-switch pt-1 pl-3">
                                                <input type="checkbox" name="status" id="status" @if($page->status == 1 || old('status') == 'yes') checked @endif />
                                                <label for="status" class="badge-primary"></label>
                                            </div>
                                        </div>

                                        <label class="col-sm-6 control-label" for="form-field-1-1" style="margin-left:-12px; text-align: right"> Show in Quick Links </label>
                                        <div class="col-sm-2">
                                            <div class="material-switch pt-1 pl-3">
                                                <input type="checkbox" name="show_in_quick_links" id="showInQuickLinks" @if($page->show_in_quick_links == 1 || old('show_in_quick_links') == 'yes') checked @endif />
                                                <label for="showInQuickLinks" class="badge-primary"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="row" style="display: flex; justify-content:space-between">
                            <div class="col-md-11">

                                <!-- DESCRIPTION -->
                                <div class="form-group mb-1">
                                    <textarea class="form-control tiny-editor" name="description" id="description" cols="30" placeholder="Description ...">{!! old('description', $page->description) !!}</textarea>

                                    @error('description')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>




                                <!-- ACTION -->
                                <div class="btn-group pull-right mt-2">
                                    <button class="btn btn-sm btn-primary"> <i class="far fa-edit"></i> UPDATE </button>
                                    <a href="{{ route('website.pages.index') }}" class="btn btn-sm btn-secondary"> <i class="fa fa-list"></i> LIST </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
