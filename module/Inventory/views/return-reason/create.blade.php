@extends('layouts.master')
@section('title', 'Create Return Reason')


@section('content')

    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-plus"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li>Order</li>
            <li><a class="text-muted" href="{{ route('inv.return-reasons.index') }}">Return Reason</a></li>
            <li class=""><a href="javascript:void(0)">Create</a></li>
        </ul>
    </div>


    <div class="row">
        <div class="col-12">

            


            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('inv.return-reasons.store') }}" method="POST">
                        @csrf
                        @include('partials._alert_message')

                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">

                                <!-- TITLE -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Title <sup class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="title" value="{{ old('title') }}" placeholder="Title" autocomplete="off" required>
                                    </div>

                                    @error('title')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>



                                

                                <!-- DESCRIPTION -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Description</span>
                                        <textarea class="form-control" name="description" cols="30" rows="3" placeholder="Description">{{ old('description') }}</textarea>
                                    </div>

                                    @error('description')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>





                                <!-- SERIAL NO -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Serial No <sup class="text-danger">*</sup></span>
                                        <input type="number" class="form-control" name="serial_no" value="{{ old('serial_no', $next_serial_no) }}" placeholder="Serial No" autocomplete="off" required>
                                    </div>

                                    @error('serial_no')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>





                                <!-- STATUS -->
                                <div class="form-group" style="margin-top: -5px">
                                    <label class="col-sm-2 col-xs-4 control-label" for="form-field-1-1" style="margin-left:-12px"> Status </label>
                                    <div class="col-sm-4 col-xs-8">
                                        <div class="material-switch pt-1 pl-3">
                                            <input type="checkbox" name="status" id="status" checked />
                                            <label for="status" class="badge-primary"></label>
                                        </div>
                                    </div>
                                </div>




                                <!-- ACTION -->
                                <div class="btn-group pull-right">
                                    <button class="btn btn-sm btn-primary"> <i class="fa fa-save"></i> Save </button>
                                    <a href="{{ route('inv.return-reasons.index') }}" class="btn btn-sm btn-secondary"> <i class="fa fa-list"></i> List </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
