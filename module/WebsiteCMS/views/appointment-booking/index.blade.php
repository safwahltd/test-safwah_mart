@extends('layouts.master')

@section('title', 'Appointment Booking')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">
            @if (hasAnyPermission(['website-cms.meta-tag'], $slugs))
                <a class="btn btn-sm btn-info" href="{{ route('website.seo-infos.create', 'Appointment booking') }}?previous_url=appointment-booking">
                    <i class="fa fa-plus-circle"></i>
                    Seo Info
                </a>
            @endif
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
                            <th width="10%">Mobile</th>
                            <th width="30%">Description</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($appointmentBooking ?? [] as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>
                                    {{ Str::limit($item->description, 130) }}
                                    <a href="{{ route('website.appointment-booking.show',$item->id) }}" class="text-blue">Continue reading</a>

                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="javascript:void(0)" class="text-danger fas fa-ellipsis-h" type="button" data-toggle="dropdown" style="font-size: 18px"></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a href="{{ route('website.appointment-booking.show',$item->id) }}" title="Show">
                                                    <i class="fa fa-print"></i> Show
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" title="Delete" onclick="delete_item('{{ route('website.appointment-booking.destroy', $item->id) }}')" type="button">
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
                @include('partials._paginate', ['data'=> $appointmentBooking])


            </div>
        </div>
    </div>
@endsection

