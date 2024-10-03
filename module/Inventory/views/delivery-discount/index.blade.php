@extends('layouts.master')

@section('title', 'Delivery Discount Settings')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fad fa-cogs"></i> @yield('title')</h4>
    </div>

    <div class="row">
        <div class="col-12">



            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="col-md-10 col-sm-offset-1">
                            @include('partials._alert_message')


                            <form class="form-horizontal mt-2" action="{{ route('inv.update-delivery-discount') }}" method="POST">
                                @csrf

                                <div class="row">
                                    <div class="col-md-7">
                                        @if(hasAnyPermission(['orders.cod-charge'], $slugs))
                                            @foreach($ecomSettings->where('id', '<=', 41) as $key => $setting)
                                                <input type="hidden" name="id[]" value="{{ $setting->id }}">

                                                <div class="input-group mb-1 width-100">

                                                    @if($setting->id == 39 || $setting->id == 41 || $setting->id == 43 || $setting->id == 44)
                                                        <span class="input-group-addon width-45" style="text-align: left">
                                                            {{ $setting->title }}
                                                        </span>
                                                        <input type="text" class="form-control text-center only-number" name="value[{{ $setting->id }}]" placeholder="{{ $setting->title }}" value="{{ old('value', $setting->value) }}" required>

                                                    @else

                                                        <span class="input-group-addon width-45" style="text-align: left">
                                                            {{ $setting->title }}
                                                        </span>

                                                        <label style="margin: 6px 0 0 15px; position: relative;" class="width-55">
                                                            <input name="value[{{ $setting->id }}]" class="ace ace-switch ace-switch-6 status{{ $setting->id }}" type="checkbox" @if(!empty($setting->value) && $setting->value == 'on') checked @endif>
                                                            <span class="lbl"></span>
                                                        </label>
                                                    @endif
                                                </div>


                                                <span class="text-danger pt-1">
                                                    @error('value')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            @endforeach
                                        @endif

                                        @if(hasAnyPermission(['orders.free-deliveries'], $slugs))
                                            @foreach($ecomSettings->where('id', '>', 41) as $key => $setting)
                                                <input type="hidden" name="id[]" value="{{ $setting->id }}">

                                                <div class="input-group mb-1 width-100">

                                                    @if($setting->id == 39 || $setting->id == 41 || $setting->id == 43 || $setting->id == 44)
                                                        <span class="input-group-addon width-45" style="text-align: left">
                                                            {{ $setting->title }}
                                                        </span>
                                                        <input type="text" class="form-control text-center only-number" name="value[{{ $setting->id }}]" placeholder="{{ $setting->title }}" value="{{ old('value', $setting->value) }}" required>

                                                    @else

                                                        <span class="input-group-addon width-45" style="text-align: left">
                                                            {{ $setting->title }}
                                                        </span>

                                                        <label style="margin: 6px 0 0 15px; position: relative;" class="width-55">
                                                            <input name="value[{{ $setting->id }}]" class="ace ace-switch ace-switch-6 status{{ $setting->id }}" type="checkbox" @if(!empty($setting->value) && $setting->value == 'on') checked @endif>
                                                            <span class="lbl"></span>
                                                        </label>
                                                    @endif
                                                </div>


                                                <span class="text-danger pt-1">
                                                    @error('value')
                                                        {{ $message }}
                                                    @enderror
                                                </span>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>

                                @if(hasAnyPermission(['orders.cod-charge', 'orders.free-deliveries'], $slugs))
                                    <div class="row">
                                        <div class="col-sm-7 text-right">
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-check"></i> UPDATE </button>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
