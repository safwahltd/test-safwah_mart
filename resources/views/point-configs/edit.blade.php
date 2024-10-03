@extends('layouts.master')
@section('title', 'Edit Point Config')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <h4 class="pl-2"><i class="far fa-edit"></i> @yield('title')</h4>
                <ul class="breadcrumb mb-1">
                    <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
                    <li>Config</li>
                    <li><a class="text-muted" href="{{ route('point-configs.index') }}">Point</a></li>
                    <li class=""><a href="javascript:void(0)">Edit</a></li>
                </ul>
            </div>
            <form class="form-horizontal mt-2" action="{{ route('point-configs.update', $pointConfig->id) }}" method="POST">
                @csrf
                @method('PUT')
                @include('partials._alert_message')

                <div class="row">
                    <div class="col-md-6 col-md-offset-3">



                        <!-- TITLE -->
                        <div class="form-group mb-1">
                            <div class="input-group width-100">
                                <span class="input-group-addon width-35" style="text-align: left">Title</span>
                                <input type="text" class="form-control" name="title" value="{{ old('title', $pointConfig->title) }}" placeholder="Title" autocomplete="off">
                            </div>

                            @error('title')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>



                        <!-- MIN PURCHASE AMOUNT -->
                        <div class="form-group mb-1">
                            <div class="input-group width-100">
                                <span class="input-group-addon width-35" style="text-align: left">Min Purchase Amount <sup class="text-danger">*</sup></span>
                                <input type="text" class="form-control" name="min_purchase_amount" value="{{ old('min_purchase_amount', $pointConfig->min_purchase_amount) }}" placeholder="Min Purchase Amount" autocomplete="off" required>
                            </div>

                            @error('min_purchase_amount')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>



                        <!-- MAX PURCHASE AMOUNT -->
                        <div class="form-group mb-1">
                            <div class="input-group width-100">
                                <span class="input-group-addon width-35" style="text-align: left">Max Purchase Amount <sup class="text-danger">*</sup></span>
                                <input type="text" class="form-control" name="max_purchase_amount" value="{{ old('max_purchase_amount', $pointConfig->max_purchase_amount) }}" placeholder="Max Purchase Amount" autocomplete="off" required>
                            </div>

                            @error('max_purchase_amount')
                                <span class="text-danger">
                                    {{ $message }}
                                </span>
                            @enderror
                        </div>



                        <!-- POINT -->
                        <div class="form-group mb-1">
                            <div class="input-group width-100">
                                <span class="input-group-addon width-35" style="text-align: left">Point <sup class="text-danger">*</sup></span>
                                <input type="text" class="form-control" name="point" value="{{ old('point', $pointConfig->point) }}" placeholder="Point" autocomplete="off" required>
                            </div>

                            @error('point')
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
                                    <input type="checkbox" name="status" id="status" {{ $pointConfig->status == 1 || old('status') == true ? 'checked' : '' }} />
                                    <label for="status" class="badge-primary"></label>
                                </div>
                            </div>
                        </div>



                        <!-- ACTION -->
                        <div class="btn-group pull-right">
                            <button class="btn btn-sm btn-theme"> <i class="far fa-check-circle"></i> UPDATE </button>
                            <a href="{{ route('point-configs.index') }}" class="btn btn-sm btn-secondary" style="color: #000000 !important"> <i class="far fa-list"></i> LIST </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
