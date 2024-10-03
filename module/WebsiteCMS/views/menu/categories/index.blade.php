@extends('layouts.master')

@section('title', 'Category')


@section('content')


    @include('menu.categories.add-modal')
    
    @include('menu.categories.edit-modal')



    <div class="row">


        <div class="col-12">
            <div class="widget-box">


                <!-- header -->
                <div class="widget-header">
                    <h4 class="widget-title">
                        <i class="fa fa-info-circle"></i> Category
                    </h4>

                    <span class="widget-toolbar">
                        <a href="#add-new" role="button" data-toggle="modal">
                            <i class="ace-icon fa fa-plus"></i>
                            Create New
                        </a>
                    </span>
                </div>


                <div class="widget-body">
                    <div class="widget-main">


                        @include('partials._alert_message')

                        <div class="row p-20">



                            <div class="col-12">

                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered" id="data-table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Sl</th>
                                                <th>Name</th>
                                                <th>Slug</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>

                                            @forelse ($categories as $key => $item)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ $item->name }}</td>
                                                    <td>{{ $item->slug }}</td>
                                                    <td class="text-center">
                                                        <x-status status="{{ $item->status }}" id="{{ $item->id }}" table="{{ $table }}" />
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group btn-corner">
                                                            <a href="#edit-modal" role="button"
                                                                onclick="editItem(`{{ $item }}`)"
                                                                data-toggle="modal" class="btn btn-xs btn-success"
                                                                title="Edit">
                                                                <i class="fas fa-edit"></i>
                                                            </a>

                                                            <button type="button"
                                                                onclick="delete_item(`{{ route('website.menu-categories.destroy', $item->id) }}`)"
                                                                class="btn btn-xs btn-danger" title="Delete">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="30" class="text-center text-danger py-3"
                                                        style="background: #eaf4fa80 !important; font-size: 18px">
                                                        <strong>No records found!</strong>
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



@section('js')


    <!-- Datatable Script -->
    {{-- <script src="{{ asset('admin/assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/jquery.dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('admin/assets/custom_js/custom-datatable.js') }}"></script> --}}

    <script>
        const edit_from = $('#edit_form')
        const category_name = $('.edit-name')
        const category_title = $('.edit-title')
        const category_slug = $('.edit-slug')
        const category_type = $('.edit-type')
        const category_desc = $('.edit-desc')
        const update_route = `{{ route('website.menu-categories.update', ':id') }}`

        function editItem(item) {
            let category = JSON.parse(item)

            edit_from.attr('action', update_route.replace(':id', category.id))
            category_name.val(category.name)
            category_title.val(category.title)
            category_slug.val(category.slug)
            category_desc.val(category.short_description)
            category_type.val(category.type).prop('seleted', 'selected').select2()
        }
    </script>

@stop
