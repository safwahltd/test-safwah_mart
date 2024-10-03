@extends('layouts.master')

@section('title','Currency Conversion')

@section('page-header')
    <i class="fa fa-list"></i> Currency Conversion
@stop

@section('css')

    <link rel="stylesheet" href="{{ asset('assets/css/chosen.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-datepicker3.min.css') }}" />
    <style type="text/css">

        .rate-entry-table  tr td:nth-child(4) {
            text-align: center;
        }
        .rate-entry-table  tr td:nth-child(3) {
            text-align: right;
            padding-right: 10px !important;
        }

    </style>
@stop


@section('content')


    <div class="row">
        <div class="col-sm-12">

            <!-- heading -->
            <div class="widget-box widget-color-white ui-sortable-handle clearfix" id="widget-box-7">
                <div class="widget-header widget-header-small">
                    <h3 class="widget-title smaller text-primary">
                        @yield('page-header')
                        <span style="font-size: 14px;"></span>
                    </h3>
                </div>

                <!-- filter -->
                <div class="row">
                    <form class="form-horizontal set-filter-form" action="" method="get">
                        <div class="col-sm-12">
                            <table class="table table-bordered">
                                <tr>
                                    <td style="max-width: 300px !important; min-width: 250px !important;">
                                        <div class="input-group" style="width: 100%">
                                            <span class="input-group-addon" style="text-align:left; width:115px; background: transparent !important;">Effected From</span>
                                            <input type="text" name="month" required class="form-control input-sm month-picker" style="width: 150px" autocomplete="off" value="{{ request('month') ?: date('Y-m') }}">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-corner">
                                            <button class="btn btn-primary btn-xs"><i class="fa fa-search"></i> Set</button>
                                            <a href="{{ route('currency-conversions.create') }}" class="btn btn-info btn-xs"><i class="fa fa-refresh"></i> Refresh</a>
                                        </div>
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </form>
                </div>


                <div class="space"></div>


                <!-- entry form -->
                    <div class="row">
                        <form class="form-horizontal currency-conversion-submit-form" action="{{ route('currency-conversions.store') }}" method="post">
                            @csrf

                            <input type="hidden" name="month" value="{{ request('month') ?: date('Y-m') }}">

                            <!-- employee production rate input area -->
                            <div class="col-md-8 col-md-offset-2" style="margin-bottom: 10px !important;">
                                <table style="width: 98%; margin-left: 1%; border: 2px solid gray" class="table table-bordered rate-entry-table">
                                    <tr style="border-bottom: 1px solid gray !important;">
                                        <td colspan="5" class="text-left" style="font-size: 15px; background: #576567; color: white">
                                            <b style="text-decoration: underline">Currency Conversion</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="5">

                                            <!-- item dropdown -->
                                            <div class="input-group input-group-sm" style="width: 45%!important; float: left; ">
                                                <label class="input-group-addon">Currency</label>
                                                <select class="chosen-select currency form-control form-control-sm">
                                                    <option value="">- Select -</option>
                                                </select>
                                            </div>

                                            <!-- rate -->
                                            <div class="input-group input-group-sm" style="width: 25%!important; margin-left: auto !important; float: left; ">
{{--                                                <label class="input-group-addon">Rate</label>--}}
                                                <input class="form-control form-control-sm rate" title="Hit enter to add item" placeholder="Rate" style="; margin-left: 20px !important; width: 140px" onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="35%">Currency From</td>
                                        <td width="20%">To BDT Rate</td>
                                        <td width="5%">Action</td>
                                    </tr>
                                    <tbody id="currency_rate_entry_table"></tbody>
                                </table>
                            </div>


                            <div class="col-sm-12">
                                <table class="table rate-entry-tables" style="width: 98%; margin-left: 1%">
                                    <tr>
                                        <td colspan="4" class="text-right">
                                            <a href="{{ route('currency-conversions.index') }}" class="btn btn-sm" style="letter-spacing: 1.5px"><i class="fa fa-list"></i> List</a>
                                            <button type="button" class="btn btn-sm btn-success save-button" onclick="return checkSubmittable(this)" style="letter-spacing: 1.5px"><i class="fa fa-save"></i> Save</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>

@endsection

@section('js')
    <script src="{{ asset('assets/js/chosen.jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-datepicker.min.js') }}"></script>

    <script src="{{ asset('assets/js/ace-elements.min.js') }}"></script>
    <script src="{{ asset('assets/js/ace.min.js') }}"></script>


    <!--  Select Box Search-->
    <script type="text/javascript" src="{{ asset('assets/custom_js/chosen-box.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/custom_js/month-picker.js') }}"></script>





    <!-- load production rates -->
    <script type="text/javascript">


        let removedItems = [];

        <?php if(count($currencies) > 0) {?>
            let data = {!! $currencies !!};

            loadItemsToDropdown()
        <?php } ?>

        $('.save-button').attr('disabled', true)

        // <!-- added production item when press enter
        $('.rate').keypress(function(event) {
            // <!-- first catch key code
            let keycode = (event.keyCode ? event.keyCode : event.which);

            // <!-- check key is enter
            if(keycode == '13'){
                // <!-- prevent form submit
                event.preventDefault();

                $('.save-button').attr('disabled', false)
                let currency_list = $('.currency option:selected');
                if ($(this).val() != '' && currency_list.val() != '') {
                    let r = document.getElementById('currency_rate_entry_table').insertRow();
                    let c1 = r.insertCell(0);
                    let c2 = r.insertCell(1);
                    let c3 = r.insertCell(2);

                    c1.innerHTML = '<span class="currency_list">' + currency_list.html() + '</span>' + '<input type="hidden" name="currency_ids[]" value="' + currency_list.val() + '">';
                    c2.innerHTML = '<input type="text" onkeypress="return event.charCode == 46 || (event.charCode >= 48 && event.charCode <= 57)" name="currency_rates[]" class="currency-rate form-control input-sm" value="' + $(this).val() + '">';
                    c3.innerHTML = '<button onclick="deleteItem(this)" tabindex="-1000" class="btn btn-sm btn-danger" data-id="' + $(this).val() + '"> <i class="fa fa-times"></i> </button>';

                    $(this).val('')
                    removedItems.push(currency_list.html())
                    loadItemsToDropdown()
                    $('.currency').trigger('chosen:activate')
                    calculateTotalProduction()
                }

            }
        });

        // <!-- prevent chosen select enter key event and move cursor to rate field -->
        $(".currency").chosen()
        container = $(".currency").data("chosen").container
        container.bind("keypress", function(event){
            if (event.keyCode == 13) {
                event.preventDefault();
                $('.rate').focus()
            }
        });


        // <!-- delete item from table and push into item list
        function deleteItem(event) {
            let currency_list = $(event).closest('tr').find('.currency_list').text()
            $(event).closest('tr').remove()
            remove_array_element(currency_list);
            loadItemsToDropdown()

            if ($('.currency_list').length < 1) {
                $('.save-button').attr('disabled', true)
            }
        }

        // <!-- load items to dropdown
        function loadItemsToDropdown() {
            $('.currency').empty();
            $('.currency').append('<option value=""> Select </option>');
            let count = 0
            Object.keys(data).forEach(function(key) {
                if(removedItems.indexOf(data[key].name) !== -1){
                    // alert("Value exists!")
                } else{
                    count++
                    $('.currency').append('<option value="' + data[key].id + '">' + data[key].name + '</option>').trigger('chosen:updated')
                }
            });
            if (count == 0) {
                $('.currency').empty();
                $('.currency').append('<option value=""> Select </option>').trigger('chosen:updated');
            }
        }
        // <!-- remove item from an array
        function remove_array_element(n)
        {
            var index = removedItems.indexOf(n);
            if (index > -1) {
                removedItems.splice(index, 1);
            }
        }

        function checkSubmittable(event)
        {
            $('.currency-conversion-submit-form').submit()
        }
    </script>
@endsection


