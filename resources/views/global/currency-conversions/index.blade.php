@extends('layouts.master')

@section('title','Currency Conversion List')

@section('page-header')
    <i class="fa fa-list"></i> Currency Conversion List
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/chosen.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css') }}" />
@stop


@section('content')


    <div class="row">
        <div class="col-sm-12">

            <!-- heading -->
            <div class="widget-box widget-color-white ui-sortable-handle clearfix" id="widget-box-7">
                <div class="widget-header widget-header-small">
                    <h3 class="widget-title smaller text-primary">
                        @yield('page-header')
                        @if(hasPermission('currency-conversions.create', $slugs))
                            <span style="font-size: 14px; padding-right: 20px !important;" class="pull-right">|
                                <a href="{{ route('currency-conversions.create') }}"><i class="fa fa-plus"></i> Add New</a>
                            </span>
                        @endif
                    </h3>
                </div>


                <!-- filter -->
                <div class="row">
                    <form class="form-horizontal" action="" method="get">
                        <div class="col-sm-12">
                            <table class="table table-bordered">
                                <tr>
                                    <td width="40%">
                                        <div class="input-group">
                                            <label class="input-group-addon">From</label>
                                            <input type="text" name="from" class="form-control input-sm month-picker"  autocomplete="off" value="{{ request('from') }}">
                                        </div>
                                    </td>
                                    <td width="40%">
                                        <div class="input-group">
                                            <label class="input-group-addon">To</label>
                                            <input type="text" name="to" class="form-control input-sm month-picker" autocomplete="off" value="{{ request('to') }}">
                                        </div>
                                    </td>
                                    <td width="20%" class="text-center">
                                        <button class="btn btn-primary btn-round btn-mini"><i class="fa fa-search"></i> Search</button>
                                        <a href="{{ route('currency-conversions.index') }}" class="btn btn-info btn-mini btn-round"><i class="fa fa-refresh"></i> Refresh</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </form>
                </div>


                <div class="space"></div>


                <!-- rate list -->
                <div class="row" style="width: 99%; margin-left: .5%">
                    @include('partials._alert_message')
                    <div class="col-sm-10 col-sm-offset-1">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr class="table-header-bg" style="height: 40px">
                                    <th>Sl</th>
                                    <th>Currency</th>
                                    <th>Month</th>
                                    <th class="text-center">Rate</th>
                                    <th style="width: 130px" class="text-center">Action</th>
                                </tr>
                            </thead>

                            <tbody class="list-table">
                                @forelse($currencyConversions as $key => $currencyConversion)
                                    <tr>
                                        <td>{{ $key + $currencyConversions->firstItem() }}</td>
                                        <td>{{ $currencyConversion->currency->name }}</td>
                                        <td>{{ fdate($currencyConversion->effected_month, 'F, Y') }}</td>
                                        <td class="text-right" style="padding-right: 5px !important;">{{ number_format($currencyConversion->rate, 2) }}</td>
                                        <td class="text-center">

                                            <div class="btn-group btn-corner">
                                                <span class="btn btn-info btn-sm popover-success"
                                                      data-rel="popover"
                                                      data-placement="top"
                                                      data-original-title="<i class='ace-icon fa fa-info-circle green'></i> Log Information"
                                                      data-content="<p>Created By: {{ optional($currencyConversion->created_user)->name }}.</p> <p> Created At : {{ $currencyConversion->created_at }} </p>
                                                       <hr/>
                                                       <p>Updated By: {{ optional($currencyConversion->updated_user)->name }}.</p> <p> Updated At : {{ $currencyConversion->updated_at }} </p>">
                                                    <i class="fa fa-info-circle"></i>
                                                </span>

                                                @if(hasPermission('currency-conversions.delete', $slugs))
                                                    <button class="btn btn-sm btn-danger" onclick="delete_item('{{ route('currency-conversions.destroy', $currencyConversion->id) }}')" type="button">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-danger">No records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @include('partials._paginate', ['data' => $currencyConversions])
                </div>
            </div>
        </div>
    </div>


    <!-- delete form -->
    <form action="" id="deleteItemForm" method="POST">
        @csrf @method("DELETE")
    </form>
@endsection

@section('js')
    <script src="{{ asset('assets/js/chosen.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>

    <script src="{{ asset('assets/js/ace-elements.min.js') }}"></script>
    <script src="{{ asset('assets/js/ace.min.js') }}"></script>


    <!-- delete confirm dialog -->
    <script type="text/javascript" src="{{ asset('assets/custom_js/confirm_delete_dialog.js') }}"></script>


    <!--  Select Box Search-->
    <script type="text/javascript" src="{{ asset('assets/custom_js/chosen-box.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/custom_js/month-picker.js') }}"></script>


    <!-- user log popover -->
    <script type="text/javascript">
        $('[data-rel=popover]').popover({html:true, container:'body'});
    </script>
@endsection


