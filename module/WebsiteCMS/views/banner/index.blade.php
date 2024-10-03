@extends('layouts.master')

@section('title')
    Banner
@endsection

@section('page-header')
    <i class="fa fa-info-circle"></i> Banner
@stop

@section('content')

    @include('partials._alert_message')

    <div class="widget-box">


        <!-- header -->
        <div class="widget-header">
            <h4 class="widget-title"> @yield('page-header')</h4>
        </div>



        <!-- body -->
        <div class="widget-body">
            <div class="widget-main">



                <div class="row">
                    <div class="col-xs-12">

                        <div class="table-responsive" style="border: 1px #cdd9e8 solid;">
                            <table id="dynamic-table" class="table table-striped table-bordered table-hover new-table">
                                <thead>
                                    <tr>
                                        <th width="10%" class="hide-in-sm text-center">Sl</th>
                                        <th width="35%">Image</th>
                                        <th width="20%">Name</th>
                                        <th width="20%">Url</th>
                                        <th width="5%">Status</th>
                                        <th width="10%" class="text-center" style="width: 120px">Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse ($banner as $item)
                                        <tr>
                                            <td class="hide-in-sm text-center"><span class="span">{{ $loop->iteration }}</span></td>
                                            <td class="text-center">
                                                @if (file_exists($item->image))
                                                    <img src="{{ asset($item->image) }}" alt="{{ $item->name }}" width="300" height="100">
                                                @endif
                                            </td>
                                            <td><span class="span">{{ $item->name }}</span></td>
                                            <td><span class="span">{{ $item->url }}</span></td>
                                            <td class="text-center">
                                                <span class="span">
                                                    @if (hasPermission('website-cms.edit', $slugs))
                                                        <x-status status="{{ $item->status }}" id="{{ $item->id }}" table="{{ $table }}" />
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="text-center">

                                                <!---------------  EDIT---------------->
                                                @if (hasPermission('website-cms.edit', $slugs))
                                                    <div
                                                        class="btn-group btn-corner @if (file_exists($item->image)) action-span @endif">

                                                        <a href="{{ route('website.banners.edit', $item->id) }}"
                                                            role="button" class="btn btn-xs btn-success bs-tooltip"
                                                            title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    </div>
                                                @endif

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
