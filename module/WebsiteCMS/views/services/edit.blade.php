@extends('layouts.master')
@section('title', 'Edit Service')

@section('page-header')
    Edit Service
@stop

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <h4 class="pl-2"><i class="fa fa-plus"></i> @yield('page-header')</h4>

                <ul class="breadcrumb mb-1">
                    <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
                    <li><a class="text-muted" href="{{ route('website.services.index') }}">Blog</a></li>
                    <li class=""><a href="javascript:void(0)">Create</a></li>
                </ul>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('website.services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @include('partials._alert_message')

                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">

                                <!-- NAME -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Name <sup class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="name" id="name"
                                        value="{{ old('name', $service->name) }}" placeholder="Service Name" required>
                                        </div>

                                    @error('name')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Description <sup class="text-danger"></sup></span>
                                        <textarea name="description" id="description" class="form-control" placeholder="Service description">{{ old('description', $service->description) }}</textarea>
                                    </div>

                                    @error('description')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                {{-- Select icon or image --}}
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Icon Or Image <sup class="text-danger">*</sup></span>
                                        <div class="radio-btns">
                                            <label style="margin-right: 10px">
                                                @if ($service->icon == null)

                                                @else
                                                    <input type="radio" name="iconOrimage" id="same-btn icon-btn" value="icon" required checked>
                                                    <span>Icon</span>
                                                @endif
                                             </label>
                                            <label>
                                                @if ($service->image == null)

                                                @else
                                                    <input type="radio" name="iconOrimage" id="same-btn image-btn" value="image" required checked>
                                                    <span>Image</span>
                                                @endif
                                             </label>
                                        </div>
                                    </div>
                                    @error('icon')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- icon -->
                                <div class="form-group icon-div common-div" @if ($service->icon == null)
                                                                                style="display: none"
                                                                            @else
                                                                                style="display: block"
                                                                            @endif>
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Icon <sup class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="icon" id="icon"
                                        value="{{ old('icon', $service->icon) }}" placeholder="Services icon">
                                        </div>
                                    @error('icon')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>


                                <!-- IMAGE -->
                                <div class="form-group image-div common-div" @if ($service->image == null)
                                                                                style="display: none"
                                                                            @else
                                                                                style="display: block"
                                                                            @endif>
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Image <sup class="text-danger">*</sup></span>
                                        <input type="file" class="form-control" name="image">
                                    </div>
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="background-color: transparent !important; border:none !important;"></span>
                                        <small style="margin-left: 13px;"><b>Image size 50px x 50px ratio</b></small>
                                    </div>
                                    @if(!empty($service->image))
                                        <div class="input-group width-100">
                                            <span class="input-group-addon width-30" style="background-color: transparent !important; border:none !important; text-align: left">Previous Image</span>
                                            <img class="pt-1" src="{{ asset($service->image) }}" width="100" style="margin-left: 13px;">
                                        </div>
                                    @endif
                                    @error('image')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>


                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-sm-9 col-xs-4 text-right" for="form-field-1-1"> Status </label>
                                            <div class="col-sm-3 col-xs-8">
                                                <label>
                                                    <input name="status" class="ace ace-switch ace-switch-6" type="checkbox" @if(!empty($service->status)) checked @endif>
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- ACTION -->
                                <div class="btn-group pull-right">
                                    <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-save"></i> Save </button>
                                    <a href="{{ route('website.services.index') }}" class="btn btn-sm btn-secondary"> <i class="fa fa-list"></i> List </a>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    {{-- <script type="text/javascript">
        $(document).ready(function(){
            $('input[type="radio"]').click(function(){
                var val = $(this).attr("value");

                if (val == 'icon') {
                    $(".icon-div").show();
                    $(".image-div").hide();
                } else {
                    $(".image-div").show();
                    $(".icon-div").hide();
                }

            });
        });
    </script> --}}
@endsection
