@extends('layouts.master')
@section('title', 'Edit Coupon')


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <h4 class="pl-2"><i class="fa fa-plus"></i> @yield('title')</h4>

                <ul class="breadcrumb mb-1">
                    <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
                    <li>Product</li>
                    <li><a class="text-muted" href="{{ route('inv.coupons.index') }}">Coupon</a></li>
                    <li class=""><a href="javascript:void(0)">Edit</a></li>
                </ul>
            </div>


            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('inv.coupons.update', $coupon->id) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        @include('partials._alert_message')

                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">

                                <!-- USE TYPE -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Use Type <sup
                                                class="text-danger">*</sup></span>
                                        <select name="use_type" id="use_type" class="form-control select2"
                                            data-placeholder="- Select -" style="width: 100%">
                                            <option value="Once"
                                                {{ old('use_type', $coupon->use_type) == 'Once' ? 'selected' : '' }}>Once
                                            </option>
                                            <option value="Multiple"
                                                {{ old('use_type', $coupon->use_type) == 'Multiple' ? 'selected' : '' }}>
                                                Multiple</option>
                                        </select>
                                    </div>

                                    @error('use_type')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>





                                <!-- NAME -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Name <sup
                                                class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="name" id="name"
                                            value="{{ old('name', $coupon->name) }}" placeholder="Coupon Name"
                                            autocomplete="off" required>
                                    </div>

                                    @error('name')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>





                                <!-- CODE -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Code <sup
                                                class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="code" id="coupon"
                                            value="{{ old('code', $coupon->code) }}" placeholder="Coupon Code"
                                            autocomplete="off" required>
                                    </div>
                                    @error('code')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>




                                <!-- START DATE -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Start Date <sup
                                                class="text-danger">*</sup></span>
                                        <input type="text" class="form-control date-picker" name="start_date"
                                            value="{{ old('start_date', $coupon->start_date) }}" placeholder="Start Date"
                                            autocomplete="off" data-date-format="yyyy-mm-dd" required>
                                    </div>

                                    @error('start_date')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>





                                <!-- END DATE -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">End Date <sup
                                                class="text-danger">*</sup></span>
                                        <input type="text" class="form-control date-picker" name="end_date"
                                            value="{{ old('end_date', $coupon->end_date) }}" placeholder="End Date"
                                            autocomplete="off" data-date-format="yyyy-mm-dd" required>
                                    </div>

                                    @error('end_date')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>





                                <!-- DISCOUNT TYPE -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Discount Type <sup
                                                class="text-danger">*</sup></span>
                                        <select name="discount_type" id="discount_type" class="form-control select2"
                                            data-placeholder="- Select -" style="width: 100%">
                                            <option value="Percent"
                                                {{ old('discount_type', $coupon->discount_type) == 'Percent' ? 'selected' : '' }}>
                                                Percent</option>
                                            <option value="Flat"
                                                {{ old('discount_type', $coupon->discount_type) == 'Flat' ? 'selected' : '' }}>
                                                Flat</option>
                                        </select>
                                    </div>

                                    @error('discount_type')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>





                                <!-- AMOUNT -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Amount <sup
                                                class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="amount"
                                            value="{{ old('amount', $coupon->amount) }}" placeholder="Amount"
                                            autocomplete="off" required>
                                    </div>

                                    @error('amount')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>





                                <!-- MAX PRICE DISCOUNT -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Max Discount
                                            Amount </span>
                                        <input type="text" class="form-control" name="max_price_discount"
                                            value="{{ old('max_price_discount', $coupon->max_price_discount) }}"
                                            placeholder="100" autocomplete="off">
                                    </div>

                                    @error('max_price_discount')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>




                                <!-- DESCRIPTION -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30"
                                            style="text-align: left">Description</span>
                                        <textarea class="form-control" name="description" id="description" rows="3">{{ old('description', $coupon->description) }}</textarea>
                                    </div>

                                    @error('description')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>





                                <!-- HIGHLIGHT & STATUS -->
                                <div class="form-group" style="margin-top: -5px">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-sm-9 col-xs-4 text-right" for="form-field-1-1"> Highlight
                                            </label>
                                            <div class="col-sm-3 col-xs-8">
                                                <label>
                                                    <input name="is_highlight" class="ace ace-switch ace-switch-6"
                                                        type="checkbox" @if ($coupon->is_highlight == 'Yes' || old('is_highlight') != '') checked @endif />
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-sm-9 col-xs-4 text-right" for="form-field-1-1"> Status
                                            </label>
                                            <div class="col-sm-3 col-xs-8">
                                                <label>
                                                    <input name="status" class="ace ace-switch ace-switch-6"
                                                        type="checkbox" @if ($coupon->status == 1 || old('status') != '') checked @endif>
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-sm-9 col-xs-4 text-right" for="form-field-1-1">Coupon Apply
                                                Status
                                            </label>
                                            <div class="col-sm-3 col-xs-8">
                                                <label>
                                                    <input name="coupon_apply_status" class="ace ace-switch ace-switch-6"
                                                        type="checkbox" @if ($coupon->coupon_apply_status == 1 || old('coupon_apply_status') != '') checked @endif>
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>





                                <!-- ACTION -->
                                <div class="btn-group pull-right">
                                    <button class="btn btn-sm btn-primary"> <i class="fa fa-save"></i> Save </button>
                                    <a href="{{ route('inv.coupons.index') }}" class="btn btn-sm btn-secondary"> <i
                                            class="fa fa-list"></i> List </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
