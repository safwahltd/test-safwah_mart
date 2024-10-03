@extends('layouts.master')

@section('title', 'Brand List')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">
            <a class="btn btn-sm btn-success" href="{{ route('brand-export') }}">
                <i class="fa fa-download"></i>
                Export List
            </a>
            <a class="btn btn-sm btn-primary" href="{{ route('brands.create') }}">
                <i class="fa fa-plus-circle"></i>
                Add New
            </a>
        </div>
    </div>

    <form action="{{ route('brands.index') }}" method="GET">
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

    @include('brand.show-modal')

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" >
                    <thead>
                    <tr class="table-header-bg">
                        <th width="5%">SL</th>
                        <th width="40%">Country</th>
                        <th width="25%">Id</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($country as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->id }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="font-size: 16px" class="text-center text-danger">
                                NO RECORDS FOUND!
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                @include('partials._paginate',['data'=> $country])
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function cantDeleteAlert() {
            Swal.fire('<p style="font-size:15px;">You can\'t delete this Manufacturer. Because there are one or more Product(s) has been created in this Manufacturer.</p>')
        }
    </script>

    <!-- SHOW MODAL -->
    <script>
        $(document).ready(function () {
            $('#showDetails').on('show.bs.modal', function (event) {
                let button = $(event.relatedTarget)
                let name = button.data('name');
                let title = button.data('title');
                let isHighlight = button.data('is-highlight');
                let status = button.data('status');
                let logo = button.data('logo');
                let modal = $(this)

                modal.find('.modal-body #name').val(name);
                modal.find('.modal-body #title').val(title);
                modal.find('.modal-body #isHighlight').val(isHighlight);
                modal.find('.modal-body #status').val(status);
                modal.find('.modal-body #logo').attr('src', "{{ URL::asset('/') }}"+logo);
            })
        });
    </script>
@endsection
