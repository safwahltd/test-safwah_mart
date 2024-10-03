@extends('layouts.master')
@section('title', 'Create Product Tag')

@section('page-header')
    Add New Product Tag
@stop

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <h4 class="pl-2"><i class="fa fa-plus"></i> @yield('page-header')</h4>

                <ul class="breadcrumb mb-1">
                    <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
                    <li>Product Config</li>
                    <li><a class="text-muted" href="{{ route('pdt.product-tags.index') }}">Product Tag</a></li>
                    <li class=""><a href="javascript:void(0)">Create</a></li>
                </ul>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('pdt.product-tags.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('partials._alert_message')

                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">

                                <!-- NAME -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Name <sup class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="name" id="name"
                                        value="{{ old('name') }}" placeholder="Product Tag Name" required>
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
                                            value="{{ old('slug') }}" placeholder="Product Tag Slug" required>
                                            </div>
                                        @error('slug')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>



                                <div class="row">

                                    <div class="col-md-5">
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
                                    <button class="btn btn-sm btn-primary"> <i class="fa fa-save"></i> Save </button>
                                    <a href="{{ route('pdt.product-tags.index') }}" class="btn btn-sm btn-secondary"> <i class="fa fa-list"></i> List </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
