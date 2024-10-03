@extends('layouts.master')
@section('title', 'Add Customer')

@section('page-header')
    Add Customer
@stop

@section('content')

    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="fas fa-plus"></i> @yield('page-header')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li>Inventory</li>
            <li><a class="text-muted" href="{{ route('inv.customers.index') }}">Customer</a></li>
            <li class=""><a href="javascript:void(0)">Create</a></li>
        </ul>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('inv.customers.store') }}" method="POST">
                        @csrf
                        @include('partials._alert_message')

                        <div class="row" style="margin-bottom: 30px">
                            <div class="col-lg-5" style="margin-left: 80px">
                                <!-- CUSTOMER TYPE -->
                                <div class="form-group mb-1 mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-35" style="text-align: left"> Customer Type</span>
                                        <select name="customer_type_id" id="customer_type_id" class="form-control select2" style="width: 100%">
                                            <option value="" selected>--- Select ---</option>
                                            @foreach ($customerTypes as $customerType)
                                                <option value="{{ $customerType->id }}" {{ old('customer_type_id') == $customerType->id ? 'selected' : '' }}>{{ $customerType->name }}</option>
                                            @endforeach
                                        </select>
                                        
                                        @error('customer_type_id')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                
                                <!-- NAME -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-35" style="text-align: left"> Name <span class="label-required">*</span></span>
                                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}" required>
                                    </div>

                                    @error('name')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                


                                
                                <!-- MOBILE -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-35" style="text-align: left"> Phone <span class="label-required">*</span></span>
                                        <input type="text" class="form-control" name="mobile" id="mobile" value="{{ old('mobile') }}" required>
                                    </div>

                                    @error('mobile')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                


                                
                                <!-- EMAIL -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-35" style="text-align: left"> Email</span>
                                        <input type="text" class="form-control" name="email" id="email" value="{{ old('email') }}">
                                    </div>
                                    @error('email')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                


                                
                                <!-- GENDER -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-35" style="text-align: left"> Gender</span>
                                        <select class="form-control select2" name="gender" id="gender" style="width: 100%">
                                            <option value="" selected>--- Select ---</option>
                                            @foreach(['Male', 'Female', 'Others'] as $gender)
                                                <option value="{{ $gender }}" {{ old('gender') == $gender ? 'selected' : '' }}>{{ $gender }}</option>
                                            @endforeach
                                        </select>

                                        @error('gender')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                
                                   <!-- Password -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-35" style="text-align: left"> Password *</span>
                                        <input type="password" class="form-control" name="password" id="password" value="{{ old('password') }}" required>
                                    </div>
                                    @error('email')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>



                                
                                <!-- ACTION -->
                                <div class="form-group mb-1">
                                    <div class="row">
                                        <!-- STATUS -->
                                        <div class="col-md-6">
                                            <label class="col-sm-3 col-xs-4 control-label" for="form-field-1-1" style="margin-left:-12px"> Status </label>
                                            <div class="col-sm-8 col-xs-8">
                                                <label style="margin-top: 7px">
                                                    <input name="status" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                        </div>




                                        
                                        <!-- IS DEFAULT -->
                                        <div class="col-md-6">
                                            <label class="col-sm-3 col-xs-4 control-label" for="form-field-1-1" style="margin-left:-12px"> Default </label>
                                            <div class="col-sm-8 col-xs-8">
                                                <label style="margin-top: 7px">
                                                    <input name="is_default" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>





                            <div class="col-lg-5" style="margin-left: 30px; margin-right: 60px">
                                
                                <!-- ADDRESS -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-35" style="text-align: left"> Address </span>
                                        <textarea name="address" id="address" class="form-control" rows="3">{{ old('address') }}</textarea>
                                    </div>

                                    @error('address')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>





                                <!-- COUNTRY -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-35" style="text-align: left"> Country </span>
                                        <input type="text" class="form-control" name="country" id="country" value="Bangladesh" readonly>
                                    </div>

                                    @error('country')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                


                                
                                <!-- DISTRICT -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-35" style="text-align: left">District</span>
                                        <select name="district_id" id="district_id" onchange="getAreas(this)" class="form-control select2" style="width: 100%">
                                            <option value="" selected>--- Select ---</option>
                                            @foreach ($districts as $district)
                                                <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('district_id')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                


                                
                                <!-- AREA -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-35" style="text-align: left">Area</span>
                                        <select name="area_id" id="area_id" class="form-control select2" style="width: 100%">
                                            <option value="" selected>--- Select ---</option>
                                        </select>

                                        @error('area_id')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                


                                
                                <!-- ZIP CODE -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-35" style="text-align: left"> Zip Code</span>
                                        <input type="text" class="form-control" name="zip_code" id="zip_code" value="{{ old('zip_code') }}">
                                    </div>

                                    @error('zip_code')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>


                                


                                
                                <!-- PREVIOUS DUE -->
                                {{-- <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-35" style="text-align: left"> Previous Due </span>
                                        <input type="text" class="form-control" name="previous_due" id="previous_due" value="{{ old('previous_due') }}">
                                    </div>

                                    @error('previous_due')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div> --}}

                                


                                
                                {{-- <!-- OPENING BALANCE -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-35" style="text-align: left"> Opening Balance</span>
                                        <input type="text" class="form-control" name="opening_balance" id="opening_balance" value="{{ old('opening_balance') }}">
                                    </div>

                                    @error('opening_balance')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                


                                
                                <!-- CURRENT BALANCE -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-35" style="text-align: left"> Current Balance</span>
                                        <input type="text" class="form-control" name="current_balance" id="current_balance" value="{{ old('current_balance') }}" readonly>
                                    </div>

                                    @error('current_balance')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div> --}}
                            </div>
                        </div>





                        <!-- ACTION -->
                        <div class="form-group mb-1">
                            <div class="col-sm-11 text-right" style="margin-left: 24px;">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-success"> <i class="fa fa-save"></i> Submit </button>
                                    <a href="{{ route('inv.customers.index') }}" class="btn btn-sm btn-info"> <i class="fa fa-list"></i> List </a>
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

    @include('customer/_inc/script')

@endsection
