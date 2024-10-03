@extends('layouts/master')

@section('title', 'Publishers List')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">
            <a class="btn btn-sm btn-primary" href="{{ route('pdt.publishers.create') }}">
                <i class="fa fa-plus-circle"></i>
                Add New
            </a>
        </div>
    </div>

    <form action="{{ route('pdt.publishers.index') }}" method="GET">
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

    @include('writers.show-modal')

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="" class="table table-bordered table-hover" >
                    <thead>
                        <tr class="table-header-bg">
                            <th width="5%">SL</th>
                            <th width="10%">Image</th>
                            <th width="10%">Cover Photo</th>
                            <th width="10%">Name</th>
                            <th width="15%">email</th>
                            <th width="10%">title</th>
                            <th width="10%">phone</th>
                            <th width="15%">description</th>
                            <th width="10%">address</th>
                            <th width="5%" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($publishers as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ asset($item->logo) }}" width="60" alt="logo">
                                </td>
                                <td>
                                    <img src="{{ asset($item->cover_photo) }}" width="60" alt="cover_photo">
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->description }}</td>
                                <td>{{ $item->address }}</td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="javascript:void(0)" class="text-danger fas fa-ellipsis-h" type="button" data-toggle="dropdown"></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a href="#showDetails"
                                                    role="button" title="Show" data-toggle="modal"
                                                    data-name="{{ $item->name }}"
                                                    data-code="{{ $item->code }}"
                                                    data-type="{{ optional($item->productType)->name }}"
                                                    data-status="{{ $item->status ? 'Active' : 'In-Active' }}"
                                                >
                                                    <i class="fa fa-eye"></i> Show
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('pdt.publishers.edit', $item->id) }}" title="Edit">
                                                    <i class="fa fa-pencil-square-o"></i> Edit
                                                </a>
                                            </li>
                                            {{-- DELETE START --}}
                                            @php $countWriterInBook = \Module\Product\Models\BookProduct::where('publisher_id', $item->id)->count(); @endphp
                                            <li>
                                                @if($countWriterInBook < 1)
                                                    <a href="javascript:void(0)" title="Delete" onclick="delete_item('{{ route('pdt.publishers.destroy', $item->id) }}')" type="button">
                                                        <i class="fa fa-trash"></i>Delete
                                                    </a>
                                                @else
                                                    <a class="btn btn-xs btn-light" onclick="cantDeleteAlert()" href="javascript:void(0)">
                                                        <i class="fa fa-trash"></i>Delete
                                                    </a>
                                                @endif
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
                                <td colspan="8" style="font-size: 16px" class="text-center text-danger">
                                    NO RECORDS FOUND!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @include('partials._paginate',['data'=> $publishers])
            </div>
        </div>
    </div>
@endsection

@section('script')

    <script>
        function cantDeleteAlert() {
            Swal.fire('<p style="font-size:15px;">You can\'t delete this Publisher. Because there are one or more Publisher has in this Book.</p>')
        }
    </script>

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
