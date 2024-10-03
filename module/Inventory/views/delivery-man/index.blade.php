@extends('layouts.master')

@section('title', 'Delivery Man List')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">
            <a class="btn btn-sm btn-primary" href="{{ route('inv.delivery-mans.create') }}">
                <i class="fa fa-plus-circle"></i>
                Add New
            </a>
        </div>
    </div>

    <form action="{{ route('inv.delivery-mans.index') }}" method="GET">
        <div class="row">
            {{-- Delivery Type --}}
            <div class="col-md-2">
                <div class="input-group mb-2 width-100" style="width: 100%">
                    <span class="input-group-addon" style="width: 20%; text-align: left">
                        Type
                    </span>
                    <select name="delivery_type" id="delivery_type" data-placeholder="- Select -" tabindex="1"
                            class="form-control select2" style="width: 100%">
                        <option></option>
                        @foreach($deliveryTypes ?? [] as $deliveryType)
                            <option
                                value="{{ $deliveryType }}" {{ request('delivery_type') == $deliveryType ? 'selected' : '' }}>{{ $deliveryType }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- District --}}
            <div class="col-md-3">
                <div class="input-group mb-2 width-100" style="width: 100%">
                    <span class="input-group-addon" style="width: 30%; text-align: left">
                        District
                    </span>
                    <select name="district_id" id="district_id" onchange="getAreas(this)" data-placeholder="- Select District-" tabindex="1" class="form-control select2" style="width: 100%">
                        <option></option>
                        @foreach ($districts as $district)
                            <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Area --}}
            <div class="col-md-3">
                <div class="input-group mb-2 width-100" style="width: 100%">
                    <span class="input-group-addon" style="width: 25%; text-align: left">
                        Area
                    </span>
                    <select name="area_id" id="area_id" data-placeholder="- Select Area-" tabindex="1"
                            class="form-control select2" style="width: 100%">
                        <option></option>
                        @foreach ($areas as $area)
                            <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- Name --}}
            <div class="col-md-4">
                <div class="row">
                    <div class="col-md-9">
                        <div class="input-group mb-2 width-100" style="width: 100%">
                            <span class="input-group-addon" style="text-align: left">
                                Name
                            </span>
                            <input type="text" class="form-control" name="name" value="{{ request('name') }}">
                        </div>
                    </div>
                    <div class="col-md-3 text-right">
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

    @include('delivery-man.show-modal')

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" >
                    <thead>
                        <tr class="table-header-bg">
                            <th width="5%">SL</th>
                            <th width="10%">Delivery Type</th>
                            <th width="15%">Name</th>
                            <th width="10%">District</th>
                            <th width="10%">Area</th>
                            <th width="15%">Phone</th>
                            <th width="15%">Email</th>
                            <th width="5%" class="text-center">Status</th>
                            <th width="15%" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($deliveryMans as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->delivery_type }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->district->name ?? ''}}</td>
                                <td>{{ $item->area->name ?? ''}}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->email }}</td>
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
                                           data-delivery-type="{{ $item->delivery_type }}"
                                           data-name="{{ $item->name }}"
                                           data-district="{{ $item->district->name ?? '' }}"
                                           data-area="{{ $item->area->name ?? ''}}"
                                           data-phone="{{ $item->phone }}"
                                           data-email="{{ $item->email }}"
                                           data-address="{{ $item->address }}"
                                           data-status="{{ $item->status ? 'Active' : 'In-Active' }}"
                                        >
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <!-- EDIT -->
                                        <a href="{{ route('inv.delivery-mans.edit', $item->id) }}" class="btn btn-xs btn-success" title="Edit">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>

                                        <!-- DELETE -->
                                        @php $countDeliveryManInOrder = \Module\Inventory\Models\Order::where('delivery_man_id', $item->id)->count(); @endphp
                                        @if($countDeliveryManInOrder < 1)
                                            <button class="btn btn-xs btn-danger" title="Delete" onclick="delete_item('{{ route('inv.delivery-mans.destroy', $item->id) }}')" type="button">
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

                @include('partials._paginate', ['data'=> $deliveryMans])
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
                let deliveryType    = button.data('delivery-type');
                let name            = button.data('name');
                let district        = button.data('district');
                let area            = button.data('area');
                let phone           = button.data('phone');
                let email           = button.data('email');
                let address         = button.data('address');
                let status          = button.data('status');
                let modal           = $(this)

                modal.find('.modal-body #deliveryType').val(deliveryType);
                modal.find('.modal-body #name').val(name);
                modal.find('.modal-body #district').val(district);
                modal.find('.modal-body #area').val(area);
                modal.find('.modal-body #phone').val(phone);
                modal.find('.modal-body #email').val(email);
                modal.find('.modal-body #address').val(address);
                modal.find('.modal-body #status').val(status);
            })
        });
    </script>

    @include('delivery-man/_inc/script')

@endsection
