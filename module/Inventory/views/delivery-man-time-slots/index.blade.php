@extends('layouts.master')

@section('title', 'Delivery Man Time Slot List')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">
            <a class="btn btn-sm btn-primary" href="{{ route('inv.delivery-man-time-slots.create') }}">
                <i class="fa fa-plus-circle"></i>
                Add New
            </a>
        </div>
    </div>

    <form action="{{ route('inv.delivery-man-time-slots.index') }}" method="GET">
        <div class="row" style="display: flex; justify-content:space-between;">

            {{-- Delivery Man --}}
            <div class="col-md-4">
                <div class="input-group mb-2 width-100" style="width: 100%">
                    <span class="input-group-addon" style="width: 25%; text-align: left">
                        Delivery Man
                    </span>
                    <select name="delivery_man_id" id="delivery_man_id" data-placeholder="- Select Delivery Man -" tabindex="1"
                            class="form-control select2" style="width: 100%">
                        <option></option>
                        @foreach ($delivery_mans as $item)
                            <option value="{{ $item->id }}" {{ request('delivery_man_id') == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Time Slot --}}
            <div class="col-md-4">
                <div class="input-group mb-2 width-100" style="width: 100%">
                    <span class="input-group-addon" style="width: 25%; text-align: left">
                        Time Slot
                    </span>
                    <select name="time_slot_id" id="time_slot_id" data-placeholder="- Select Time Slot-" tabindex="1"
                            class="form-control select2" style="width: 100%">
                        <option></option>
                        @foreach ($timeSlots as $item)
                            <option value="{{ $item->id }}" {{ request('time_slot_id') == $item->id ? 'selected' : '' }}>{{ $item->name }} ({{ $item->starting_time }} - {{ $item->ending_time }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-2 text-right">
                <div class="btn-group mb-2">
                    <button type="submit" class="btn btn-sm btn-black" style="height: 33px; width: 35px; border-top-left-radius: 2px; border-bottom-left-radius: 2px"><i class="fa fa-search"></i></button>
                    <button type="button" class="btn btn-sm btn-dark" onclick="location.href='{{ request()->url() }}'" style="height: 33px; width: 35px; border-top-right-radius: 2px; border-bottom-right-radius: 2px"><i class="fa fa-refresh"></i></button>
                </div>
            </div>

        </div>
    </form>

    @include('partials._alert_message')

    @include('delivery-man-time-slots.show-modal')

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" >
                    <thead>
                        <tr class="table-header-bg">
                            <th width="5%">SL</th>
                            <th width="10%">Delivery Man</th>
                            <th width="15%">Slot</th>
                            <th width="10%">Time</th>
                            <th width="5%" class="text-center">Status</th>
                            <th width="15%" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($deliveryManTimeslots as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->delivery_man->name }}</td>
                                <td>{{ $item->time_slot->name }}</td>
                                <td>{{ $item->time_slot->starting_time }} - {{ $item->time_slot->ending_time }}</td>
                                <td class="text-center">
                                    <x-status status="{{ $item->status }}" id="{{ $item->id }}" table="{{ $table }}" />
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-corner">
                                        <!-- LOG -->
                                        @include('partials._user-log', ['data' => $item])

                                        <!-- SHOW -->
                                        <a href="#showDetails"
                                           role="button" class="btn btn-xs btn-black" title="Show" data-toggle="modal"
                                           data-delivery-man="{{ $item->delivery_man->name }}"
                                           data-time-slot="{{ $item->time_slot->name }}"
                                           data-starting-time="{{ $item->time_slot->starting_time }}"
                                           data-ending-time="{{ $item->time_slot->ending_time }}"
                                           data-status="{{ $item->status ? 'Active' : 'In-Active' }}"
                                        >
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <!-- EDIT -->
                                        <a href="{{ route('inv.delivery-man-time-slots.edit', $item->id) }}" class="btn btn-xs btn-success" title="Edit">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>

                                        <!-- DELETE -->
                                        @php $countDeliveryManInOrder = \Module\Inventory\Models\Order::where('delivery_man_id', $item->id)->count(); @endphp
                                        @if($countDeliveryManInOrder < 1)
                                            <button class="btn btn-xs btn-danger" title="Delete" onclick="delete_item('{{ route('inv.delivery-man-time-slots.destroy', $item->id) }}')" type="button">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @else
                                            <a class="btn btn-xs btn-light" onclick="cantDeleteAlert()" href="javascript:void(0)">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="font-size: 16px" class="text-center text-danger">
                                    NO RECORDS FOUND!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @include('partials._paginate', ['data'=> $deliveryManTimeslots])
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function cantDeleteAlert() {
            Swal.fire('<p style="font-size:15px;">You can\'t delete this Delivery Man. Because there are one or more Order(s) has in this Delivery Man.</p>')
        }
    </script>

    <!-- SHOW MODAL -->
    <script>
        $(document).ready(function () {
            $('#showDetails').on('show.bs.modal', function (event) {
                let button          = $(event.relatedTarget)
                let deliveryMan     = button.data('delivery-man');
                let timeSlot        = button.data('time-slot');
                let startingTime    = button.data('starting-time');
                let endingTime      = button.data('ending-time');
                let status          = button.data('status');
                let modal           = $(this)

                modal.find('.modal-body #deliveryMan').val(deliveryMan);
                modal.find('.modal-body #timeSlot').val(timeSlot);
                modal.find('.modal-body #startingTime').val(startingTime);
                modal.find('.modal-body #endingTime').val(endingTime);
                modal.find('.modal-body #status').val(status);
            })
        });
    </script>

    @include('delivery-man/_inc/script')

@endsection
