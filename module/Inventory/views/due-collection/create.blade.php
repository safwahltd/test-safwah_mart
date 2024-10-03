@extends('layouts.master')

@section('title', 'Create Due Collection')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="far fa-hand-holding-usd"></i> @yield('title')</h4>
    </div>


    <form class="form-horizontal" action="" method="GET">
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered">
                    <tr>
                        @if (count($warehouses) > 1)
                            <!-- WAREHOUSE -->
                            <td width="25%">
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="far fa-warehouse"></i></span>
                                    <select name="warehouse_id" class="form-control select2" id="warehouse_id" style="width: 100%">
                                        <option selected value="">All Warehouse</option>
        
                                        @foreach ($warehouses as $id => $name)
                                            <option value="{{ $id }}" {{ request('warehouse_id') == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </td>
                        @endif





                        <!-- ORDER DATE -->
                        <td width="{{ count($warehouses) > 1 ? '25%' : '33%' }}">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="far fa-calendar"></i></span>
                                <input type="text" class="form-control date-picker text-center" name="date" value="{{ request('date') }}" autocomplete="off" placeholder="Order Date" data-date-format="yyyy-mm-dd">
                            </div>
                        </td>




                        <!-- DELIVERY DATE -->
                        <td width="{{ count($warehouses) > 1 ? '25%' : '34%' }}">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="far fa-calendar"></i></span>
                                <input type="text" class="form-control date-picker text-center" name="delivery_date" value="{{ request('delivery_date') }}" autocomplete="off" placeholder="Delivery Date" data-date-format="yyyy-mm-dd">
                            </div>
                        </td>



                        
                        <!-- DELIVERY MAN -->
                        <td width="{{ count($warehouses) > 1 ? '25%' : '33%' }}">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="far fa-biking"></i></span>
                                <select name="delivery_man_id" class="form-control select2" id="delivery_man_id" style="width: 100%">
                                    <option selected value="">All Delivery Man</option>
    
                                    @foreach ($deliveryMans as $deliveryMan)
                                        <option value="{{ $deliveryMan->id }}" {{ request('delivery_man_id') == $deliveryMan->id ? 'selected' : '' }}>
                                            {{ $deliveryMan->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                    </tr>





                    <tr>
                        <!-- ACTION -->
                        <td colspan="{{ count($warehouses) > 1 ? '4' : '3' }}" class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary" style="padding-top: 6px; padding-bottom: 6px;"><i class="fa fa-search"></i> SEARCH</button>
                                <a href="{{ request()->url() }}" class="btn btn-sm btn-light" style="width: 49%; padding-top: 6px; padding-bottom: 6px;"><i class="fa fa-refresh"></i> REFRESH</a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </form>






    <form action="{{ route('inv.due-collections.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-xs-12">
                <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                    <thead style="border-bottom: 3px solid #346cb0 !important">
                        <tr style="background: #e1ecff !important; color:black !important">
                            <th width="4%" class="text-center">SL</th>
                            <th width="10%">Order No</th>
                            <th width="{{ count($warehouses) > 1 ? '15%' : '22%' }}">Customer</th>
                            <th width="10%">Order Date</th>
                            <th width="12%">Delivery Date</th>
                            <th width="{{ count($warehouses) > 1 ? '15%' : '22%' }}">Delivery Man</th>
                            @if (count($warehouses) > 1)
                                <th width="10%">Warehouse</th>
                            @endif
                            <th width="10%" class="text-right">Due Amount</th>
                            <th class="text-center">
                                <div class="checkbox" style="padding-top: 3px !important; width: 90px !important">
                                    <label style="padding-left: 12px">
                                        <input type="checkbox" class="ace check-all-item">
                                        <span class="lbl"> Paid All</span>
                                    </label>
                                </div>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $thisPageTotalDue = 0;
                        @endphp

                        @foreach ($receivableDues as $item)
                            @php
                                $thisPageTotalDue += $item->grand_total;
                            @endphp

                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    @if ($invoice1 == 1)
                                        <a href="{{ route('inv.orders.show', $item->id) }}?copy=customer" target="_blank">{{ $item->order_no }}</a>
                                    @elseif ($invoice2 == 1)
                                        <a href="{{ route('inv.orders.show', $item->id) }}?type=invoice2" target="_blank">{{ $item->order_no }}</a>
                                    @endif    
                               </td>
                                <td>
                                    {{ optional($item->customer)->name }} 
                                    <b>({{ optional($item->customer)->mobile }})</b>
                                </td>
                                <td>{{ $item->date }}</td>
                                <td>{{ $item->delivery_date }}</td>
                                <td>
                                    @if ($item->delivery_man_id != null )
                                        {{ optional($item->deliveryMan)->name }} 
                                        <b>({{ optional($item->deliveryMan)->phone  }})</b>
                                    @else
                                        <span class="text-danger">Not Assigned</span>
                                    @endif
                                </td>
                                @if (count($warehouses) > 1)
                                    <td>
                                        @if ($item->warehouse_id != null )
                                            {{ optional($item->warehouse)->name }} 
                                        @else
                                            <span class="text-danger">Not Assigned</span>
                                        @endif
                                    </td>
                                @endif
                                <td class="text-right">{{ number_format($item->grand_total, 2, '.', '') }}</td>
                                <td class="text-center">
                                    <div class="checkbox my-0">
                                        <label>
                                            <input type="checkbox" name="order_id[]" value="{{ $item->id }}" class="ace check-item">
                                            <span class="lbl"></span>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>



                    <tfoot id="tfoot">
                        <tr>
                            <th colspan="{{ count($warehouses) > 1 ? '7' : '6' }}" class="text-right">This Page Total</th>
                            <th class="text-right">{{ number_format($thisPageTotalDue, 2, '.', '') }}</th>
                            <th></th>
                        </tr>
                        <tr style="background: #ddd !important; color:black !important">
                            <th colspan="{{ count($warehouses) > 1 ? '7' : '6' }}" class="text-right">All Page Total</th>
                            <th class="text-right">{{ number_format($totalDueAmount, 2, '.', '') }}</th>
                            <th></th>
                        </tr>
                    </tfoot>
                </table>


                <div id="patinations">
                    @include('partials._paginate', ['data' => $receivableDues])
                </div>

                <div class="btn-group pull-right" id="actionBtn" style="display: none">
                    <button class="btn btn-theme" type="submit" onclick="return confirm('Are you sure to Collect(s) Payment.')" style="border-radius: 5px; margin-right: 5px"><i class="far fa-check-circle"></i> COLLECT</button>
                    <button class="btn btn-danger" onclick="cancel()" style="border-radius: 5px; height: 36px; line-height: 18px"><i class="fas fa-ban"></i> Cancel</button>
                </div>
            </div>
        </div>
    </form>
@endsection


@section('script')
    <script>
        $(document).on('click', '.check-all-item', function() {
            let check = $(this).is(':checked');
            if (check) {
                $('.check-item').prop('checked', true);
				$('#actionBtn').show();
				$('#patinations').hide();
				$('#tfoot').hide();
            } else {
                $('.check-item').prop('checked', false);
				$('#actionBtn').hide();
				$('#patinations').show();
				$('#tfoot').show();
            }
        });

        
        $(document).on('click', '.check-item', function() {
            if($(this).prop("checked") == true){
				$('#actionBtn').show();
				$('#patinations').hide();
				$('#tfoot').hide();
            }
            else if($(this).prop("checked") == false) {
				
				let count = 0;
				$('.check-item').each(function(index) {
					count += $(this).is(':checked') ? 1 : 0;
				})

				if (count == 0) {
					$('#actionBtn').hide();
				    $('#patinations').show();
				    $('#tfoot').show();
				}
            }
        });



        function cancel()
        {
            $('.check-all-item').prop('checked', false);
            $('.check-item').prop('checked', false);
            $('#actionBtn').hide();
            $('#patinations').show();
            $('#tfoot').show();
        }
    </script>
@endsection