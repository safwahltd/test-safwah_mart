@extends('layouts/master')

@section('title', 'Popup Notifications List')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">
            <a class="btn btn-sm btn-primary" href="{{ route('settings.popup-notifications.create') }}">
                <i class="fa fa-plus-circle"></i>
                Add New
            </a>
        </div>
    </div>

    @include('partials._alert_message')


    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="" class="table table-bordered table-hover" >
                    <thead>
                        <tr class="table-header-bg">
                            <th width="5%">SL</th>
                            <th width="12%">Image</th>
                            <th width="25%">Title</th>
                            <th width="40%">Description</th>
                            <th width="10%" class="text-center">Status</th>
                            <th width="10%" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($popupNotifications as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">
                                    @if(file_exists($item->image))
                                        <a target="_blank" href="{{ asset($item->image) }}">
                                            <img height="100px" width="100px" src="{{ asset($item->image) }}">
                                        </a>
                                    @endif
                                </td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->description }}</td>
                                <td class="text-center">
                                    @if($item->status == 1)
                                        <span class="badge label-success">Active</span>
                                    @else
                                        <span class="badge label-danger">In-Active</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-corner">

                                        <!-- EDIT -->
                                        <a href="{{ route('settings.popup-notifications.edit', $item->id) }}" class="btn btn-xs btn-success" title="Edit">
                                            <i class="fa fa-pencil-square-o"></i>
                                        </a>

                                        <!-- DELETE -->
                                        <button class="btn btn-xs btn-danger" title="Delete" onclick="delete_item('{{ route('settings.popup-notifications.destroy', $item->id) }}')" type="button">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="font-size: 16px" class="text-center text-danger">
                                    NO RECORDS FOUND!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
