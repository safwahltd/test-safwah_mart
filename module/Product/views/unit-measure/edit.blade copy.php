@extends('layouts.master')
@section('title', 'Edit Unit Measure')

@section('page-header')
    Edit Unit Measure
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <h4 class="pl-2"><i class="fa fa-pencil"></i> @yield('page-header')</h4>

                <ul class="breadcrumb mb-1">
                    <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
                    <li>Product Config</li>
                    <li><a class="text-muted" href="{{ route('unit-measures.index') }}">Unit Measure</a></li>
                    <li class=""><a href="javascript:void(0)">Edit</a></li>
                </ul>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('unit-measures.update', $unitMeasure->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('partials._alert_message')

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1-1"> Name<span class="label-required">*</span> </label>
                            <div class="col-sm-4 @error('name') has-error @enderror">
                                <input type="text" class="form-control" name="name" id="name"
                                       value="{{ old('name', $unitMeasure->name) }}" placeholder="Unit Measure Name" required>
                                @error('name')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1-1"> Description </label>
                            <div class="col-sm-4 @error('description') has-error @enderror">
                                <textarea class="form-control" name="description" id="description" rows="3">{{ old('description', $unitMeasure->description) }}</textarea>
                                @error('description')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group" style="margin-top: -15px">
                            <label class="col-sm-2 col-xs-4 control-label" for="form-field-1-1" style="margin-left:-12px"> Status </label>
                            <div class="col-sm-4 col-xs-8">
                                <label style="margin-top: 7px">
                                    <input name="status" class="ace ace-switch ace-switch-6" type="checkbox" @if(!empty($unitMeasure->status)) checked @endif>
                                    <span class="lbl"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12 text-right">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-success"> <i class="fa fa-save"></i> Update </button>
                                    <a href="{{ route('unit-measures.index') }}" class="btn btn-sm btn-info"> <i class="fa fa-list"></i> List </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
