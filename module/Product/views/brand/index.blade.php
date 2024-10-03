@extends('layouts.master')

@section('title', 'Brand List')

@section('content')

    <!-- heading -->
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">
            <a class="btn btn-sm btn-success" href="{{ route('brand-export') }}">
                <i class="fa fa-download"></i>
                Export List
            </a>


            <!---------------- CREATE ------------------->
            @if ((hasPermission("brands.create", $slugs)))
                <a class="btn btn-sm btn-primary" href="{{ route('pdt.brands.create') }}">
                    <i class="fa fa-plus-circle"></i>
                    Add New
                </a>
            @endif

            @if (hasAnyPermission(['website-cms.meta-tag'], $slugs))
                <a class="btn btn-sm btn-info" href="{{ route('website.seo-infos.create', 'Brand') }}?previous_url=brand">
                    <i class="fa fa-plus-circle"></i>
                    Seo Info
                </a>
            @endif

        </div>
    </div>


    <!-- filter -->
    <form action="{{ route('pdt.brands.index') }}" method="GET">
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


    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" >
                    <thead>
                    <tr class="table-header-bg">
                        <th width="5%">SL</th>
                        <th width="5%">Logo</th>
                        <th width="25%">Name</th>
                        <th width="30%">Title</th>
                        <th width="15%" class="text-center">Highlight</th>
                        <th width="5%" class="text-center">Status</th>
                        <th width="15%" class="text-center">Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @forelse($brands as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <img src="{{ asset($item->logo) }}" width="60" alt="Logo">
                            </td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->title }}</td>
                            <td class="text-center">
                                @if($item->is_highlight == 'Yes')
                                    <span class="label label-sm label-inverse arrowed-in arrowed-in-right">{{ $item->is_highlight }}</span>
                                @else
                                    <span class="label label-sm label-warning">{{ $item->is_highlight }}</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <x-status status="{{ $item->status }}" id="{{ $item->id }}" table="{{ $table }}" />
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-corner">
                                    <!-- LOG -->
                                    @include('partials._user-log', ['data' => $item])

                                    <!---------------- VIEW ------------------->
                                    @if ((hasPermission("brands.view", $slugs)))
                                        <a href="#showDetails"
                                        role="button" class="btn btn-xs btn-black" title="Show" data-toggle="modal"
                                        data-name="{{ $item->name }}"
                                        data-title="{{ $item->title }}"
                                        data-is-highlight="{{ $item->is_highlight }}"
                                        data-status="{{ $item->status ? 'Active' : 'In-Active' }}"
                                        data-logo="{{ $item->logo }}"
                                        >
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    @endif


                                    <!---------------- EDIT ------------------->
                                    @if ((hasPermission("brands.edit", $slugs)))
                                        <a href="{{ route('pdt.brands.edit', $item->id) }}" class="btn btn-xs btn-success" title="Edit">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>
                                    @endif


                                   <!---------------- DELETE ------------------->
                                    @if ((hasPermission("brands.delete", $slugs)))
                                        @php $countBrandInProducts = \Module\Product\Models\Product::where('brand_id', $item->id)->count(); @endphp
                                        @if($countBrandInProducts < 1)
                                            <button class="btn btn-xs btn-danger" title="Delete" onclick="delete_item('{{ route('pdt.brands.destroy', $item->id) }}')" type="button">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @else
                                            <a class="btn btn-xs btn-light" onclick="cantDeleteAlert()" href="javascript:void(0)">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        @endif
                                    @endif
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

                @include('partials._paginate',['data'=> $brands])
            </div>
        </div>
    </div>


    @include('brand.show-modal')
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
                let button      = $(event.relatedTarget)
                let name        = button.data('name');
                let title       = button.data('title');
                let isHighlight = button.data('is-highlight');
                let status      = button.data('status');
                let logo        = button.data('logo');
                let modal       = $(this)

                modal.find('.modal-body #name').val(name);
                modal.find('.modal-body #title').val(title);
                modal.find('.modal-body #isHighlight').val(isHighlight);
                modal.find('.modal-body #status').val(status);
                modal.find('.modal-body #logo').attr('src', "{{ URL::asset('/') }}"+logo);
            })
        });
    </script>
@endsection
