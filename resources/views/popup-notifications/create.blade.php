@extends('layouts.master')

@section('title', 'Popup Notification Create')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fad fa-plus-circle"></i> @yield('title')</h4>
    </div>



    <div class="widget-body">
        <div class="widget-main">
            <div class="row">
                <div class="col-md-12">
                    @include('partials._alert_message')
                </div>
                <div class="col-md-12">

                    <div id="company-setting" class="tab-pane active" style="margin-top: -36px !important;">

                        <form class="form-horizontal mt-2" action="{{ route('settings.popup-notifications.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-sm-6">

                                    <!-- TITLE -->
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-35" style="text-align: left">
                                            Title
                                        </span>
                                        <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" tabindex="1" placeholder="Popup title">
                                    </div>







                                    <!-- DESCRIPTION -->
                                    <div class="input-group width-100 mt-2">
                                        <label>Description</label>
                                        <textarea class="form-control" name="description" id="description" rows="10" tabindex="12" placeholder="Notification details">{{ old('description') }}</textarea>
                                    </div>




                                    <!-- IMAGE -->
                                    <div class="input-group mt-2 width-100 @error('image') has-error @enderror">
                                        <span class="input-group-addon width-35" style="text-align: left">
                                            Image<span class="label-required">*</span>
                                        </span>
                                        <input type="file" class="form-control" name="image" id="image" tabindex="9" required>
                                    </div>
                                    <span class="text-danger">
                                        @error('image'){{ $message }}@enderror
                                    </span>
                                </div>
                            </div>


                            <div class="row">
                                <div class="col-md-6 mt-2 text-right">
                                    <div class="btn-group">
                                        <a class="btn btn-sm" href="{{ route('settings.popup-notifications.index') }}"><i class="fa fa-backward"></i> Back</a>
                                        <button class="btn btn-sm btn-primary"> <i class="fa fa-save"></i> Save Notification</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


