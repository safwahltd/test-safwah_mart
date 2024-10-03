@extends('layouts.master')
@section('title', 'Test')
@section('page-header')
    <i class="fa fa-list"></i> Test
@stop
@push('style')
    <link rel="stylesheet" href="{{ asset('assets/css/chosen.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/custom_css/chosen-required.css') }}"/>
    <style>
        td {
            padding-bottom: 3px !important;
            padding-top: 3px !important;
        }
    </style>
@endpush

@section('content')
    <div class="row">
        <div class="col-sm-10 col-sm-offset-1">

        @include('partials._alert_message')

        <!-- heading -->
            <div class="widget-box widget-color-white ui-sortable-handle clearfix" id="widget-box-7">
                <div class="widget-header widget-header-small">
                    <h3 class="widget-title smaller text-primary">
                        @yield('page-header')
                    </h3>

                    <div class="widget-toolbar border smaller" style="padding-right: 0 !important">
                        <div class="pull-right tableTools-container" style="margin: 0 !important">
                            <div class="dt-buttons btn-overlap btn-group">
                                <a href="{{ route('fund-transfers.index') }}"
                                   class="dt-button btn btn-white btn-info btn-bold" title="List" data-toggle="tooltip"
                                   tabindex="0" aria-controls="dynamic-table">
                                    <span>
                                        <i class="fa fa-list bigger-110"></i>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space"></div>

                <!-- INPUTS -->
                <form action="" >
                    @csrf
                    <div class="row" style="width: 100%; margin: 0 0 20px !important;">
                        <div class="col-sm-12 px-4">


                            <!-- Date -->

                        <!-- From Account -->
                            <div class="form-group row">
                                

                                <div class="col-sm-9">
                                    <select id="from_select_id" name="from_account_id"
                                            class="chosen-select-100-percent" data-placeholder="- Select Account -"
                                            onchange="" required>
                                            <option value=""></option>
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                            <option value="E">E</option>
                                    </select>
                                </div>
                            </div>



                       
                        <!-- Submit -->
                            <button class="btn btn-primary btn-sm pull-right save-btn" disabled><i
                                    class="fa fa-save"></i> Save
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <button onclick="resetChosen()">Reset Choesn </button>
    <button onclick="dropdown()">Dropdown Choesn </button>
@endsection

@section('js')
    <script src="{{ asset('assets/js/chosen.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>
    
    
    <script src="{{ asset('assets/custom_js/chosen-box.js') }}"></script>
    <script src="{{ asset('assets/custom_js/date-picker.js') }}"></script>

    <script>
      function resetChosen(){
         alert("resetChosen");
         $('#from_select_id').prop('selectedIndex',0).trigger('chosen:updated');

      }
      function dropdown(){
         alert("dropdown");
        //  $('#from_select_id').addClass('chosen-with-drop').chosen();
        //  $('#from_select_id').trigger('chosen:activate');
         $('#from_select_id').trigger('chosen:activate')

      }


  

    </script>
@endsection


