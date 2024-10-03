@extends('layouts.master')
@section('title', 'Edit Weight Wise Extra Shipping Cost')


@section('content')

    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-edit"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li>Config</li>
            <li><a class="text-muted" href="{{ route('inv.shipping-cost-discounts.index') }}">Order Amount Wise Shipping Cost Discount</a></li>
            <li class=""><a href="javascript:void(0)">Create</a></li>
        </ul>
    </div>


    <div class="row">
        <div class="col-12">


            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('inv.shipping-cost-discounts.update', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        @include('partials._alert_message')

                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">



                                <!-- FROM AMOUNT -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">From Amount <sup class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="from_amount" value="{{ old('from_amount', $item->from_amount) }}" placeholder="From Amount" autocomplete="off" required>
                                        <span class="input-group-addon">
                                            TK
                                        </span>
                                    </div>

                                    @error('from_amount')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>



                                <!-- TO AMOUNT -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">To Amount <sup class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="to_amount" value="{{ old('to_amount', $item->to_amount) }}" placeholder="To Amount" autocomplete="off" required>
                                        <span class="input-group-addon">
                                            TK
                                        </span>
                                    </div>

                                    @error('to_amount')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>



                                <!-- DISCOUNT -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Discount</span>
                                        <input type="text" class="form-control" name="discount" value="{{ old('discount', $item->discount) }}" placeholder="Discount" autocomplete="off">
                                        <span class="input-group-addon">
                                            TK
                                        </span>
                                    </div>

                                    @error('discount')
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
                                            <input type="checkbox" name="status" id="status" @if($item->status == 1 || old('status') == 'yes') checked @endif />
                                            <label for="status" class="badge-primary"></label>
                                        </div>
                                    </div>
                                </div>



                                <!-- ACTION -->
                                <div class="btn-group pull-right">
                                    <button class="btn btn-sm btn-primary"> <i class="fa fa-save"></i> Update </button>
                                    <a href="{{ route('inv.shipping-cost-discounts.index') }}" class="btn btn-sm btn-secondary"> <i class="fa fa-list"></i> List </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
