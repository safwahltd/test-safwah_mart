@extends('layouts.master')

@section('title', 'Instruction Note List')
@section('css')
    <style>
        .button-disabled{
            color: gray !important;
            cursor: not-allowed
        }
    </style>
@endsection
@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">
            <!--------------- CREATE---------------->
            {{-- @if(hasPermission("website-cms.create", $slugs))
                <a class="btn btn-sm btn-primary" href="{{ route('website.instruction-notes.create') }}">
                    <i class="fa fa-plus-circle"></i>
                    Add New
                </a>
            @endif --}}
        </div>
    </div>

    <form action="{{ route('website.instruction-notes.index') }}" method="GET">


        <div style="display: flex; align-items: center; justify-content:center">

            <div class="input-group mb-2 mr-2 width-50">
                <span class="input-group-addon">
                    Name
                </span>
                <input type="text" class="form-control text-center" name="name" placeholder="Name" autocomplete="off" value="{{ request('name') }}">
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
                            <th width="5%" class="text-center">SL</th>
                            <th width="20%">Name</th>
                            <th width="40%">Description</th>
                            <th width="10%" class="text-center">Status</th>
                            <th width="10%" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($instruction_notes ?? [] as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>
                                    {!! Str::limit($item->description, 200) !!}
                                    <a href="{{ route('website.instruction-notes.show',$item->id) }}" class="text-blue">Continue reading</a>
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

                                            <li>
                                                <a href="{{ route('website.instruction-notes.show',$item->id) }}" title="Show">
                                                    <i class="fa fa-print"></i> Show
                                                </a>
                                            </li>

                                            <!--------------- EDIT---------------->
                                            @if(hasPermission("website-cms.edit", $slugs))
                                                <li>
                                                    <a href="{{ route('website.instruction-notes.edit', $item->id) }}" title="Edit">
                                                        <i class="fa fa-pencil-square-o"></i> Edit
                                                    </a>
                                                </li>
                                            @endif

                                            <!--------------- DELETE---------------->
                                            @if(hasPermission("website-cms.delete", $slugs))
                                                <li>
                                                    <a href="javascript:void(0)" title="Delete" type="button" class="button-disabled">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </a>
                                                    {{-- <a href="javascript:void(0)" title="Delete" onclick="delete_item('{{ route('website.instruction-notes.destroy', $item->id) }}')" type="button">
                                                        <i class="fa fa-trash"></i> Delete
                                                    </a> --}}
                                                </li>
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

                @include('partials._paginate', ['data'=> $instruction_notes])
            </div>
        </div>
    </div>
@endsection
