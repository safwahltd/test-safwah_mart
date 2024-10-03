@extends('layouts.master')
@section('title', 'Edit Discount')

@section('content')
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-edit"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li><a class="text-muted" href="{{ route('discounts.index') }}">Discount</a></li>
            <li class=""><a href="javascript:void(0)">Edit</a></li>
        </ul>
    </div>

    <div class="row">
        <div class="col-12">



            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('discounts.update', $discount->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('partials._alert_message')

                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">

                                <!-- OFFER -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Offer</span>
                                        <select name="offer_id" class="form-control select2" style="width: 100%">
                                            @foreach($offers as $id => $name)
                                                <option value="{{ $id }}" {{ old('offer_id', $discount->offer_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- PRODUCT -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Product</span>
                                        <input type="text" class="form-control" value="{{ optional($discount->product)->name }}" readonly>
                                    </div>
                                </div>


                                <!-- MRP -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">MRP</span>
                                        <input type="text" class="form-control sale-price" value="{{ optional($discount->product)->sale_price }}" readonly>
                                    </div>
                                </div>


                                <!-- DICOUNT PERCENT -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Discount(%) <sup class="text-danger">*</sup></span>
                                        <input type="text" name="discount_percentage" class="form-control discount-percentage only-number" value="{{ $discount->discount_percentage }}" required>
                                    </div>
                                </div>


                                <!-- DICOUNT ALERT -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Discount(Flat) <sup class="text-danger">*</sup></span>
                                        <input type="text" name="discount_flat" class="form-control discount-flat only-number" value="{{ $discount->discount_flat }}" required>
                                    </div>
                                </div>


                                <!-- START DATE -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Start Date <sup class="text-danger">*</sup></span>
                                        <input type="text" name="start_date" class="form-control date-picker start-date data-validation" value="{{ $discount->start_date }}" autocomplete="off" data-date-format="yyyy-mm-dd" required>
                                    </div>
                                </div>


                                <!-- END DATE -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">End Date <sup class="text-danger">*</sup></span>
                                        <input type="text" name="end_date" class="form-control date-picker end-date data-validation" value="{{ $discount->end_date }}" autocomplete="off" data-date-format="yyyy-mm-dd" required>
                                    </div>
                                </div>


                                <!-- SHOW IN OFFER -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Show in Offer</span>
                                        <div class="material-switch pt-1 pl-3">
                                            <input type="checkbox" id="show_in_offer" name="show_in_offer" {{ $discount->show_in_offer == 1 ? 'checked' : '' }} />
                                            <label for="show_in_offer" class="badge-primary"></label>
                                        </div>
                                    </div>
                                </div>


                                <!-- ACTION -->
                                <div class="btn-group pull-right">
                                    <button class="btn btn-sm btn-primary"> <i class="fa fa-save"></i> Update </button>
                                    <a href="{{ route('discounts.index') }}" class="btn btn-sm btn-secondary"> <i class="fa fa-list"></i> List </a>
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
<script>
    $(document).on('change', '.data-validation', function () {
        let startDate = $('.start-date').val();
        let endDate   = $('.end-date').val();

        if (new Date(startDate).getTime() >= new Date(endDate).getTime()) {

            alert("End date is smaller then start date");

            $(this).val('')
        }
    })




    // DISCOUNT PERCENT TO FLAT AMOUNT
    $(document).on('keyup', '.discount-percentage', function() {
        let percent = Number($(this).val())
        let price   = Number($('.sale-price').val())

        if(percent > 100) {
            percent = 100
            $(this).val(100)
        }

        let discount = ((price * percent) / 100).toFixed(2)

        $('.discount-flat').val(discount)
    })


    // DISCOUNT PERCENT TO FLAT AMOUNT
    $(document).on('keyup', '.discount-flat', function() {
        let flat = Number($(this).val())
        let price   = Number($('.sale-price').val())

        if(flat < 0) {
            flat = 0
            $(this).val(0)
        }

        let discount = ((flat * 100) / price).toFixed(2)

        $('.discount-percentage').val(discount)
    })
</script>
@endsection
