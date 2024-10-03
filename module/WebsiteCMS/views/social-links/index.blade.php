@extends('layouts.master')

@section('title')
    Social Links
@endsection

@section('page-header')
    <i class="fa fa-info-circle"></i> Social Links
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
                    <a href="{{ route('website.social-links.create') }}" class="">
                        <i class="fa fa-plus"></i> Add <span class="hide-in-sm">New</span>
                    </a>
                @endif
            </span>
        </div>



        <!-- body -->
        <div class="widget-body">
            <div class="widget-main">


                <div class="row">
                    <div class="col-xs-12">

                        <div class="table-responsive" style="border: 1px #cdd9e8 solid;">
                            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="hide-in-sm">Sl</th>
                                        <th>Name</th>
                                        <th>Url</th>
                                        <th class="text-center">Icon</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center" style="width: 120px">Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse ($links as $item)
                                        <tr>
                                            <td class="hide-in-sm">{{ $loop->iteration }}</td>
                                            <td>{{ $item->name }}</td>
                                            <td><a href="{{ $item->url }}" target="_blank">{{ $item->url }}</a></td>
                                            <td class="text-center"><i class="{{ $item->icon }} fa-2x"></i></td>
                                            <td class="text-center">
                                                <!--------------- EDIT---------------->
                                                @if(hasPermission("website-cms.edit", $slugs))
                                                    <x-status :table="$table" :id="$item->id" :status="$item->status" />
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-corner">

                                                    <!--------------- EDIT---------------->
                                                    @if(hasPermission("website-cms.edit", $slugs))
                                                        <a href="{{ route('website.social-links.edit', $item->id) }}"
                                                            role="button" class="btn btn-xs btn-success bs-tooltip"
                                                            title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    @endif

                                                     <!--------------- DELETE---------------->
                                                    @if(hasPermission("website-cms.delete", $slugs))
                                                    <button type="button"
                                                        onclick="delete_item(`{{ route('website.social-links.destroy', $item->id) }}`)"
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
