@extends('layouts.master')

@section('title', 'Warehouse List')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">
            <a class="btn btn-sm btn-primary" href="{{ route('inv.warehouses.create') }}">
                <i class="fa fa-plus-circle"></i>
                Add New
            </a>
        </div>
    </div>








    <form action="{{ route('inv.warehouses.index') }}" method="GET">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-6">
                <div class="input-group mb-2 width-100" style="width: 100%">
                    <span class="input-group-addon" style="text-align: left">
                        Search by Name...
                    </span>
                    <input type="text" class="form-control" name="name" value="{{ request('name') }}">
                </div>
            </div>
            <div class="col-md-2 text-right">
                <div class="btn-group mb-2">
                    <button type="submit" class="btn btn-sm btn-black" style="height: 33px; width: 35px; border-top-left-radius: 2px; border-bottom-left-radius: 2px"><i class="fa fa-search"></i></button>
                    <button type="button" class="btn btn-sm btn-dark" onclick="location.href='{{ request()->url() }}'" style="height: 33px; width: 35px; border-top-right-radius: 2px; border-bottom-right-radius: 2px"><i class="fa fa-refresh"></i></button>
                </div>
            </div>
            <div class="col-md-2"></div>
        </div>
    </form>

    @include('partials._alert_message')

    @include('warehouse.show-modal')

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" >
                    <thead>
                        <tr class="table-header-bg">
                            <th width="5%">SL</th>
                            <th width="15%">Name</th>
                            <th width="15%">Phone</th>
                            <th width="15%">BIN No</th>
                            <th width="30%">Address</th>
                            <th width="5%" class="text-center">Status</th>
                            <th width="15%" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($warehouses as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->bin_no }}</td>
                                <td>{{ $item->address }}</td>
                                <td>
                                    <x-status status="{{ $item->status }}" id="{{ $item->id }}" table="{{ $table }}" />
                                    {{-- @if($item['status'] == 1)
                                        <a class="updateWarehouseStatus" id="warehouse-{{ $item->id }}" warehouse_id="{{ $item->id }}" href="javascript:void(0)">
                                            <i class="fa fa-toggle-on text-success bigger-130" status="Active"></i>
                                        </a>
                                    @else
                                        <a class="updateWarehouseStatus" id="warehouse-{{ $item->id }}" warehouse_id="{{ $item->id }}" href="javascript:void(0)">
                                            <i class="fa fa-toggle-off text-danger bigger-130" status="Inactive"></i>
                                        </a>
                                    @endif --}}
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-corner">
                                        <!-- LOG -->
                                        @include('partials._user-log', ['data' => $item])

                                        <!-- SHOW -->
                                        <a href="#showDetails"
                                           role="button" class="btn btn-xs btn-black" title="Show" data-toggle="modal"
                                           data-name="{{ $item->name }}"
                                           data-phone="{{ $item->phone }}"
                                           data-bin-no="{{ $item->bin_no }}"
                                           data-address="{{ $item->address }}"
                                           data-status="{{ $item->status ? 'Active' : 'In-Active' }}"
                                        >
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <!-- EDIT -->
                                        <a href="{{ route('inv.warehouses.edit', $item->id) }}" class="btn btn-xs btn-success" title="Edit">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>

                                        <!-- DELETE -->
                                        @php
                                            $countStock         = \Module\Product\Models\Stock::where('warehouse_id', $item->id)->count();
                                            $countStockSummery  = \Module\Product\Models\StockSummary::where('warehouse_id', $item->id)->count();
                                        @endphp
                                        @if($countStock < 1 || $countStockSummery < 1)
                                            <button class="btn btn-xs btn-danger" title="Delete" type="button" onclick="delete_item('{{ route('inv.warehouses.destroy', $item->id) }}')" type="button">
                                                    <i class="fa fa-trash"></i>
                                            </button>
                                        @else
                                            <button class="btn btn-xs btn-light" onclick="cantDeleteAlert()" href="javascript:void(0)">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="font-size: 16px" class="text-center text-danger">
                                    NO RECORDS FOUND!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @include('partials._paginate',['data'=> $warehouses])
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function cantDeleteAlert() {
            Swal.fire('<p style="font-size:15px;">You can\'t delete this Warehouse. Because there are one or more Purchase(s) / Sale(s) / Report(s) / Other(s) has been created in this Warehouse.</p>')
        }
    </script>

    <!-- SHOW MODAL -->
    <script>
        $(document).ready(function () {
            $('#showDetails').on('show.bs.modal', function (event) {
                let button = $(event.relatedTarget)
                let name = button.data('name');
                let phone = button.data('phone');
                let binNo = button.data('bin-no');
                let address = button.data('address');
                let status = button.data('status');
                let modal = $(this)

                modal.find('.modal-body #name').val(name);
                modal.find('.modal-body #phone').val(phone);
                modal.find('.modal-body #binNo').val(binNo);
                modal.find('.modal-body #address').val(address);
                modal.find('.modal-body #status').val(status);
            })
        });
    </script>
@endsection
