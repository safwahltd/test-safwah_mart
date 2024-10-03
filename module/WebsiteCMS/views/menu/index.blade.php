@extends('layouts.master')

@section('title')
    Menu
@endsection

@section('page-header')
    <i class="fa fa-info-circle"></i> Menu
@stop

@section('content')

    @include('partials._alert_message')

    <div class="widget-box">


        <!-- header -->
        <div class="widget-header">
            <h4 class="widget-title"> @yield('page-header')</h4>
            <span class="widget-toolbar">
                <a href="{{ route('website.widget-menus.create') }}" class="">
                    <i class="fa fa-plus"></i> Add <span class="hide-in-sm">New</span>
                </a>
            </span>
        </div>



        <!-- body -->
        <div class="widget-body">
            <div class="widget-main">



                <!-- Searching -->
                {{-- @include('admin/users/filter') --}}



                <div class="row">
                    <div class="col-xs-12">

                        <div class="table-responsive" style="border: 1px #cdd9e8 solid;">
                            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="hide-in-sm">Sl</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Slug</th>
                                        <th>Order</th>
                                        <th>Position</th>
                                        <th>Image</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center" style="width: 120px">Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse ($menus as $item)
                                        <tr>
                                            <td class="hide-in-sm">{{ $loop->iteration }}</td>

                                            <td>{{ $item->name }}</td>
                                            <td>{{ optional($item->menu_category)->name }}</td>
                                            <td>{{ $item->slug }}</td>
                                            <td>{{ $item->order_no }}</td>
                                            <td>{{ $item->position }}</td>
                                            <td>
                                                @if (file_exists($item->image))
                                                    <img src="{{ asset($item->image) }}" alt="{{ $item->name }}"
                                                        width="100" height="100" />
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <x-status status="{{ $item->status }}" id="{{ $item->id }}" table="{{ $table }}" />
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-corner">


                                                    <a href="{{ route('website.widget-menus.edit', $item->id) }}"
                                                        role="button" class="btn btn-xs btn-success bs-tooltip"
                                                        title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button"
                                                        onclick="delete_item(`{{ route('website.widget-menus.destroy', $item->id) }}`)"
                                                        class="btn btn-xs btn-danger bs-tooltip" title="Delete">
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

    @endsection
