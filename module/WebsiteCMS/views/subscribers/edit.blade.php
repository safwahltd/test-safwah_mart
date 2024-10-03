@extends('layouts.master')
@section('title', 'Subscribers Slot')

@section('page-header')
    Edit New Subscribers
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <h4 class="pl-2"><i class="fa fa-plus"></i> @yield('page-header')</h4>

                <ul class="breadcrumb mb-1">
                    <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
                    <li>Inventory</li>
                    <li><a class="text-muted" href="{{ route('website.subscribers.index') }}">Subscribers</a></li>
                    <li class=""><a href="javascript:void(0)">Create</a></li>
                </ul>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('website.subscribers.update', $subscribe->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('partials._alert_message')

                        {{-- Subscribers email --}}
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1-1"> Subscribers Email<span class="label-required">*</span> </label>
                            <div class="col-sm-4 @error('email') has-error @enderror">
                                <input type="text" class="form-control" name="email" id="email"
                                    value="{{ old('email', $subscribe->email) }}" placeholder="Subscribers email" required>
                                @error('email')
                                <span class="text-danger">
                                        {{ $message }}
                                    </span>
                                @enderror
                            </div>
                        </div>

                        {{-- Status --}}
                        <div class="form-group" style="margin-top: -5px">
                            <label class="col-sm-2 col-xs-4 control-label" for="form-field-1-1" style="margin-left:-12px"> Status </label>
                            <div class="col-sm-4 col-xs-8">
                                <label style="margin-top: 7px">
                                    <input name="status" class="ace ace-switch ace-switch-6" type="checkbox" @if (!empty($subscribe->status)) checked @endif>
                                    <span class="lbl"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-12 text-right">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-success"> <i class="fa fa-save"></i> Save </button>
                                    <a href="{{ route('website.subscribers.index') }}" class="btn btn-sm btn-info"> <i class="fa fa-list"></i> List </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
