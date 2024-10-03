@extends('layouts.master')

@section('title')
    Page Sections
@endsection

@section('page-header')
    <i class="fa fa-info-circle"></i> Page Sections
@stop

@section('content')

    @include('partials._alert_message')

    <div class="widget-box">


        <!-- header -->
        <div class="widget-header">
            <h4 class="widget-title"> @yield('page-header')</h4>
            <span class="widget-toolbar">
                <a href="{{ route('website.page-sections.create') }}" class="">
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
                                        <th>Page</th>
                                        <th>Title</th>
                                        <th>Short Description</th>
                                        {{-- <th>Show Quantity</th> --}}
                                        <th>Background Image</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center" style="width: 120px">Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse ($pageSections as $item)
                                        <tr>
                                            <td class="hide-in-sm">{{ $loop->iteration }}</td>
                                            <td>{{ $item->page->name }}</td>
                                            <td>{{ $item->title }}</td>
                                            <td>{!! Str::limit($item->short_description, 100, '...') !!}</td>

                                            <td class="text-center">
                                                @if (file_exists($item->background_image))
                                                    <img src="{{ asset($item->background_image) }}" alt="{{ $item->name }}"
                                                        width="100" height="60">
                                                @endif
                                            </td>
                                            {{-- <td>{!! $item->show_quantity !!}</td> --}}
                                            <td class="text-center">
                                                <x-status status="{{ $item->status }}" id="{{ $item->id }}" table="{{ $table }}" />
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-corner">

                                                    @if ($item->page_id == 15)
                                                        <a href="javascript:void(0)" role="button" class="btn btn-xs btn-secondary bs-tooltip" title="Edit" style="cursor: not-allowed;">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button" class="btn btn-xs btn-secondary bs-tooltip" title="Delete" disabled>
                                                                <i class="fa fa-trash"></i>
                                                        </button>
                                                    @else
                                                        <a href="{{ route('website.page-sections.edit', $item->id) }}" role="button"
                                                            class="btn btn-xs btn-success bs-tooltip" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <button type="button"
                                                                onclick="delete_item(`{{ route('website.page-sections.destroy', $item->id) }}`)"
                                                                class="btn btn-xs btn-danger bs-tooltip" title="Delete">
                                                                <i class="fa fa-trash"></i>
                                                        </button>
                                                    @endif
                                                    
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
