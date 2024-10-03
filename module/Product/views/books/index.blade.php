@extends('layouts.master')

@section('title', 'Book List')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">
            <a class="btn btn-sm btn-primary" href="{{ route('pdt.products.create') }}">
                <i class="fa fa-plus-circle"></i>
                Add New
            </a>
        </div>
    </div>

    <form action="{{ route('pdt.books.index') }}" method="GET">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-6">
                <div class="input-group mb-2 width-100" style="width: 100%">
                    <span class="input-group-addon" style="text-align: left">
                        Search by Publisher...
                    </span>
                    <input type="text" class="form-control" name="publisher_id" value="{{ request('publisher_id') }}">
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

    @include('books.show-modal')

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" >
                    <thead>
                    <tr class="table-header-bg">
                        <th width="5%">SL</th>
                        <th width="10%">Attachment</th>
                        <th width="10%">Product</th>
                        <th width="10%">Writer</th>
                        <th width="10%">Publisher</th>
                        <th width="10%">Published At</th>
                        <th width="10%">ISBN</th>
                        <th width="10%">Edition</th>
                        <th width="12%">Number of Pages</th>
                        <th width="8%">Language</th>
                        <th width="5%" class="text-center">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($books as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ file_exists($item->attachment) ? asset($item->attachment) : asset('default.svg') }}" alt="product img" width="60px;">
                            </td>
                            <td>{{ optional($item->product)->name }}</td>
                            <td>{{ optional($item->writer)->name }}</td>
                            <td>{{ optional($item->publisher)->name }}</td>
                            <td>{{ $item->published_at }}</td>
                            <td>{{ $item->isbn }}</td>
                            <td>{{ $item->edition }}</td>
                            <td>{{ $item->number_of_pages }}</td>
                            <td>{{ $item->language }}</td>

                            <td class="text-center">
                                <div class="dropdown">
                                    <a href="javascript:void(0)" class="text-danger fas fa-ellipsis-h" type="button" data-toggle="dropdown"></a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li>
                                            <a href="#showDetails"
                                                role="button" title="Show" data-toggle="modal"
                                                data-name="{{ $item->name }}"
                                            >
                                                <i class="fa fa-eye"></i> Show
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('pdt.products.edit', $item->product_id) }}" title="Edit">
                                                <i class="fa fa-pencil-square-o"></i> Edit
                                            </a>
                                        </li>

                                        <li>
                                            <a href="javascript:void(0)" title="Delete" onclick="delete_item('{{ route('pdt.books.destroy', $item->id) }}')" type="button">
                                                <i class="fa fa-trash"></i>Delete
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
                            <td colspan="7" style="font-size: 16px" class="text-center text-danger">
                                NO RECORDS FOUND!
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                @include('partials._paginate',['data'=> $books])
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
                let modal = $(this)

                modal.find('.modal-body #name').val(name);
            })
        });
    </script>
@endsection
