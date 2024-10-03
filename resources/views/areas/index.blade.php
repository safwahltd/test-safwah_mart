@extends('layouts.master')

@section('title', 'Area List')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">
            <a class="btn btn-sm btn-primary" href="{{ route('areas.create') }}">
                <i class="fa fa-plus-circle"></i>
                Add New
            </a>
        </div>
    </div>

    <form action="{{ route('areas.index') }}" method="GET">
        <div class="row" style="display: flex; justify-content:center">

            {{-- Name --}}
            <div class="col-md-12">
                <div class="row" style="display: flex; justify-content:center">

                    <div class="col-md-4">
                        <div class="input-group mb-2 width-100" style="width: 100%">
                            <span class="input-group-addon" style="text-align: left">
                                Name
                            </span>
                            <input type="text" class="form-control" name="name" value="{{ request('name') }}">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="input-group mb-2 width-100" style="width: 100%">
                            <span class="input-group-addon" style="text-align: left">
                                District
                            </span>
                            <select name="district_id" id="district_id" data-placeholder="- Select District-" tabindex="1"
                                    class="form-control select2" style="width: 100%">
                                <option></option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="input-group mb-2 width-100" style="width: 100%">
                            <span class="input-group-addon" style="text-align: left">
                                Order By
                            </span>
                            <select name="order_by" id="order_by" data-placeholder="- Select District-" tabindex="1" class="form-control select2" style="width: 100%">
                                <option></option>
                                @foreach ($orderByFields as $key => $field)
                                    <option value="{{ $key }}" {{ request('order_by', 'name') == $key ? 'selected' : '' }}>{{ $field }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="input-group mb-2 width-100" style="width: 100%">
                            <span class="input-group-addon" style="text-align: left">
                                Order Type
                            </span>
                            <select name="order_type" id="order_type" data-placeholder="- Select District-" tabindex="1" class="form-control select2" style="width: 100%">
                                <option></option>
                                @foreach ($orderTypes as $key => $type)
                                    <option value="{{ $key }}" {{ request('order_type', 'ASC') == $key ? 'selected' : '' }}>{{ $type }}</option>
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

            </div>

        </div>
    </form>

    @include('partials._alert_message')

    @include('areas.show-modal')

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">

                <form action="{{ route('update-areas-data') }}" method="POST">
                    @csrf

                    <table class="table table-bordered table-hover" >
                        <thead>
                            <tr class="table-header-bg">
                                <th width="3%">SL</th>
                                <th width="15%">Area Name</th>
                                <th width="15%">District</th>
                                @if(hasAnyPermission(['orders.free-deliveries'], $slugs))
                                    <th width="15%">Min Purchase Amount</th>
                                    <th width="15%">Free Delivery Amount</th>
                                @endif
                                <th width="5%" class="text-center">Status</th>
                                <th width="15%" class="text-center">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($areas as $item)
                                <tr>
                                    <input type="hidden" name="id[]" value="{{ $item->id }}">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->district->name }}</td>
                                    @if(hasAnyPermission(['orders.free-deliveries'], $slugs))
                                        <td class="text-center">
                                            <input type="number" class="text-center" name="min_purchase_amount[]" value="{{ $item->min_purchase_amount }}">
                                        </td>
                                        <td class="text-center">
                                            <input type="number" class="text-center" name="free_delivery_amount[]" value="{{ $item->free_delivery_amount }}">
                                        </td>
                                    @endif
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
                                            data-district="{{ $item->district->name }}"
                                            data-status="{{ $item->status ? 'Active' : 'In-Active' }}"
                                            >
                                                <i class="fa fa-eye"></i>
                                            </a>

                                            <!-- EDIT -->
                                            <a href="{{ route('areas.edit', $item->id) }}" class="btn btn-xs btn-success" title="Edit">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>

                                            <!-- DELETE -->
                                            @php $countDeliveryManInOrder = \Module\Inventory\Models\Order::where('delivery_man_id', $item->id)->count(); @endphp
                                            @if($countDeliveryManInOrder < 1)
                                                <button class="btn btn-xs btn-danger" title="Delete" onclick="delete_item('{{ route('areas.destroy', $item->id) }}')" type="button">
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

                    @if(hasAnyPermission(['orders.free-deliveries'], $slugs))
                        <div class="save-district-info text-right">
                            <button type="submit" class="btn btn-md btn-primary">
                                <i class="fas fa-save"></i> Save
                            </button>
                        </div>
                    @endif
                </form>

                @include('partials._paginate', ['data'=> $areas])
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function cantDeleteAlert() {
            Swal.fire('<p style="font-size:15px;">You can\'t delete this.</p>')
        }
    </script>

    <!-- SHOW MODAL -->
    <script>
        $(document).ready(function () {
            $('#showDetails').on('show.bs.modal', function (event) {
                let button          = $(event.relatedTarget)
                let name            = button.data('name');
                let district        = button.data('district');
                let status          = button.data('status');
                let modal           = $(this)

                modal.find('.modal-body #name').val(name);
                modal.find('.modal-body #district').val(district);
                modal.find('.modal-body #status').val(status);
            })
        });
    </script>


@endsection
