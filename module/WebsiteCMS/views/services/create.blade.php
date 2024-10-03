@extends('layouts.master')
@section('title', 'Create Services')

@section('page-header')
    Add New Services
@stop

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <h4 class="pl-2"><i class="fa fa-plus"></i> @yield('page-header')</h4>

                <ul class="breadcrumb mb-1">
                    <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
                    <li>Product Config</li>
                    <li><a class="text-muted" href="{{ route('website.services.index') }}">Services</a></li>
                    <li class=""><a href="javascript:void(0)">Create</a></li>
                </ul>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('website.services.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('partials._alert_message')

                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">

                                <!-- NAME -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Name <sup class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="name" id="name"
                                        value="{{ old('name') }}" placeholder="Services Name" required>
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
                                        <textarea name="description" id="description" class="form-control" placeholder="Services description">{{ old('description') }}</textarea>
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
                                                <input type="radio" name="iconOrimage" id="icon-btn" value="icon" required>
                                                <span>Icon</span>
                                             </label>
                                            <label>
                                                <input type="radio" name="iconOrimage" id="image-btn" value="image" required>
                                                <span>Image</span>
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
                                <div class="form-group icon-div common-div" style="display: none">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Icon <sup class="text-danger">*</sup></span>
                                        <input type="text" class="form-control fontawesome" autocomplete="off" name="icon" id="icon"
                                        value="{{ old('icon') }}" placeholder="Services icon">
                                        </div>
                                    @error('icon')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>


                                <!-- IMAGE -->
                                <div class="form-group image-div common-div" style="display: none">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Image <sup class="text-danger">*</sup></span>
                                        <input type="file" class="form-control" name="image" id="image">
                                    </div>
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="background-color: transparent !important; border:none !important;"></span>
                                        <small style="margin-left: 13px;"><b>Image size 50px x 50px ratio</b></small>
                                    </div>
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
                                                    <input name="status" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- ACTION -->
                                <div class="btn-group pull-right">
                                    <button class="btn btn-sm btn-primary" type="submit" id="save-button"> <i class="fa fa-save"></i> Save </button>
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
    <script type="text/javascript">

        $(document).ready(function(){

            $('input[type="radio"]').click(function(){
                var val = $(this).attr("value");

                if (val == 'icon') {

                    $(".icon-div").show();
                    $(".image-div").hide();
                    $("#icon").prop('required',true);
                    $("#image").prop('required',false);

                } else {
                    $(".image-div").show();
                    $(".icon-div").hide();
                    $("#image").prop('required',true);
                    $("#icon").prop('required',false);
                }

            });


            // if (save-button) {

            // }

        });

    </script>
@endsection
