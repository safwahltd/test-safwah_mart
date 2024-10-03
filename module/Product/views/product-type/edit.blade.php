@extends('layouts.master')
@section('title', 'Edit Product Type')

@section('page-header')
    Edit Product Type
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <h4 class="pl-2"><i class="fa fa-pencil"></i> @yield('page-header')</h4>

                <ul class="breadcrumb mb-1">
                    <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
                    <li>Product Config</li>
                    <li><a class="text-muted" href="{{ route('product-types.index') }}">Product Type</a></li>
                    <li class=""><a href="javascript:void(0)">Edit</a></li>
                </ul>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('product-types.update', $productType['id']) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('partials._alert_message')

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1-1"> Name<span class="label-required">*</span> </label>
                            <div class="col-sm-4 @error('name') has-error @enderror">
                                <input type="text" class="form-control" name="name" id="name"
                                       value="{{ old('name', $productType->name) }}" placeholder="Product Type Name" required>
                                @error('name')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1-1"> Slug<span class="label-required">*</span> </label>
                            <div class="col-sm-4 @error('slug') has-error @enderror">
                                <input type="text" class="form-control" name="slug" id="slug"
                                       value="{{ old('slug', $productType->slug) }}" placeholder="Product Type Slug" required>
                                <span style="font-size: 10.5px"><b>Use only alphanumeric value without space (Hyphen(-) allow)</b></span>
                                @error('slug')<br>
                                <span class="text-danger">
                                         {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1-1"> Description <span class="label-required"></span> </label>
                            <div class="col-sm-4 @error('description') has-error @enderror">
                                <input type="text" class="form-control" name="description" id="slug"
                                       value="{{ old('slug', $productType->description) }}" placeholder="Product Type Description">
                                @error('slug')<br>
                                <span class="text-danger">
                                         {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>


                        {{-- <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1-1"> Image<span class="label-required">*</span> </label>
                            <div class="col-sm-4 @error('image') has-error @enderror">
                                <input type="file" class="form-control" name="image" @if(empty($productType->image)) required @endif>
                                <small><b>image size must be 400x180.</b></small><br>
                                @if(!empty($productType->image))
                                    <img src="{{ asset($productType->image) }}" width="100%">
                                @endif
                                @error('image')<br>
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div> --}}

                        <div class="form-group" style="margin-top: -5px">
                            <label class="col-sm-2 col-xs-4 control-label" for="form-field-1-1" style="margin-left:-12px"> Status </label>
                            <div class="col-sm-4 col-xs-8">
                                <label style="margin-top: 7px">
                                    <input name="status" class="ace ace-switch ace-switch-6" type="checkbox" @if(!empty($productType->status)) checked @endif>
                                    <span class="lbl"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12 text-right">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-success"> <i class="fa fa-save"></i> Update </button>
                                    <a href="{{ route('product-types.index') }}" class="btn btn-sm btn-info"> <i class="fa fa-list"></i> List </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
