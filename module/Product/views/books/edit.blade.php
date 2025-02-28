@extends('layouts.master')
@section('title', 'Create Brand')

@section('page-header')
    Add New Brand
@stop

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <h4 class="pl-2"><i class="fa fa-plus"></i> @yield('page-header')</h4>

                <ul class="breadcrumb mb-1">
                    <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
                    <li>Product Config</li>
                    <li><a class="text-muted" href="{{ route('pdt.books.index') }}">Brand</a></li>
                    <li class=""><a href="javascript:void(0)">Create</a></li>
                </ul>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('pdt.books.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('partials._alert_message')

                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">

                                <!-- PRODUCT TYPE -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Product Type <sup class="text-danger">*</sup></span>
                                        <select name="product_type_id" id="product_type_id" class="form-control select2" data-placeholder="--- Select ---" style="width: 100%">
                                            <option></option>
                                            @foreach($productTypes as $productType)
                                            <option {{ old('product_type_id', optional($productType)->id) == $brand->product_type_id ? 'selected' : '' }} value="{{ $productType->id }}">{{ $productType->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @error('product_type_id')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>


                                <!-- NAME -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Name <sup class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="name" id="name"
                                        value="{{ old('name', $brand->name) }}" placeholder="Brand Name" required>
                                        </div>

                                    @error('name')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>


                                    <!-- SLUG -->
                                    <div class="form-group">
                                        <div class="input-group width-100">
                                            <span class="input-group-addon width-30" style="text-align: left">Slug <sup class="text-danger">*</sup></span>
                                            <input type="text" class="form-control" name="slug" id="slug"
                                       value="{{ old('slug', $brand->slug) }}" placeholder="Brand Slug" required>
                                            </div>
                                        @error('slug')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>


                                <!-- TITLE -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Title <sup class="text-danger"></sup></span>
                                        <input type="text" class="form-control" name="title" id="title"
                                        value="{{ old('title', $brand->title) }}" placeholder="Brand Title">                                   </div>

                                    @error('title')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>


                                <!-- IMAGE -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Logo <sup class="text-danger"></sup></span>
                                        <input type="file" class="form-control" name="logo" @if(empty($brand->logo)) required @endif>
                                    </div>
                                    @if(!empty($brand->logo))
                                        <img class="pt-1" src="{{ asset($brand->logo) }}" width="100">
                                    @endif

                                    @error('lgog')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>


                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-sm-9 col-xs-4 text-right" for="form-field-1-1"> Show on Menu </label>
                                            <div class="col-sm-3 col-xs-8">
                                                <label>
                                                    <input name="show_on_menu" class="ace ace-switch ace-switch-6" type="checkbox" @if (!empty($brand->status)) checked @endif>
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-sm-9 col-xs-4 text-right" for="form-field-1-1"> Highlight </label>
                                            <div class="col-sm-3 col-xs-8">
                                                <label>
                                                    <input name="is_highlight" class="ace ace-switch ace-switch-6" type="checkbox" @if (!empty($brand->status)) checked @endif>
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-sm-9 col-xs-4 text-right" for="form-field-1-1"> Status </label>
                                            <div class="col-sm-3 col-xs-8">
                                                <label>
                                                    <input name="status" class="ace ace-switch ace-switch-6" type="checkbox" @if(!empty($brand->status)) checked @endif>
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- ACTION -->
                                <div class="btn-group pull-right">
                                    <button class="btn btn-sm btn-primary"> <i class="fa fa-save"></i> Save </button>
                                    <a href="{{ route('pdt.books.index') }}" class="btn btn-sm btn-secondary"> <i class="fa fa-list"></i> List </a>
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

@endsection
