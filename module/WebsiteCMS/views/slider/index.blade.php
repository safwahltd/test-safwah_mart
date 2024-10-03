@extends('layouts.master')

@section('title')
Slider
@endsection

@section('page-header')
    <i class="fa fa-info-circle"></i> Slider
@stop

@section('content')

    @include('partials._alert_message')

    <div class="widget-box">


        <!-- header -->
        <div class="widget-header">
            <h4 class="widget-title"> @yield('page-header')</h4>
            <span class="widget-toolbar">
                <!--------------- CREATE---------------->
                @if(hasPermission("website-cms.create", $slugs))
                    <a href="{{ route('website.sliders.create') }}" class="">
                        <i class="fa fa-plus"></i> Add <span class="hide-in-sm">New</span>
                    </a>
                @endif
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
                            <table id="dynamic-table" class="table table-striped table-bordered table-hover new-table">
                                <thead>
                                    <tr>
                                        <th width="5%" class="hide-in-sm">Sl</th>
                                        <th width="35%">Image</th>
                                        <th width="10%">Title</th>
                                        <th width="15%">Slug</th>
                                        <th width="15%">Short Description</th>
                                        <th width="10%">Status</th>
                                        <th width="10%" class="text-center" style="width: 120px">Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse ($slider as $item)
                                        <tr>
                                            <td class="hide-in-sm text-center"><span class="span">{{ $loop->iteration }}</span></td>
                                            <td class="text-center">
                                                @if (file_exists($item->image) && $item->image == './default-slider.webp')
                                                    <img src="{{ asset('default-slider.webp') }}" alt="{{ $item->name }}"
                                                        width="300" height="100">
                                                @elseif (file_exists($item->image) && $item->image != './default-slider.webp')
                                                        <img src="{{ asset($item->image) }}" alt="{{ $item->name }}"
                                                            width="300" height="100">
                                                @endif
                                            </td>
                                            <td><span class="span">{{ $item->name }}</span></td>
                                            <td><span class="span">{{ $item->slug }}</span></td>
                                            <td><span class="span">{{ $item->short_description }}</span></td>
                                            <td class="text-center">
                                                <!--------------- EDIT---------------->
                                                @if(hasPermission("website-cms.edit", $slugs))
                                                    <span class="span">
                                                        <x-status status="{{ $item->status }}" id="{{ $item->id }}" table="{{ $table }}" />
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-corner @if (file_exists($item->image)) action-span @endif">
                                                    <!--------------- EDIT---------------->
                                                    @if(hasPermission("website-cms.edit", $slugs))
                                                        <a href="{{ route('website.sliders.edit', $item->id) }}" role="button"
                                                            class="btn btn-xs btn-success bs-tooltip" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endif

                                                    <!--------------- DELETE---------------->
                                                    @if(hasPermission("website-cms.delete", $slugs))
                                                        <button type="button"
                                                            onclick="delete_item(`{{ route('website.sliders.destroy', $item->id) }}`)"
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
