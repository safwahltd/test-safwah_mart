@extends('layouts.master')
@section('title', 'Create Warehouse')


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <h4 class="pl-2"><i class="fa fa-plus"></i> @yield('title')</h4>

                <ul class="breadcrumb mb-1">
                    <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
                    <li>Inventory</li>
                    <li><a class="text-muted" href="{{ route('inv.warehouses.index') }}">Warehouse</a></li>
                    <li class=""><a href="javascript:void(0)">Create</a></li>
                </ul>
            </div>


            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('inv.warehouses.store') }}" method="POST">
                        @csrf
                        @include('partials._alert_message')

                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">




                                <!-- AREA -->
                                <div class="form-group">
                                    <div class="input-group width-100 width-select">
                                        <span class="input-group-addon width-30" style="text-align: left">Area <sup class="text-danger"></sup></span>
                                            <select name="area_id[]" id="area_id" class="form-control select2 " multiple data-placeholder="--- Select ---" style="width: 100%; border: 0px !important">
                                            <option></option>
                                            @foreach($areas as $id => $name)
                                                <option value="{{ $id }}" {{ (collect(old('area_id'))->contains($id)) ? 'selected' : '' }}>
                                                    {{ $name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @error('area_id')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>



                                <!-- NAME -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-27-7" style="text-align: left">Warehouse Name <sup class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Warehouse Name" autocomplete="off" required>
                                    </div>

                                    @error('name')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>





                                <!-- PHONE -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-27-7" style="text-align: left">Contact No <sup class="text-danger"></sup></span>
                                        <input type="text" class="form-control" name="phone" value="{{ old('phone') }}" placeholder="Contact No" autocomplete="off">
                                    </div>

                                    @error('phone')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>





                                <!-- BIN NO -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-27-7" style="text-align: left">BIN No</span>
                                        <input type="text" class="form-control" name="bin_no" value="{{ old('bin_no') }}" placeholder="BIN No" autocomplete="off">
                                    </div>

                                    @error('bin_no')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>





                                <!-- ADDRESS -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-27-7" style="text-align: left">Address</span>
                                        <textarea class="form-control" name="address" rows="2" autocomplete="off">{{ old('address') }}</textarea>
                                    </div>

                                    @error('address')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>





                                <!-- ACTION -->
                                <div class="btn-group pull-right">
                                    <button class="btn btn-sm btn-primary"> <i class="fa fa-save"></i> Save </button>
                                    <a href="{{ route('inv.warehouses.index') }}" class="btn btn-sm btn-secondary"> <i class="fa fa-list"></i> List </a>
                                </div>


                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
