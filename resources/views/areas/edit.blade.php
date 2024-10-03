@extends('layouts.master')
@section('title', 'Area')

@section('page-header')
    Area
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <h4 class="pl-2"><i class="fa fa-pencil"></i> @yield('page-header')</h4>

                <ul class="breadcrumb mb-1">
                    <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
                    <li>Inventory</li>
                    <li><a class="text-muted" href="{{ route('areas.index') }}">Area</a></li>
                    <li class=""><a href="javascript:void(0)">Create</a></li>
                </ul>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('areas.update', $area->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('partials._alert_message')

                        {{-- District --}}
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1-1">District<span class="label-required">*</span> </label>
                            <div class="col-sm-4 @error('district_id') has-error @enderror">
                                <select class="form-control select2" name="district_id" id="district_id" data-placeholder="- Select -" style="width: 100%">
                                    <option></option>
                                    @foreach($districts ?? [] as $district)
                                        <option value="{{ $district->id }}" {{ $area->district_id == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                    @endforeach
                                </select>
                                @error('district_id')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Districts Name --}}
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1-1"> Area Name<span class="label-required">*</span> </label>
                            <div class="col-sm-4 @error('name') has-error @enderror">
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $area->name) }}" placeholder="Area Name" required>
                                @error('name')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group" style="margin-top: -5px">
                            <label class="col-sm-2 col-xs-4 control-label" for="form-field-1-1" style="margin-left:-12px"> Status </label>
                            <div class="col-sm-4 col-xs-8">
                                <label style="margin-top: 7px">
                                    <input name="status" class="ace ace-switch ace-switch-6" type="checkbox" @if(!empty($area->status)) checked @endif>
                                    <span class="lbl"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12 text-right">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-success"> <i class="fa fa-save"></i> Update </button>
                                    <a href="{{ route('areas.index') }}" class="btn btn-sm btn-info"> <i class="fa fa-list"></i> List </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
