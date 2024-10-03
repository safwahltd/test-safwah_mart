@extends('layouts.master')
@section('title', 'Create Publisher')

@section('page-header')
    Add New Publisher
@stop

@section('content')
    <div class="row">
        <div class="col-12">

            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <h4 class="pl-2"><i class="fa fa-plus"></i> @yield('page-header')</h4>

                <ul class="breadcrumb mb-1">
                    <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
                    <li>Product Config</li>
                    <li><a class="text-muted" href="{{ route('pdt.publishers.index') }}">Publisher</a></li>
                    <li class=""><a href="javascript:void(0)">Create</a></li>
                </ul>
            </div>

            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('pdt.publishers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('partials._alert_message')

                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">

                                <!-- NAME -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Name <sup class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="name" id="name"
                                        value="{{ old('name') }}" placeholder="Publisher Name" required>
                                        </div>

                                    @error('name')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>


                                    <!-- SLUG -->
                                    <div class="form-group">
                                        <div class="input-group width-100">
                                            <span class="input-group-addon width-30" style="text-align: left">Slug <sup class="text-danger">*</sup></span>
                                            <input type="text" class="form-control" name="slug" id="slug"
                                            value="{{ old('slug') }}" placeholder="Publisher Slug" required>
                                            </div>
                                        @error('slug')
                                            <span class="text-danger">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                <!-- title -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Title <sup class="text-danger"></sup></span>
                                        <input name="title" id="title" class="form-control" placeholder="Publisher title" value="{{ old('title') }}">
                                    </div>

                                    @error('title')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- phone -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">phone <sup class="text-danger"></sup></span>
                                        <input name="phone" id="phone" class="form-control" placeholder="Publisher phone" value="{{ old('phone') }}">
                                    </div>

                                    @error('phone')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- email -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">email <sup class="text-danger"></sup></span>
                                        <input name="email" id="email" class="form-control" placeholder="Publisher email" value="{{ old('email') }}">
                                    </div>

                                    @error('email')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- address -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">address <sup class="text-danger"></sup></span>
                                        <input name="address" id="address" class="form-control" placeholder="Publisher address" value="{{ old('address') }}">
                                    </div>

                                    @error('address')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Description <sup class="text-danger"></sup></span>
                                        <textarea name="description" id="description" class="form-control" placeholder="Publisher description">{{ old('description') }}</textarea>
                                    </div>

                                    @error('description')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- logo -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">logo <sup class="text-danger"></sup></span>
                                        <input type="file" class="form-control" name="logo">
                                    </div>
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="background-color: transparent !important; border:none !important;"></span>
                                        <small style="margin-left: 13px;"><b>Logo size must be 250x360.</b></small>
                                    </div>

                                    @error('logo')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- Cover Photo -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Cover Photo <sup class="text-danger"></sup></span>
                                        <input type="file" class="form-control" name="cover_photo">
                                    </div>
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="background-color: transparent !important; border:none !important;"></span>
                                        <small style="margin-left: 13px;"><b>Cover Photo size must be 250x360.</b></small>
                                    </div>
                                    @error('cover_photo')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>


                                <!-- ACTION -->
                                <div class="btn-group pull-right">
                                    <button class="btn btn-sm btn-primary"> <i class="fa fa-save"></i> Save </button>
                                    <a href="{{ route('pdt.publishers.index') }}" class="btn btn-sm btn-secondary"> <i class="fa fa-list"></i> List </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
