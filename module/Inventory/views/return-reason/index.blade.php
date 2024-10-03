@extends('layouts.master')

@section('title', 'Return Reason List')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">
            <a class="btn btn-sm btn-primary" href="{{ route('inv.return-reasons.create') }}">
                <i class="fa fa-plus-circle"></i>
                Add New
            </a>
        </div>
    </div>

    <form action="{{ route('inv.return-reasons.index') }}" method="GET">
        <div style="display: flex; align-items: center; justify-content:center">
            <div class="input-group mb-2 mr-2 width-50">
                <span class="input-group-addon">
                    Title
                </span>
                <input type="text" class="form-control text-center" name="title" placeholder="Title" autocomplete="off" value="{{ request('title') }}">
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

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover" >
                    <thead>
                        <tr class="table-header-bg">
                            <th width="5%" class="text-center">SL</th>
                            <th width="20%">Title</th>
                            <th width="55%">Description</th>
                            <th width="10%" class="text-center">Serial No</th>
                            <th width="5%" class="text-center">Status</th>
                            <th width="5%" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($returnReasons as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->description }}</td>
                                <td class="text-center">{{ $item->serial_no }}</td>
                                <td class="text-center">
                                    <x-status status="{{ $item->status }}" id="{{ $item->id }}" table="{{ $table }}" />
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="javascript:void(0)" class="text-danger fas fa-ellipsis-h" type="button" data-toggle="dropdown"></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a href="{{ route('inv.return-reasons.edit', $item->id) }}" title="Edit">
                                                    <i class="fa fa-pencil-square-o"></i> Edit
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" title="Delete" onclick="delete_item('{{ route('inv.return-reasons.destroy', $item->id) }}')" type="button">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                            </li>
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

                @include('partials._paginate', ['data'=> $returnReasons])
            </div>
        </div>
    </div>
@endsection
