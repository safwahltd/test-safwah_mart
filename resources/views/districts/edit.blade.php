@extends('layouts.master')
@section('title', 'District SLot')

@section('page-header')
    District SLot
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <h4 class="pl-2"><i class="fa fa-pencil"></i> @yield('page-header')</h4>

                <ul class="breadcrumb mb-1">
                    <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
                    <li>Inventory</li>
                    <li><a class="text-muted" href="{{ route('districts.index') }}">District</a></li>
                    <li class=""><a href="javascript:void(0)">Create</a></li>
                </ul>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('districts.update', $district->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('partials._alert_message')


                        {{-- Districts Name --}}
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1-1"> Districts Name<span class="label-required">*</span> </label>
                            <div class="col-sm-4 @error('name') has-error @enderror">
                                <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $district->name) }}" placeholder="Districts Name" required>
                                @error('name')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Shipping Cost --}}
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1-1"> Shipping Cost<span class="label-required">*</span> </label>
                            <div class="col-sm-4 @error('shipping_cost') has-error @enderror">
                                <input type="text" class="form-control" name="shipping_cost" id="shipping_cost" value="{{ old('shipping_cost', number_format($district->shipping_cost, 2)) }}" placeholder="Shipping Cost" required>
                                @error('shipping_cost')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Free Delivery Amount --}}
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1-1"> Free Delivery Amount</label>
                            <div class="col-sm-4 @error('free_delivery_amount') has-error @enderror">
                                <input type="text" class="form-control" name="free_delivery_amount" id="free_delivery_amount" value="{{ old('free_delivery_amount', $district->free_delivery_amount ? number_format($district->free_delivery_amount, 2) : '') }}" placeholder="Free Delivery Amount">
                                @error('free_delivery_amount')
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
                                    <input name="status" class="ace ace-switch ace-switch-6" type="checkbox" @if(!empty($district->status)) checked @endif>
                                    <span class="lbl"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12 text-right">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-success"> <i class="fa fa-save"></i> Update </button>
                                    <a href="{{ route('districts.index') }}" class="btn btn-sm btn-info"> <i class="fa fa-list"></i> List </a>
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
                format: 'YYYY-MM-DD LT'
            });
            $('#datetimepicker2').datetimepicker({
                format: 'YYYY-MM-DD LT'
            });
        });
    </script>

@endsection
