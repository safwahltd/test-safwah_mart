@extends('layouts.master')

@section('title', 'Corporate Order')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">
            @if (hasAnyPermission(['website-cms.meta-tag'], $slugs))
                <a class="btn btn-sm btn-info" href="{{ route('website.seo-infos.create', 'Corporate Order') }}?previous_url=corporate-order">
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
                            <th width="5%" class="text-center">SL</th>
                            <th width="10%">Name</th>
                            <th width="10%">Institute</th>
                            <th width="10%">Email</th>
                            <th width="10%">Mobile</th>
                            <th width="10%">Address</th>
                            <th width="30%">Description</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($corporateOrders ?? [] as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->institution_name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->phone }}</td>
                                <td>{{ $item->address }}</td>
                                <td>
                                    {{ Str::limit($item->description, 130) }}
                                    <a href="{{ route('website.corporate-order.show',$item->id) }}" class="text-blue">Continue reading</a>

                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="javascript:void(0)" class="text-danger fas fa-ellipsis-h" type="button" data-toggle="dropdown" style="font-size: 18px"></a>
                                        <ul class="dropdown-menu dropdown-menu-right">
                                            <li>
                                                <a href="{{ route('website.corporate-order.show',$item->id) }}" title="Show">
                                                    <i class="fa fa-print"></i> Show
                                                </a>
                                            </li>
                                            <li>
                                                <a href="javascript:void(0)" title="Delete" onclick="delete_item('{{ route('website.corporate-order.destroy', $item->id) }}')" type="button">
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
                @include('partials._paginate', ['data'=> $corporateOrders])


            </div>
        </div>
    </div>
@endsection

