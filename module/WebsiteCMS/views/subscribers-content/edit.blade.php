@extends('layouts.master')
@section('title', 'Edit Subscribers Content')

@section('page-header')
    Edit Subscribers Content
@stop

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <h4 class="pl-2"><i class="fa fa-plus"></i> @yield('page-header')</h4>

                <ul class="breadcrumb mb-1">
                    <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
                    <li><a class="text-muted" href="{{ route('website.subscribers-content.index') }}">Subscribers Content</a></li>
                    {{-- <li class=""><a href="javascript:void(0)">Create</a></li> --}}
                </ul>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('website.subscribers-content.update', $subscriberContent->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @include('partials._alert_message')

                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">

                                <!-- title -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">title <sup class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="title" id="title"
                                        value="{{ old('title', $subscriberContent->title) }}" placeholder="Subscriber Content title" required>
                                        </div>

                                    @error('title')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>


                                <!-- description -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Short Description <sup class="text-danger">*</sup></span>
                                        <textarea name="description" id="description" class="form-control" placeholder="Subscriber Content description" required>{{ old('description', $subscriberContent->description) }}</textarea>
                                    @error('description')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>




                                <!-- placeholder -->
                                <div class="form-group">
                                    <div class="input-group width-100" style="margin: 10px 10px 0 10px;">
                                        <span class="input-group-addon width-30" style="text-align: left; width: 29% !important;">placeholder <sup class="text-danger"></sup></span>
                                        <textarea style="width: 95%;" name="placeholder" id="placeholder" class="form-control" placeholder="Subscriber Content placeholder">{{ old('placeholder', $subscriberContent->placeholder) }}</textarea>
                                    </div>

                                    @error('placeholder')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>


                                <!-- button -->
                                <div class="form-group">
                                    <div class="input-group width-100" style="margin: 10px 10px 0 10px;">
                                        <span class="input-group-addon width-30" style="text-align: left; width: 29% !important;">Button Name <sup class="text-danger"></sup></span>
                                        <input style="width: 95%;" type="text" class="form-control" name="button" id="button" value="{{ old('button', $subscriberContent->button) }}" placeholder="Subscriber Content button"> </div>
                                    </div>

                                    @error('button')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>


                                <!-- IMAGE -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Image <sup class="text-danger"></sup></span>
                                        <input type="file" class="form-control" name="image" @if(empty($subscriberContent->image)) @endif>
                                    </div>
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="background-color: transparent !important; border:none !important;"></span>
                                        <small style="margin-left: 13px;"><b>Image size must be 1200x120.</b></small>
                                    </div>
                                    @if(!empty($subscriberContent->image))
                                        <img class="pt-1" src="{{ asset($subscriberContent->image) }}" width="100">
                                     @endif

                                    @error('title')
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
                                                    <input name="status" class="ace ace-switch ace-switch-6" type="checkbox" @if (!empty($subscriberContent->status)) checked @endif>
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- ACTION -->
                                <div class="btn-group pull-right">
                                    <button class="btn btn-sm btn-primary"> <i class="fa fa-save"></i> Save </button>
                                    <a href="{{ route('website.subscribers-content.index') }}" class="btn btn-sm btn-secondary"> <i class="fa fa-list"></i> List </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
