@extends('layouts.master')
@section('title', 'Edit Delivery Man Time Slot')

@section('page-header')
    Edit Delivery Man Time Slot
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <h4 class="pl-2"><i class="fa fa-pencil"></i> @yield('page-header')</h4>

                <ul class="breadcrumb mb-1">
                    <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
                    <li>Inventory</li>
                    <li><a class="text-muted" href="{{ route('inv.delivery-man-time-slots.index') }}">Delivery Man Time Slot</a></li>
                    <li class=""><a href="javascript:void(0)">Create</a></li>
                </ul>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('inv.delivery-man-time-slots.update', $deliveryManTimeSlot->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        @include('partials._alert_message')

                        {{-- Time Slot --}}
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1-1"> Time Slot </label>
                            <div class="col-sm-4 @error('time_slot_id') has-error @enderror">
                                <select name="time_slot_id" id="time_slot_id" class="form-control select2" data-placeholder="--- Select Time Slot ---" style="width: 100%">
                                    <option value="">--- Select Time Slot ---</option>
                                    @foreach ($timeSlots as $item)
                                        <option value="{{ $item->id }}" {{ old('time_slot_id', $deliveryManTimeSlot->time_slot_id) == $item->id ? 'selected' : '' }}>{{ $item->name }} ({{ $item->starting_time }} - {{ $item->ending_time }})</option>
                                    @endforeach
                                </select>
                                @error('time_slot_id')
                                    <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Delivery Man --}}
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1-1"> Delivery Man </label>
                            <div class="col-sm-4 @error('delivery_man_id') has-error @enderror">
                                <select name="delivery_man_id" id="delivery_man_id" class="form-control select2" data-placeholder="--- Select Delivery Man ---" style="width: 100%">
                                    <option value="">--- Select Delivery Man ---</option>
                                    @foreach ($delivery_mans as $item)
                                        <option value="{{ $item->id }}" {{ old('delivery_man_id', $deliveryManTimeSlot->delivery_man_id) == $item->id ? 'selected' : '' }}>{{ $item->name }} ({{ $item->phone }})</option>
                                    @endforeach
                                </select>
                                @error('delivery_man_id')
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
                                    <input name="status" class="ace ace-switch ace-switch-6" type="checkbox" @if(!empty($deliveryManTimeSlot->status)) checked @endif>
                                    <span class="lbl"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12 text-right">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-success"> <i class="fa fa-save"></i> Update </button>
                                    <a href="{{ route('inv.delivery-man-time-slots.index') }}" class="btn btn-sm btn-info"> <i class="fa fa-list"></i> List </a>
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
                format: 'LT'
            });
            $('#datetimepicker2').datetimepicker({
                format: 'LT'
            });
        });
    </script>

@endsection
