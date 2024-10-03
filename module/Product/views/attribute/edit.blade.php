@extends('layouts.master')
@section('title', 'Edit Attribute')


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <h4 class="pl-2"><i class="fa fa-plus"></i> @yield('title')</h4>

                <ul class="breadcrumb mb-1">
                    <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
                    <li>Product</li>
                    <li><a class="text-muted" href="{{ route('pdt.attributes.index') }}">Attribute</a></li>
                    <li class=""><a href="javascript:void(0)">Edit</a></li>
                </ul>
            </div>


            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('pdt.attributes.update', $attribute->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('partials._alert_message')

                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">

                                <!-- ATTRIBUTE TYPE -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Attribute Type <sup class="text-danger">*</sup></span>
                                        <select name="attribute_type_id" id="attribute_type_id" class="form-control select2" data-placeholder="--- Select ---" style="width: 100%">
                                            <option></option>
                                            @foreach($attributeTypes as $id => $value)
                                                <option value="{{ $id }}" {{ $id == $attribute->attribute_type_id ? 'selected':'' }}>{{ $value}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @error('attribute_type_id')
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
                                        value="{{ old('name', $attribute->name) }}" placeholder="Unit Measure Name" required>                                    </div>
                                    @error('name')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- COLOR CODE -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Color Code</span>
                                        <input type="text" class="form-control colorpicker-element" name="color_code" id="colorpicker1" value="{{ old('color_code', $attribute->color_code) }}" placeholder="#ffffff" autocomplete="off">
                                    </div>

                                    @error('color_code')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>


                                <!-- DESCRIPTION -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Description <sup class="text-danger"></sup></span>
                                        <textarea class="form-control" name="description" id="description" rows="3">{{ old('description') }}</textarea>
                                    </div>

                                    @error('phone')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>


                                <div class="form-group" style="margin-top: -5px">
                                    <label class="col-sm-2 col-xs-4 control-label" for="form-field-1-1" style="margin-left:-12px"> Status </label>
                                    <div class="col-sm-4 col-xs-8">
                                        <label style="margin-top: 7px">
                                            <input name="status" class="ace ace-switch ace-switch-6" type="checkbox" @if (!empty($attribute->status)) checked @endif>
                                            <span class="lbl"></span>
                                        </label>
                                    </div>
                                </div>


                                <!-- ACTION -->
                                <div class="btn-group pull-right">
                                    <button class="btn btn-sm btn-primary"> <i class="fa fa-save"></i> Save </button>
                                    <a href="{{ route('pdt.attributes.index') }}" class="btn btn-sm btn-secondary"> <i class="fa fa-list"></i> List </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
