@extends('layouts.master')

@section('title', 'Customer')

@section('page-header')
    <i class="fa fa-plus-circle"></i> Customer Create
@stop

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/chosen.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/custom_css/chosen-required.css') }}"/>

@endpush

@section('content')
    <div class="row">
        <div class="col-sm-8 col-sm-offset-2">

            @include('partials._alert_message')

            <div class="widget-box widget-color-white ui-sortable-handle clearfix" id="widget-box-7">
                
                <!-- heading -->
                <div class="widget-header widget-header-small">
                    <h3 class="widget-title smaller text-primary">
                        @yield('page-header')
                    </h3>

                    <div class="widget-toolbar">
                        <a href="{{ route('acc-customers.index') }}" ><i class="fa fa-list-alt"></i> List</a>
                    </div>
                </div>

                <div class="space"></div>

                <!-- INPUTS -->
                <form action="{{ route('acc-customers.store') }}" method="post">
                    @csrf
                    <div class="row" style="width: 100%; margin: 0 0 20px !important;">
                        <div class="col-sm-12 px-4">
                            <!-- Name -->
                            @include('includes.inputs.input-field', ['name' => 'name', 'is_required' => true])

                            <!-- Mobile -->
                            @include('includes.inputs.input-field', ['name' => 'mobile'])

                            <!-- Email -->
                            @include('includes.inputs.input-field', ['name' => 'email', 'type' => 'email'])

                            <!-- Address -->
                            @include('includes.inputs.input-field', ['name' => 'address'])

                            <!-- Opening balance -->
                            {{-- @include('includes.inputs.input-field', ['name' => 'opening_balance', 'title' => 'Opening Balance']) --}}
                            <!-- <div class="form-group row">
                                <label class="col-sm-3 control-label" for="name">
                                    <b>Opening Balance </b>
                                </label>

                                <div class="col-sm-9">
                                    <input id="opening_balance" name="opening_balance" onkeypress="return event.charCode >= 46 && event.charCode <= 57" type="text" class="form-control input-sm" placeholder="Opening Balance" value="{{ old('opening_balance') }}">
                                </div>
                            </div> -->

                            <!-- Submit -->
                            <button class="btn btn-primary btn-sm pull-right"><i class="fa fa-save"></i> Save</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>


@endsection

@section('js')
    
    
    <script src="{{ asset('assets/js/chosen.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/custom_js/chosen-box.js') }}"></script>
@endsection


