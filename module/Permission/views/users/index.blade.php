@extends('layouts.master')

@section('title',' User')


@section('css')

@stop


@section('content')

    <div class="page-header">
        @if (hasPermission("users.view", $slugs))
            <a class="btn btn-xs btn-info" href="{{ route('users.create') }}" style="float: right; margin: 0 2px;"> <i class="fa fa-plus"></i> Add User </a>
        @endif
        <h1>
            <i class="fa fa-info-circle green"></i> User List
        </h1>
        @if (hasPermission("permission.users.create", $slugs))
            <a class="btn btn-sm btn-primary" href="{{ route('users.create') }}">
                <i class="fa fa-plus-circle"></i>
                Add New
            </a>
        @endif

    </div>

    @include('partials._alert_message')

    <div class="row">
        <div class="col-xs-12">

            <div class="table-responsive" style="border: 1px #cdd9e8 solid;">
                <table id="data-table" class="table table-striped table-bordered table-hover" >
                    <thead>
                        <tr>
                            <th>SL</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>User Type</th>
                            <th>Status</th>
                            <th style="text-align: center;">Permission</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $key => $user)
                        @php
                            if($user->id == 1 && auth()->user()->id != 1){
                                continue;
                            }
                        @endphp
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->type }}</td>
                                <td class="text-center">
                                    <x-status status="{{ $user->status }}" id="{{ $user->id }}" table="users" />
                                </td>
                                <td style="text-align: center;">
                                    @if($user->type == "Admin")
                                        @if($user->permissions == '[]')
                                            @if (hasPermission("permission.accesses.create", $slugs))
                                                <a class="btn btn-sm btn-primary" href="{{ route('permission-access.create'). '?user_id='. $user->id }}">
                                                    <i class="fa fa-plus-circle"></i>
                                                    Create
                                                </a> 
                                            @endif
                                        @else  
                                            @if(hasPermission("permission.accesses.edit", $slugs))
                                                <a class="btn btn-sm btn-warning pl-2 pr-1" href="{{ route('permission-access.edit', $user->id) }}">
                                                    <i class="fa fa-pencil"></i>
                                                    Edit
                                                </a>      
                                            @endif     
                                         @endif
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-corner">

                                        @if (hasPermission("permission.users.edit", $slugs))
                                            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-success" title="Edit">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                        @endif

                                        @if (hasPermission("permission.users.delete", $slugs))
                                            <button class="btn btn-sm btn-danger" title="Delete" onclick="delete_item('{{ route('users.destroy', $user->id) }}')" type="button">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@section('js')

    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.dataTables.bootstrap.min.js') }}"></script>

    <script src="{{ asset('assets/js/ace-elements.min.js') }}"></script>
    <script src="{{ asset('assets/js/ace.min.js') }}"></script>

    {{-- <script src="{{ asset('assets/custom_js/custom-datatable.js') }}"></script> --}}
    <script src="{{ asset('assets/custom_js/confirm_delete_dialog.js') }}"></script>


    <!-- inline scripts related to this page -->
    <script type="text/javascript">
        function delete_check(id)
        {
            Swal.fire({
                title: 'Are you sure ?',
                html: "<b>You want to delete permanently !</b>",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                width:400,
            }).then((result) =>{
                if(result.value){
                    $('#deleteCheck_'+id).submit();
                }
            })
        }
    </script>

@stop