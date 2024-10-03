@extends('layouts.master')

@section('title', 'Subscribers List')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        {{-- <div class="btn-group">
            <a class="btn btn-sm btn-primary" href="{{ route('website.subscribers.create') }}">
                <i class="fa fa-plus-circle"></i>
                Add New
            </a>
        </div> --}}
    </div>

    <form action="{{ route('website.subscribers.index') }}" method="GET">
        <div class="row" style="display: flex; justify-content:center">

            {{-- Email --}}
            <div class="col-md-7">
                <div class="row" style="display: flex; justify-content:center">

                    <div class="col-md-8">
                        <div class="input-group mb-2 width-100" style="width: 100%">
                            <span class="input-group-addon" style="text-align: left">
                                Subscribers Email
                            </span>
                            <input type="email" class="form-control" name="email" value="{{ request('email') }}">
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

    @include('subscribers.show-modal')

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" >
                    <thead>
                        <tr class="table-header-bg">
                            <th width="10%">SL</th>
                            <th width="20%">Email</th>
                            <th width="20%" class="text-center">Status</th>
                            <th width="20%" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($subscribers as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
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
                                           data-email="{{ $item->email }}"
                                           data-status="{{ $item->status ? 'Active' : 'In-Active' }}"
                                        >
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <!-- EDIT -->
                                        <a href="{{ route('website.subscribers.edit', $item->id) }}" class="btn btn-xs btn-success" title="Edit">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>

                                        <!-- DELETE -->
                                        @php $countDeliveryManInOrder = \Module\Inventory\Models\Order::where('delivery_man_id', $item->id)->count(); @endphp
                                        @if($countDeliveryManInOrder < 1)
                                            <button class="btn btn-xs btn-danger" title="Delete" onclick="delete_item('{{ route('website.subscribers.destroy', $item->id) }}')" type="button">
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

                @include('partials._paginate', ['data'=> $subscribers])
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
                let email            = button.data('email');
                let shipping_cost   = button.data('shipping-cost');
                let status          = button.data('status');
                let modal           = $(this)

                modal.find('.modal-body #email').val(email);
                modal.find('.modal-body #status').val(status);
            })
        });
    </script>


@endsection
