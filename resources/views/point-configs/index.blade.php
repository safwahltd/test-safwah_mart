@extends('layouts.master')

@section('title', 'Point Configs')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fal fa-cog"></i> @yield('title')</h4>
        <div class="btn-group">
            <a class="btn btn-sm btn-theme" href="{{ route('point-configs.create') }}">
                <i class="far fa-plus-circle"></i>
                ADD NEW
            </a>
        </div>
    </div>

    @include('partials._alert_message')

    <div class="row">
        <div class="col-sm-12">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead style="border-bottom: 3px solid #346cb0 !important">
                        <tr style="background: #e1ecff !important; color:black !important;">
                            <th width="5%" class="text-center">SL</th>
                            <th width="30%">Title</th>
                            <th width="20%">Min Purchase Amount</th>
                            <th width="20%">Max Purchase Amount</th>
                            <th width="5%" class="text-center">Point</th>
                            <th width="5%" class="text-center">Status</th>
                            <th width="15%" class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($pointConfigs as $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td>{{ $item->title }}</td>
                                <td>{{ $item->min_purchase_amount }}</td>
                                <td>{{ $item->max_purchase_amount }}</td>
                                <td class="text-center">
                                    <span class="label label-yellow" style="border-radius: 40%; font-weight: 500">
                                        {{ $item->point }}
                                    </span>
                                </td> 
                                <td class="text-center">
                                    <x-status status="{{ $item->status }}" id="{{ $item->id }}" table="{{ $table }}" />
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        @include('partials._user-log', ['data' => $item, 'icon_size' => 'mini'])
                                        <a href="{{ route('point-configs.edit', $item->id) }}" class="btn btn-mini btn-yellow" title="Edit">
                                            <i class="far fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" class="btn btn-mini btn-danger" title="Delete" onclick="delete_item('{{ route('point-configs.destroy', $item->id) }}')" type="button">
                                            <i class="far fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" style="font-size: 16px" class="text-center text-danger">
                                    NO RECORDS FOUND!
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                @include('partials._paginate', ['data'=> $pointConfigs])
            </div>
        </div>
    </div>
@endsection
