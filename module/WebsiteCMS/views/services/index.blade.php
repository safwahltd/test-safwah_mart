@extends('layouts/master')

@section('title', 'Services List')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">
            {{-- @if ($services->count() < 4) --}}
                <a class="btn btn-sm btn-primary" href="{{ route('website.services.create') }}">
                    <i class="fa fa-plus-circle"></i>
                    Add New
                </a>
            {{-- @endif --}}
        </div>
    </div>

    <form action="{{ route('website.services.index') }}" method="GET">
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

    @include('blogs.show-modal')

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="" class="table table-bordered table-hover" >
                    <thead>
                        <tr class="table-header-bg">
                            <th width="15%">SL</th>
                            <th width="20%" class="text-center">Icon/Image</th>
                            <th width="20%">Name</th>
                            <th width="20%">Description</th>
                            <th width="10%" class="text-center">Status</th>
                            <th width="15%" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($services as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    @if ($item->icon == null)
                                        <img src="{{ asset($item->image) }}" width="20" height="20" alt="Image">
                                    @else
                                        <i class="{{ $item->icon }} fa-2x"></i>
                                    @endif
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->description }}</td>
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
                                           data-status="{{ $item->status ? 'Active' : 'In-Active' }}"
                                           data-image="{{ $item->image }}"
                                        >
                                            <i class="fa fa-eye"></i>
                                        </a>

                                        <!-- EDIT -->
                                        <a href="{{ route('website.services.edit', $item->id) }}" class="btn btn-xs btn-success" title="Edit">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>

                                        <!-- DELETE -->

                                        <button class="btn btn-xs btn-danger" title="Delete" onclick="delete_item('{{ route('website.services.destroy', $item->id) }}')" type="button">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="font-size: 16px" class="text-center text-danger">
                                    NO RECORDS FOUND!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @include('partials._paginate',['data'=> $services])
            </div>
        </div>
    </div>
@endsection

@section('script')

    <!-- SHOW MODAL -->
    <script>
        $(document).ready(function () {
            $('#showDetails').on('show.bs.modal', function (event) {
                let button = $(event.relatedTarget)
                let name = button.data('name');
                let status = button.data('status');
                let image = button.data('image');
                let modal = $(this)

                modal.find('.modal-body #name').val(name);
                modal.find('.modal-body #status').val(status);
                modal.find('.modal-body #image').attr('src', "{{ URL::asset('/') }}"+image);
            })
        });
    </script>
@endsection
