@extends('layouts/master')

@section('title', 'Category List')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">
            <a class="btn btn-sm btn-info" href="{{ route('category-upload') }}">
                <i class="fa fa-download"></i>
                Import List
            </a>
            <a class="btn btn-sm btn-success" href="{{ route('category-export') }}">
                <i class="fa fa-download"></i>
                Export List
            </a>

            <!---------------- CREATE ------------------->
            @if ((hasPermission("categories.create", $slugs)))
                <a class="btn btn-sm btn-primary" href="{{ route('pdt.categories.create') }}">
                    <i class="fa fa-plus-circle"></i>
                    Add New
                </a>
            @endif

            @if (hasAnyPermission(['website-cms.meta-tag'], $slugs))
                <a class="btn btn-sm btn-info" href="{{ route('website.seo-infos.create', 'Category') }}?previous_url=category">
                    <i class="fa fa-plus-circle"></i>
                    Seo Info
                </a>
            @endif

        </div>
    </div>

    <form action="{{ route('pdt.categories.index') }}" method="GET">
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

    @include('category.show-modal')

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="" class="table table-bordered table-hover" >
                    <thead>
                        <tr class="table-header-bg">
                            <th width="3%" class="text-center">SL</th>
                            <th width="5%">Image</th>
                            <th width="15%">Name</th>
                            <th width="10%">Icon</th>
                            <th width="10%">Banner Image</th>
                            <th width="10%" class="text-center">Show on Menu</th>
                            <th width="10%" class="text-center">Highlight</th>
                            <th width="10%">Parent Category</th>
                            <th width="10%" class="text-center">Total Child</th>
                            <th width="3%" class="text-center">Serial Priority</th>
                            <th width="5%" class="text-center">Status</th>
                            <th width="5%" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($categories as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ file_exists($item->image) ? asset($item->image) : asset('default.svg') }}" width="60" alt="Image">
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    <img src="{{ file_exists($item->icon) ? asset($item->icon) : asset('default.svg') }}" width="60" alt="Image">
                                <td>
                                    <img src="{{ file_exists($item->banner_image) ? asset($item->banner_image) : asset('default.svg') }}" width="60" alt="Image">
                                </td>
                                <td class="text-center">
                                    @if($item->show_on_menu == 'Yes')
                                        <span class="label label-sm label-inverse arrowed-in arrowed-in-right">{{ $item->show_on_menu }}</span>
                                    @else
                                        <span class="label label-sm label-warning">{{ $item->show_on_menu }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($item->is_highlight == 'Yes')
                                        <span class="badge badge-sm badge-inverse">{{ $item->is_highlight }}</span>
                                    @else
                                        <span class="badge badge-sm badge-warning">{{ $item->is_highlight }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @foreach (optional($item)->parentCategories ?? [] as $parentCategory)
                                        @include('category/_inc/_parent-categories', ['parentCategories' => $parentCategory->parentCategories])

                                        {{ $parentCategory->name }} {{ !$loop->last ? ',' : '' }}
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('pdt.categories.index') }}?parent_id={{ $item->id }}" title="Show" type="submit" class="label label-yellow label-lg" style="border-radius: 45%">
                                        {{ count($item->childCategories) }}
                                    </a>
                                </td>
                                <td class="text-center">
                                    @if ($item->serial_no != null)
                                        <div class="badge badge-black badge-sm" style="border-radius: 3px; padding: 3px 8px; background-color: black;">
                                            {{ $item->serial_no }}
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <x-status status="{{ $item->status }}" id="{{ $item->id }}" table="{{ $table }}" />
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="javascript:void(0)" class="text-danger fas fa-ellipsis-h" type="button" data-toggle="dropdown"></a>
                                        <ul class="dropdown-menu dropdown-menu-right">

                                            <!---------------- EDIT ------------------->
                                            @if ((hasPermission("categories.edit", $slugs)))
                                                <li>
                                                    <a href="{{ route('pdt.categories.edit', $item->id) }}" title="Edit">
                                                        <i class="fa fa-pencil-square-o"></i> Edit
                                                    </a>
                                                </li>
                                            @endif

                                            <!---------------- DELETE ------------------->
                                            @if ((hasPermission("categories.delete", $slugs)))
                                                <li>
                                                    <a href="javascript:void(0)" title="Delete" onclick="delete_item('{{ route('pdt.categories.destroy', $item->id) }}')" type="button">
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
                                <td colspan="30" style="font-size: 16px" class="text-center text-danger">
                                    NO RECORDS FOUND!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @include('partials._paginate',['data'=> $categories])
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function cantDeleteAlert() {
            Swal.fire('<p style="font-size:15px;">You can\'t delete this Category. Because there are one or more Products or Child Category has been created in this Category.</p>')
        }
    </script>

    <!-- SHOW MODAL -->
    <script>
        $(document).ready(function () {
            $('#showDetails').on('show.bs.modal', function (event) {
                let button = $(event.relatedTarget)
                let name = button.data('name');
                let title = button.data('title');
                let isMedicine = button.data('is-medicine');
                let showOnMenu = button.data('show-on-menu');
                let isHighlight = button.data('is-highlight');
                let status = button.data('status');
                let image = button.data('image');
                let banner_image = button.data('banner_image');
                let modal = $(this)

                modal.find('.modal-body #name').val(name);
                modal.find('.modal-body #title').val(title);
                modal.find('.modal-body #isMedicine').val(isMedicine);
                modal.find('.modal-body #showOnMenu').val(showOnMenu);
                modal.find('.modal-body #isHighlight').val(isHighlight);
                modal.find('.modal-body #status').val(status);
                modal.find('.modal-body #image').attr('src', "{{ URL::asset('/') }}"+image);
                modal.find('.modal-body #banner_image').attr('src', "{{ URL::asset('/') }}"+banner_image);
            })
        });
    </script>
@endsection
