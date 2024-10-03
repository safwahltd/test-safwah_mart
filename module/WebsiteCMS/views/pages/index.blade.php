@extends('layouts.master')

@section('title', 'Page List')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">
            <!--------------- CREATE---------------->
            @if(hasPermission("website-cms.create", $slugs))
                <a class="btn btn-sm btn-primary" href="{{ route('website.pages.create') }}">
                    <i class="fa fa-plus-circle"></i>
                    Add New
                </a>
            @endif
        </div>
    </div>

    <form action="{{ route('website.pages.index') }}" method="GET">


        <div style="display: flex; align-items: center; justify-content:center">

            <div class="input-group mb-2 mr-2 width-50">
                <span class="input-group-addon">
                    Page Name
                </span>
                <input type="text" class="form-control text-center" name="name" placeholder="Page Name" autocomplete="off" value="{{ request('name') }}">
            </div>

            <div class="text-right">
                <div class="btn-group mb-2">
                    <button type="submit" class="btn btn-sm btn-black" style="height: 33px; width: 35px; border-top-left-radius: 2px; border-bottom-left-radius: 2px"><i class="fa fa-search"></i></button>
                    <button type="button" class="btn btn-sm btn-dark" onclick="location.href='{{ request()->url() }}'" style="height: 33px; width: 35px; border-top-right-radius: 2px; border-bottom-right-radius: 2px"><i class="fa fa-refresh"></i></button>
                </div>
            </div>

        </div>

    </form>

    @include('partials._alert_message')

    @include('time-slots.show-modal')

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" >
                    <thead>
                        <tr class="table-header-bg">
                            <th width="2%" class="text-center">SL</th>
                            <th width="30%">Banner</th>
                            <th width="20%">Page Name</th>
                            <th width="20%">SEO Title</th>
                            <th width="8%" class="text-center">Serial No</th>
                            <th width="10%" class="text-center">Quick Links</th>
                            <th width="5%" class="text-center">Status</th>
                            <th width="5%" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($pages as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>
                                    <img src="{{ file_exists($item->banner_image) ? asset($item->banner_image) : asset('default.svg') }}" width="100%" height="80px" alt="">
                                </td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->seo_title }}</td>
                                <td class="text-center">{{ $item->serial_no }}</td>
                                <td class="text-center">
                                    <span class="label {{ $item->show_in_quick_links == 1 ? 'label-yellow' : 'label-danger' }}">
                                        {{ $item->show_in_quick_links == 1 ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <!--------------- EDIT---------------->
                                    @if(hasPermission("website-cms.edit", $slugs))
                                        <x-status status="{{ $item->status }}" id="{{ $item->id }}" table="{{ $table }}" />
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="javascript:void(0)" class="text-danger fas fa-ellipsis-h" type="button" data-toggle="dropdown"></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            
                                            <!--------------- EDIT---------------->
                                            @if(hasPermission("website-cms.edit", $slugs))
                                                <li>
                                                    <a href="{{ route('website.pages.edit', $item->id) }}" title="Edit">
                                                        <i class="fa fa-pencil-square-o"></i> Edit
                                                    </a>
                                                </li>
                                            @endif

                                            <!--------------- DELETE---------------->
                                            @if(hasPermission("website-cms.delete", $slugs))
                                                @if (!in_array($item->id, $mainPages))
                                                    <li>
                                                        <a href="javascript:void(0)" title="Delete" onclick="delete_item('{{ route('website.pages.destroy', $item->id) }}')" type="button">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </a>
                                                    </li>
                                                @endif
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

                @include('partials._paginate', ['data'=> $pages])
            </div>
        </div>
    </div>
@endsection
