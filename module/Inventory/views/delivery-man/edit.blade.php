@extends('layouts.master')
@section('title', 'Edit Delivery Man')

@section('page-header')
    Edit Delivery Man
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <h4 class="pl-2"><i class="fa fa-pencil"></i> @yield('page-header')</h4>

                <ul class="breadcrumb mb-1">
                    <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
                    <li>Inventory</li>
                    <li><a class="text-muted" href="{{ route('inv.delivery-mans.index') }}">Delivery Man</a></li>
                    <li class=""><a href="javascript:void(0)">Create</a></li>
                </ul>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('inv.delivery-mans.update', $deliveryMan->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('partials._alert_message')

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1-1"> Delivery Type<span class="label-required">*</span> </label>
                            <div class="col-sm-4 @error('delivery_type') has-error @enderror">
                                <select class="form-control select2" name="delivery_type" id="delivery_type" data-placeholder="- Select -" style="width: 100%">
                                    <option></option>
                                    @foreach($deliveryTypes ?? [] as $type)
                                        <option value="{{ $type }}" {{ old('delivery_type', $deliveryMan->delivery_type) == $type ? 'selected' : '' }}>{{ $type }}</option>
                                    @endforeach
                                </select>
                                @error('delivery_type')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1-1"> District </label>
                            <div class="col-sm-4 @error('district_id') has-error @enderror">
                                <select name="district_id" id="district_id" onchange="getAreas(this)" class="form-control select2" data-placeholder="--- Select District ---"
                                    style="width: 100%">
                                    <option value="">--- Select District ---</option>
                                    @foreach ($districts as $district)
                                        <option value="{{ $district->id }}" {{ $deliveryMan->district_id == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                    @endforeach
                                </select>
                                @error('district_id')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1-1"> Area </label>
                            <div class="col-sm-4 @error('area_id') has-error @enderror">
                                <select name="area_id" id="area_id" class="form-control select2" data-placeholder="--- Select Area ---"
                                    style="width: 100%">
                                    <option value="">--- Select Area ---</option>
                                    @foreach ($areas as $area)
                                        <option value="{{ $area->id }}" {{ $deliveryMan->area_id == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                                    @endforeach
                                </select>
                                @error('area_id')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1-1"> Delivery Man Name<span class="label-required">*</span> </label>
                            <div class="col-sm-4 @error('name') has-error @enderror">
                                <input type="text" class="form-control" name="name" id="name"
                                       value="{{ old('name', $deliveryMan->name) }}" placeholder="Delivery Man Name" required>
                                @error('name')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1-1"> Phone<span class="label-required">*</span> </label>
                            <div class="col-sm-4 @error('phone') has-error @enderror">
                                <input type="text" class="form-control" name="phone" id="phone"
                                       value="{{ old('phone', $deliveryMan->phone) }}" placeholder="Phone Number" required>
                                @error('phone')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1-1"> Email </label>
                            <div class="col-sm-4 @error('email') has-error @enderror">
                                <input type="email" class="form-control" name="email" id="email"
                                       value="{{ old('email', $deliveryMan->email) }}" placeholder="Email Address">
                                @error('email')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1-1"> Address </label>
                            <div class="col-sm-4 @error('address') has-error @enderror">
                                <textarea name="address" id="address" rows="5" class="form-control" placeholder="address here ...">{{ old('address', $deliveryMan->address) }}</textarea>
                                @error('address')
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
                                    <input name="status" class="ace ace-switch ace-switch-6" type="checkbox" @if(!empty($deliveryMan->status)) checked @endif>
                                    <span class="lbl"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12 text-right">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-success"> <i class="fa fa-save"></i> Update </button>
                                    <a href="{{ route('inv.delivery-mans.index') }}" class="btn btn-sm btn-info"> <i class="fa fa-list"></i> List </a>
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




    @include('delivery-man/_inc/script')

@endsection
