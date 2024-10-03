@extends('layouts.master')
@section('title', 'Create Time Slot')

@section('page-header')
    Add New Time Slot
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <h4 class="pl-2"><i class="fa fa-plus"></i> @yield('page-header')</h4>

                <ul class="breadcrumb mb-1">
                    <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
                    <li>Inventory</li>
                    <li><a class="text-muted" href="{{ route('inv.time-slots.index') }}">Time Slot</a></li>
                    <li class=""><a href="javascript:void(0)">Create</a></li>
                </ul>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('inv.time-slots.store') }}" method="POST">
                        @csrf
                        @include('partials._alert_message')

                        {{-- Time Slot Name --}}
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1-1"> Time Slot Name<span class="label-required">*</span> </label>
                            <div class="col-sm-4 @error('name') has-error @enderror">
                                <input type="text" class="form-control" name="name" id="name"
                                       value="{{ old('name') }}" placeholder="Slot Name" required>
                                @error('name')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Starting Time --}}
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1-1"> Staring Time <span class="label-required">*</span> </label>
                            <div class="col-sm-4 @error('starting_time') has-error @enderror">
                                <div class='input-group date' id='datetimepicker1'>
                                    <input type='text' name="starting_time" class="form-control" value="{{ old('starting_time') }}" autocomplete="off" placeholder="Starting Time"  style=" border-right: none;"/>
                                    <span class="input-group-addon" style="padding: 6px 5px; background-color: transparent; ">
                                       <i class="far fa-clock"></i>
                                    </span>
                                </div>
                                @error('starting_time')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Ending Time --}}
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1-1"> Ending Time <span class="label-required">*</span> </label>
                            <div class="col-sm-4 @error('ending_time') has-error @enderror">
                                <div class='input-group date' id='datetimepicker2'>
                                    <input type='text' name="ending_time" class="form-control" value="{{ old('ending_time') }}" autocomplete="off" placeholder="Ending Time"  style=" border-right: none;"/>
                                    <span class="input-group-addon" style="padding: 6px 5px; background-color: transparent; ">
                                        <i class="far fa-clock"></i>
                                    </span>
                                </div>
                                @error('ending_time')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- DISABLE AT --}}
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1-1"> Disable At <span class="label-required">*</span> </label>
                            <div class="col-sm-4 @error('disable_at') has-error @enderror">
                                <div class='input-group date' id='datetimepicker3'>
                                    <input type='text' name="disable_at" class="form-control" value="{{ old('disable_at') }}" autocomplete="off" placeholder="Disable At"  style=" border-right: none;"/>
                                    <span class="input-group-addon" style="padding: 6px 5px; background-color: transparent; ">
                                        <i class="far fa-clock"></i>
                                    </span>
                                </div>
                                @error('disable_at')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="form-group" style="margin-top: -5px">
                            <label class="col-sm-2 col-xs-4 control-label" for="form-field-1-1" style="margin-left:-12px"> Status </label>
                            <div class="col-sm-4 col-xs-8">
                                <label style="margin-top: 7px">
                                    <input name="status" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                                    <span class="lbl"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12 text-right">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-success"> <i class="fa fa-save"></i> Save </button>
                                    <a href="{{ route('inv.time-slots.index') }}" class="btn btn-sm btn-info"> <i class="fa fa-list"></i> List </a>
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

    {{-- DateTime Picker --}}
    <script>
        $(function () {
            $('#datetimepicker1').datetimepicker({
                format: 'hh:mm A'
            });
            $('#datetimepicker2').datetimepicker({
                format: 'hh:mm A'
            });
            $('#datetimepicker3').datetimepicker({
                format: 'hh:mm A'
            });
        });
    </script>

@endsection
