@extends('layouts.master')

@section('title')
    Faqs
@endsection

@section('page-header')
    <i class="fa fa-info-circle"></i> Faqs
@stop

@section('content')

    @include('partials._alert_message')

    <div class="widget-box">


        <!-- header -->
        <div class="widget-header">
            <h4 class="widget-title"> @yield('page-header')</h4>
            <span class="widget-toolbar">
                <a href="{{ route('website.faqs.create') }}" class="">
                    <i class="fa fa-plus"></i> Add <span class="hide-in-sm">New</span>
                </a>
            </span>
        </div>



        <!-- body -->
        <div class="widget-body">
            <div class="widget-main">


                <div class="row">
                    <div class="col-xs-12">

                        <div class="table-responsive" style="border: 1px #cdd9e8 solid;">
                            <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th class="hide-in-sm">Sl</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th class="text-center" style="width: 120px">Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse ($faqs as $item)
                                        <tr>
                                            <td class="hide-in-sm">{{ $loop->iteration }}</td>
                                            <td>{{ $item->title }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td class="text-center">
                                                <x-status status="{{ $item->status }}" id="{{ $item->id }}" table="{{ $table }}" />
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group btn-corner">


                                                    <a href="{{ route('website.faqs.edit', $item->id) }}" role="button"
                                                        class="btn btn-xs btn-success bs-tooltip" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button type="button"
                                                        onclick="delete_item(`{{ route('website.faqs.destroy', $item->id) }}`)"
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
