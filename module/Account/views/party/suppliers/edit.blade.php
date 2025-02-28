@extends('layouts.master')
@section('title', 'Supplier')
@section('page-header')
    <i class="fa fa-edit"></i> Supplier Edit
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

        <!-- heading -->
            <div class="widget-box widget-color-white ui-sortable-handle clearfix" id="widget-box-7">
                <div class="widget-header widget-header-small">
                    <h3 class="widget-title smaller text-primary">
                        @yield('page-header')
                    </h3>

                    <div class="widget-toolbar">
                        <a href="{{ route('acc-suppliers.index') }}" ><i class="fa fa-list-alt"> List</i></a>
                    </div>

                    <div class="widget-toolbar">
                        <a href="{{ route('acc-suppliers.create') }}" ><i class="fa fa-plus"> Create</i></a>
                    </div>
                </div>

                <div class="space"></div>

                <!-- INPUTS -->
                <form action="{{ route('acc-suppliers.update', $supplier->id) }}" method="post">
                    @csrf @method('put')
                    <div class="row" style="width: 100%; margin: 0 0 20px !important;">
                        <div class="col-sm-12 px-4">
                            <!-- Name -->
                        @include('includes.inputs.input-field', ['name' => 'name', 'value' => $supplier->name, 'is_required' => true])

                        <!-- Mobile -->
                        @include('includes.inputs.input-field', ['name' => 'mobile', 'value' => $supplier->mobile])

                        <!-- Email -->
                        @include('includes.inputs.input-field', ['name' => 'email', 'value' => $supplier->email, 'type' => 'email'])

                        <!-- Address -->
                        @include('includes.inputs.input-field', ['name' => 'address', 'value' => $supplier->address])

                        <!-- Opening balance -->
                        {{-- @include('includes.inputs.input-field', ['name' => 'opening_balance', 'title' => 'Opening Balance', 'value' => $supplier->opening_balance]) --}}

                        <!-- Current balance -->
                        {{-- <!-- @include('includes.inputs.input-field', ['name' => 'current_balance', 'title' => 'Current Balance', 'value' => $supplier->current_balance]) --> --}}

                        <!-- Submit -->
                            <button class="btn btn-info btn-sm pull-right"><i class="fa fa-edit"></i> Update</button>
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


