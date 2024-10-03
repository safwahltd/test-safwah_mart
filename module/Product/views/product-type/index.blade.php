@extends('layouts.master')

@section('title', 'Product Type List')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">
            <a class="btn btn-sm btn-success" href="{{ route('product-type-export') }}">
                <i class="fa fa-download"></i>
                Export List
            </a>
        </div>
    </div>

    @include('partials._alert_message')

    @include('product-type.show-modal')

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" >
                    <thead>
                        <tr class="table-header-bg">
                            <th width="5%">SL</th>
                            {{-- <th width="20%">Image</th> --}}
                            <th width="60%">Name</th>
                            <th width="10%" class="text-center">Status</th>
                            <th width="20%" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($productTypes as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                {{-- <td>
                                    <img src="{{ asset($item->image) }}" alt="Logo" height="100">
                                </td> --}}
                                <td>{{ $item->name }}</td>
                                <td class="text-center">
                                    <!------------- EDIT STATUS ---------------->
                                    @if ((hasPermission("product-types.edit", $slugs)))
                                        <x-status status="{{ $item->status }}" id="{{ $item->id }}" table="{{ $table }}" />
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-corner">
                                        <!-- LOG -->
                                        @include('partials._user-log', ['data' => $item])

                                        <!------------- EDIT STATUS ---------------->
                                        @if ((hasPermission("product-types.edit", $slugs)))
                                            <a href="#showDetails"
                                            role="button" class="btn btn-xs btn-black" title="Show" data-toggle="modal"
                                            data-name="{{ $item->name }}"
                                            data-status="{{ $item->status ? 'Active' : 'In-Active' }}"
                                            data-image="{{ $item->image }}"
                                            >
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        @endif

                                        <!------------- EDIT STATUS ---------------->
                                        @if ((hasPermission("product-types.edit", $slugs)))
                                            <a href="{{ route('product-types.edit', $item->id) }}" class="btn btn-xs btn-success" title="Edit">
                                                <i class="fa fa-pencil-square-o"></i>
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
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function cantDeleteAlert() {
            Swal.fire('<p style="font-size:15px;">You can\'t delete this Brand. Because there are one or more Product(s) has been created in this Brand.</p>')
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
