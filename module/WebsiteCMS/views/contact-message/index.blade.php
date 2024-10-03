@extends('layouts.master')

@section('title', 'Contact Messages')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">

        </div>
    </div>

    @include('partials._alert_message')

    <div class="row">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="table-header-bg">
                            <th width="10%" class="text-center">SL</th>
                            <th width="20%">Name</th>
                            <th width="15%">Email</th>
                            <th width="10%">Subject</th>
                            <th width="30%">Message</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($contactMessages ?? [] as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->subject }}</td>
                                <td>
                                    {{ Str::limit($item->message, 130) }}
                                    <a href="{{ route('website.contact-message.show',$item->id) }}" class="text-blue">Continue reading</a>

                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="javascript:void(0)" class="text-danger fas fa-ellipsis-h" type="button" data-toggle="dropdown" style="font-size: 18px"></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a href="{{ route('website.contact-message.show',$item->id) }}" title="Show">
                                                    <i class="fa fa-print"></i> Show
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" title="Delete" onclick="delete_item('{{ route('website.contact-message.destroy', $item->id) }}')" type="button">
                                                    <i class="fa fa-trash"></i> Delete
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @include('partials._paginate', ['data'=> $contactMessages])


            </div>
        </div>
    </div>
@endsection

