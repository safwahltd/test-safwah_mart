@extends('layouts.master')

@section('title', 'Customer List')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">
            @if(hasPermission("inv.customers.create", $slugs))
                <a class="btn btn-sm btn-primary" href="{{ route('inv.customers.create') }}">
                    <i class="fa fa-plus-circle"></i>
                    Add New
                </a>
            @endif
        </div>
    </div>

    @include('partials._alert_message')

    @include('customer.show-modal')

    <div class="row">

        <form action="{{ route('inv.customers.index') }}" method="GET">

            <div class="col-sm-12">
                <table class="table table-bordered">
                    <tr>

                        <!-- NAME -->
                        <td width="25%">
                            <input type="text" class="form-control" name="name" value="{{ request('name') }}" placeholder="Name">
                        </td>


                        <!-- EMAIL -->
                        <td width="25%">
                            <input type="text" class="form-control" name="email" value="{{ request('email') }}" placeholder="Email">
                        </td>


                        <!-- MOBILE -->
                        <td width="25%">
                            <input type="text" class="form-control" name="mobile" value="{{ request('mobile') }}" placeholder="Phone">
                        </td>


                    </tr>


                    <tr>

                        <!-- DISTRICT -->
                        <td width="34%">
                            <select name="district_id" id="district_id" onchange="getAreas(this)" tabindex="1" class="form-control select2" style="width: 100%">
                                <option value="">- SELECT DISTRICT -</option>
                                <option value="">All</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}" {{ request('district_id') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                                @endforeach
                            </select>
                        </td>


                        <!-- AREA -->
                        <td width="34%">
                            <select name="area_id" id="area_id"  tabindex="1"
                                    class="form-control select2" style="width: 100%">
                                    <option value="">- SELECT AREA -</option>
                                    <option value="">All</option>
                                    @foreach ($areas as $area)
                                    <option value="{{ $area->id }}" {{ request('area_id') == $area->id ? 'selected' : '' }}>{{ $area->name }}</option>
                                @endforeach
                            </select>
                        </td>

                        <!-- GENDER -->
                        <td width="25%">
                            <select name="gender" id="gender" data-placeholder="- Select Gender-" tabindex="1" class="form-control select2" style="width: 100%">
                                <option></option>
                                <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                                <option value="Others" {{ request('gender') == 'Others' ? 'selected' : '' }}>Others</option>
                            </select>
                        </td>

                    </tr>


                    <tr>
                        <!-- ACTION -->
                        <td colspan="4" class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary" style="padding-top: 6px; padding-bottom: 6px;"><i class="fa fa-search"></i> SEARCH</button>
                                <a href="{{ request()->url() }}" class="btn btn-sm btn-light" style="width: 49%; padding-top: 6px; padding-bottom: 6px;"><i class="fa fa-refresh"></i> REFRESH</a>
                            </div>
                        </td>
                    </tr>

                </table>
            </div>

        </form>

        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" >
                    <thead>
                        <tr class="table-header-bg">
                            <th width="5%" class="text-center">SL</th>
                            <th width="25%">Name</th>
                            <th width="20%">Email</th>
                            <th width="15%">Phone</th>
                            <th width="5%">Gender</th>
                            <th width="10%">District</th>
                            <th width="10%">Area</th>
                            <th width="10%" class="text-center">Wallet</th>
                            <th width="10%" class="text-center">Point</th>
                            {{-- <th width="12%">Current Balance</th>
                            <th width="12%">Opening Balance</th> --}}
                            <th width="5%" class="text-center">Status</th>
                            <th width="5%" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($customers as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->mobile }}</td>
                                <td>{{ $item->gender }}</td>
                                <td>{{ optional($item->district)->name }}</td>
                                <td>{{ optional($item->area)->name }}</td>
                                <td class="text-center">
                                    <span class="label label-info label-md">
                                        {{ $item->wallet }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span class="label label-yellow label-lg" style="border-radius: 30px !important">
                                        {{ (int) $item->point }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <x-status status="{{ $item->status }}" id="{{ $item->id }}" table="{{ $table }}" />
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="javascript:void(0)" class="text-danger fas fa-ellipsis-h" type="button" data-toggle="dropdown"></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a href="#showDetails"
                                                role="button" title="Show" data-toggle="modal"
                                                data-id="{{ $item->id }}"
                                                data-name="{{ $item->name }}"
                                                data-email="{{ $item->email }}"
                                                data-mobile="{{ $item->mobile }}"
                                                data-district="{{ optional($item->district)->name }}"
                                                data-area="{{ optional($item->area)->name }}"
                                                data-current-balance="{{ $item->current_balance }}"
                                                data-opening-balance="{{ $item->opening_balance }}"
                                                data-status="{{ $item->status ? 'Active' : 'In-Active' }}"
                                                data-is-default="{{ $item->is_default == 1 ? 'Yes' : 'No' }}"
                                                >
                                                    <i class="fa fa-eye"></i> Show
                                                </a>
                                            </li>
                                            <li>
                                                @if(hasPermission("inv.customers.edit", $slugs))
                                                    <a href="{{ route('inv.customers.edit', $item->id) }}" title="Edit">
                                                        <i class="fa fa-pencil-square-o"></i> Edit
                                                    </a>
                                                @endif
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" title="Delete" onclick="delete_item('{{ route('inv.customers.destroy', $item->id) }}')" type="button">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                            </li>
                                            <li class="divider"></li>
                                            <li>
                                                @include('partials._new-user-log', ['data' => $item])
                                            </li>
                                        </ul>
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

                @include('partials._paginate', ['data'=> $customers])
            </div>
        </div>

    </div>
@endsection

@section('script')

    <!-- SHOW MODAL -->
    <script>
        $(document).ready(function () {
            $('#showDetails').on('show.bs.modal', function (event) {
                let button          = $(event.relatedTarget)
                let id              = button.data('id');
                let name            = button.data('name');
                let email           = button.data('email');
                let mobile          = button.data('mobile');
                let district        = button.data('district');
                let area            = button.data('area');
                let current_balance = button.data('current-balance');
                let opening_balance = button.data('opening-balance');
                let status          = button.data('status');
                let isDefault       = button.data('is-default');
                let modal           = $(this)

                modal.find('.modal-body #id').val(id);
                modal.find('.modal-body #name').val(name);
                modal.find('.modal-body #email').val(email);
                modal.find('.modal-body #mobile').val(mobile);
                modal.find('.modal-body #district').val(district);
                modal.find('.modal-body #area').val(area);
                modal.find('.modal-body #current_balance').val(current_balance);
                modal.find('.modal-body #opening_balance').val(opening_balance);
                modal.find('.modal-body #status').val(status);
                modal.find('.modal-body #default').val(isDefault);
            })
        });
    </script>


    @include('customer/_inc/script')

@endsection
