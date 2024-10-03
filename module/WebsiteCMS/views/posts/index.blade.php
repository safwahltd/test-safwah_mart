@extends('layouts.master')

@section('title')
    Posts
@endsection

@section('page-header')
    <i class="fa fa-info-circle"></i> Posts
@stop

@section('content')

    @include('partials._alert_message')

    <div class="widget-box">


        <!-- header -->
        <div class="widget-header">
            <h4 class="widget-title"> @yield('page-header')</h4>
            <span class="widget-toolbar">
                <a href="{{ route('website.posts.create') }}" class="">
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
                                        <th>Title</th>
                                        <th>Image</th>
                                        <th>Categories</th>
                                        <th>Short Desc</th>
                                        <th>Content</th>
                                        <th>Format</th>
                                        <th class="text-center">Status</th>
                                        <th class="text-center" style="width: 120px">Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse ($posts as $post)
                                        <tr>
                                            <td class="hide-in-sm">{{ $loop->iteration }}</td>
                                            <td>{{ $post->title }}</td>
                                            <td class="text-center">
                                                {!! image($post->feature_image,100,100) !!}
                                            </td>
                                            <td>
                                                @forelse ($post->post_categories as $item)
                                                    <span
                                                        class="badge badge-info">{{ $item->name }}</span>
                                                    @empty
                                                    <span class=""></span>
                                                @endforelse
                                            </td>
                                            <td>{!! $post->short_desc !!}</td>
                                            <td>{!! Str::limit($post->content, 100, '...') !!}</td>
                                            <td>{{ $post->format_type }}</td>
                                            <td class="text-center">
                                                <x-status-update :table="$table" :id="$item->id" :status="$item->status" />
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-corner">

                                                    <a href="{{ route('website.posts.edit', $post->id) }}" role="button"
                                                        class="btn btn-xs btn-success bs-tooltip" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button"
                                                        onclick="delete_item(`{{ route('website.posts.destroy', $post->id) }}`)"
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
