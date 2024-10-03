@extends('layouts.master')

@section('title', 'Unit Measure List')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">
            <a class="btn btn-sm btn-success" href="{{ route('unit-measure-export') }}">
                <i class="fa fa-download"></i>
                Export List
            </a>

            <!---------------- CREATE ------------------->
            @if ((hasPermission("unit-measures.create", $slugs)))
                <a class="btn btn-sm btn-primary" href="{{ route('pdt.unit-measures.create') }}">
                    <i class="fa fa-plus-circle"></i>
                    Add New
                </a>
            @endif

        </div>
    </div>

    <form action="{{ route('pdt.unit-measures.index') }}" method="GET">
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

    @include('unit-measure.show-modal')

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" >
                    <thead>
                        <tr class="table-header-bg">
                            <th width="5%">SL</th>
                            <th width="10%">Name</th>
                            <th width="65%">Description</th>
                            <th width="5%" class="text-center">Status</th>
                            <th width="15%" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($unitMeasures as $key => $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->description }}</td>
                                <td class="text-center">
                                    
                                    <!---------------- EDIT STATUS ------------------->
                                    @if ((hasPermission("unit-measures.edit", $slugs)))  
                                        <x-status status="{{ $item->status }}" id="{{ $item->id }}" table="{{ $table }}" />
                                    @endif

                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-corner">
                                        <!-- LOG -->
                                        @include('partials._user-log', ['data' => $item])

                                        <!---------------- VIEW ------------------->
                                        @if ((hasPermission("unit-measures.view", $slugs))) 
                                            <a href="#showDetails"
                                            role="button" class="btn btn-xs btn-black" title="Show" data-toggle="modal"
                                            data-name="{{ $item->name }}"
                                            data-description="{{ $item->description }}"
                                            data-status="{{ $item->status ? 'Active' : 'In-Active' }}"
                                            >
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        @endif

                                        <!---------------- EDIT ------------------->
                                        @if ((hasPermission("unit-measures.edit", $slugs)))  
                                            <a href="{{ route('pdt.unit-measures.edit', $item->id) }}" class="btn btn-xs btn-success" title="Edit">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                        @endif

                                        <!---------------- DELETE ------------------->
                                        @if ((hasPermission("unit-measures.delete", $slugs)))                                        @php $countUnitMeasureInProduct = \Module\Product\Models\Product::where('unit_measure_id', $item->id)->count(); @endphp
                                            @if($countUnitMeasureInProduct < 1)
                                                <button class="btn btn-xs btn-danger" title="Delete" onclick="delete_item('{{ route('pdt.unit-measures.destroy', $item->id) }}')" type="button">
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
                                <td colspan="5" style="font-size: 16px" class="text-center text-danger">
                                    NO RECORDS FOUND!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @include('partials._paginate',['data'=> $unitMeasures])
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        function cantDeleteAlert() {
            Swal.fire('<p style="font-size:15px;">You can\'t delete this Unit Measure. Because there are one or more Product(s) has been created in this Unit Measure.</p>')
        }
    </script>

    <!-- SHOW MODAL -->
    <script>
        $(document).ready(function () {
            $('#showDetails').on('show.bs.modal', function (event) {
                let button = $(event.relatedTarget)
                let name = button.data('name');
                let description = button.data('description');
                let status = button.data('status');
                let modal = $(this)

                modal.find('.modal-body #name').val(name);
                modal.find('.modal-body #description').val(description);
                modal.find('.modal-body #status').val(status);
            })
        });
    </script>
@endsection
