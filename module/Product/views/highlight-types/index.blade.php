@extends('layouts/master')

@section('title', 'Highlight Types List')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">

            <!------------- CREATE ---------------->
            @if ((hasPermission("highlight-types.create", $slugs)))  
                <a class="btn btn-sm btn-primary" href="{{ route('pdt.highlight-types.create') }}">
                    <i class="fa fa-plus-circle"></i>
                    Add New
                </a>
            @endif

        </div>
    </div>

    <form action="{{ route('pdt.highlight-types.index') }}" method="GET">
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

    @include('highlight-types.show-modal')

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="" class="table table-bordered table-hover" >
                    <thead>
                        <tr class="table-header-bg">
                            <th width="25%">SL</th>
                            <th width="25%">Name</th>
                            <th width="25%" class="text-center">Status</th>
                            <th width="25%" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($highlightTypes as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                
                                <td class="text-center">
                                    <!------------- EDIT ---------------->
                                    @if ((hasPermission("highlight-types.edit", $slugs))) 
                                        <x-status status="{{ $item->status }}" id="{{ $item->id }}" table="{{ $table }}" />
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="javascript:void(0)" class="text-danger fas fa-ellipsis-h" type="button" data-toggle="dropdown"></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            
                                            <!------------- VIEW ---------------->
                                            @if ((hasPermission("highlight-types.view", $slugs))) 
                                                <li>
                                                    <a href="#showDetails"
                                                        role="button" title="Show" data-toggle="modal"
                                                        data-name="{{ $item->name }}"
                                                        data-status="{{ $item->status ? 'Active' : 'In-Active' }}"
                                                    >
                                                        <i class="fa fa-eye"></i> Show
                                                    </a>
                                                </li>
                                            @endif

                                            <!------------- EDIT ---------------->
                                            @if ((hasPermission("highlight-types.edit", $slugs))) 
                                                <li>
                                                    <a href="{{ route('pdt.highlight-types.edit', $item->id) }}" title="Edit">
                                                        <i class="fa fa-pencil-square-o"></i> Edit
                                                    </a>
                                                </li>
                                            @endif

                                            <!------------- DELETE ---------------->
                                            @if ((hasPermission("highlight-types.delete", $slugs))) 
                                                <li>
                                                    <a href="javascript:void(0)" title="Delete" onclick="delete_item('{{ route('pdt.highlight-types.destroy', $item->id) }}')" type="button">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </a>
                                                </li>
                                            @endif
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

                @include('partials._paginate',['data'=> $highlightTypes])
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
                let modal = $(this)

                modal.find('.modal-body #name').val(name);
                modal.find('.modal-body #status').val(status);
            })
        });
    </script>
@endsection
