@extends('layouts.master')
@section('title', 'Edit Weight Wise Extra Shipping Cost')


@section('content')

    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-edit"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li>Config</li>
            <li><a class="text-muted" href="{{ route('inv.weight-wise-extra-shipping-costs.index') }}">Extra Shipping Cost</a></li>
            <li class=""><a href="javascript:void(0)">Create</a></li>
        </ul>
    </div>


    <div class="row">
        <div class="col-12">


            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('inv.weight-wise-extra-shipping-costs.update', $weightWiseExtraShippingCost->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        @include('partials._alert_message')

                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">



                                <!-- FROM WEIGHT -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">From Weight <sup class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="from_weight" value="{{ old('from_weight', $weightWiseExtraShippingCost->from_weight) }}" placeholder="From weight in kg" autocomplete="off" required>
                                        <span class="input-group-addon">
                                            <i class="fas fa-balance-scale"></i>
                                        </span>
                                    </div>

                                    @error('from_weight')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>



                                <!-- TO WEIGHT -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">To Weight <sup class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="to_weight" value="{{ old('to_weight', $weightWiseExtraShippingCost->to_weight) }}" placeholder="To weight in kg" autocomplete="off" required>
                                        <span class="input-group-addon">
                                            <i class="fas fa-balance-scale"></i>
                                        </span>
                                    </div>

                                    @error('to_weight')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>



                                <!-- EXTRA COST -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Extra Cost</span>
                                        <input type="text" class="form-control" name="extra_cost" value="{{ old('extra_cost', $weightWiseExtraShippingCost->extra_cost) }}" placeholder="Extra Cost" autocomplete="off">
                                        <span class="input-group-addon">
                                            TK
                                        </span>
                                    </div>

                                    @error('extra_cost')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>
                                



                                <!-- STATUS -->
                                <div class="form-group" style="margin-top: -5px">
                                    <label class="col-sm-2 col-xs-4 control-label" for="form-field-1-1" style="margin-left:-12px"> Status </label>
                                    <div class="col-sm-4 col-xs-8">
                                        <div class="material-switch pt-1 pl-3">
                                            <input type="checkbox" name="status" id="status" @if($weightWiseExtraShippingCost->status == 1 || old('status') == 'yes') checked @endif />
                                            <label for="status" class="badge-primary"></label>
                                        </div>
                                    </div>
                                </div>



                                <!-- ACTION -->
                                <div class="btn-group pull-right">
                                    <button class="btn btn-sm btn-primary"> <i class="fa fa-save"></i> Update </button>
                                    <a href="{{ route('inv.weight-wise-extra-shipping-costs.index') }}" class="btn btn-sm btn-secondary"> <i class="fa fa-list"></i> List </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
