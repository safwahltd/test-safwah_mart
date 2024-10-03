@extends('layouts.master')

@section('title', 'Time Slots List')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">
            <a class="btn btn-sm btn-primary" href="{{ route('inv.time-slots.create') }}">
                <i class="fa fa-plus-circle"></i>
                Add New
            </a>
        </div>
    </div>

    <form action="{{ route('inv.time-slots.index') }}" method="GET">

        <div style="display: flex; justify-content: space-around;">

                <div class="input-group" style="display: flex">

                    {{-- Starting Time --}}
                    <div class="starting-time">
                        <div class='input-group date' id='datetimepicker1'>
                            <input type='text' name="starting_time" class="form-control" value="{{ request('starting_time') }}" placeholder="Starting Time" autocomplete="off" style=" border-right: none;"/>
                            <span class="input-group-addon" style="padding: 6px 5px; background-color: transparent; ">
                                <i class="far fa-clock"></i>
                            </span>
                        </div>
                    </div>

                    <p class="to"><i class="fas fa-exchange"></i></p>

                    {{-- Ending Time --}}
                    <div class="ending-time">
                        <div class='input-group date' id='datetimepicker2'>
                            <input type='text' name="ending_time" class="form-control" value="{{ request('ending_time') }}" placeholder="Ending Time" autocomplete="off" style=" border-right: none;"/>
                            <span class="input-group-addon" style="padding: 6px 5px; background-color: transparent; ">
                                <i class="far fa-clock"></i>
                            </span>
                        </div>
                    </div>

                </div>

                {{-- Name --}}
                <div class="right-name">
                    <div class="input-group mb-2 width-100">
                        <span class="input-group-addon" style="text-align: left">
                            Name
                        </span>
                        <input type="text" class="form-control" name="name" value="{{ request('name') }}">
                    </div>
                </div>

            <div class="text-right">
                <div class="btn-group mb-2">
                    <button type="submit" class="btn btn-sm btn-black" style="height: 33px; width: 35px; border-top-left-radius: 2px; border-bottom-left-radius: 2px"><i class="fa fa-search"></i></button>
                    <button type="button" class="btn btn-sm btn-dark" onclick="location.href='{{ request()->url() }}'" style="height: 33px; width: 35px; border-top-right-radius: 2px; border-bottom-right-radius: 2px"><i class="fa fa-refresh"></i></button>
                </div>
            </div>

        </div>

    </form>

    @include('partials._alert_message')

    @include('time-slots.show-modal')

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" >
                    <thead>
                        <tr class="table-header-bg">
                            <th width="5%">SL</th>
                            <th width="20%">Name</th>
                            <th width="20%">Starting Time</th>
                            <th width="20%">Ending Time</th>
                            <th width="15%">Disable At</th>
                            <th width="5%" class="text-center">Status</th>
                            <th width="15%" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($timeslots as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->starting_time }}</td>
                                <td>{{ $item->ending_time }}</td>
                                <td>{{ $item->disable_at }}</td>
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
                                           data-name="{{ $item->name }}"
                                           data-starting-time="{{ $item->starting_time }}"
                                           data-ending-time="{{ $item->ending_time }}"
                                           data-status="{{ $item->status ? 'Active' : 'In-Active' }}"
                                        >
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <!-- EDIT -->
                                        <a href="{{ route('inv.time-slots.edit', $item->id) }}" class="btn btn-xs btn-success" title="Edit">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>

                                        <!-- DELETE -->
                                        @php $countDeliveryManInOrder = \Module\Inventory\Models\Order::where('delivery_man_id', $item->id)->count(); @endphp
                                        @if($countDeliveryManInOrder < 1)
                                            <button class="btn btn-xs btn-danger" title="Delete" onclick="delete_item('{{ route('inv.time-slots.destroy', $item->id) }}')" type="button">
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
                                <td colspan="30" style="font-size: 16px" class="text-center text-danger">
                                    NO RECORDS FOUND!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @include('partials._paginate', ['data'=> $timeslots])
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
                let name            = button.data('name');
                let starting_time   = button.data('starting-time');
                let ending_time     = button.data('ending-time');
                let status          = button.data('status');
                let modal           = $(this)

                modal.find('.modal-body #name').val(name);
                modal.find('.modal-body #starting_time').val(starting_time);
                modal.find('.modal-body #ending_time').val(ending_time);
                modal.find('.modal-body #status').val(status);
            })
        });
    </script>




    {{-- DateTime Picker --}}
    <script>
        $(function () {
            $('#datetimepicker1').datetimepicker({
                format: 'hh:mm A'
            });
            $('#datetimepicker2').datetimepicker({
                format: 'hh:mm A'
            });
        });
    </script>



@endsection
