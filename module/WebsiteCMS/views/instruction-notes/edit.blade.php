@extends('layouts.master')
@section('title', 'Edit Instruction Note')


@section('content')

    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="far fa-edit"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li>Website CMS</li>
            <li>

                <!--------------- INDEX---------------->
                @if(hasPermission("website-cms.index", $slugs))
                     <a class="text-muted" href="{{ route('website.instruction-notes.index') }}">Instruction Note</a>
                @endif

            </li>
            <li class=""><a href="javascript:void(0)">Edit</a></li>
        </ul>
    </div>


    <div class="row">
        <div class="col-12">


            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('website.instruction-notes.update', $instruction_note->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        @include('partials._alert_message')

                        <div class="row ml-0 mr-0" style="display: flex; justify-content:space-between">
                            <div class="col-md-11" style="display: flex; justify-content:space-around">

                                <!-- NAME -->
                                <div class="form-group mb-1" style="width: 35%">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-35" style="text-align: left">Name <sup class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $instruction_note->name) }}" placeholder="Name" autocomplete="off" required>
                                    </div>

                                    @error('name')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>





                                <!-- SLUG -->
                                <div class="form-group mb-1" style="width: 35%">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-35" style="text-align: left">Slug <sup class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="slug" id="slug" value="{{ old('slug', $instruction_note->slug) }}" placeholder="Slug" autocomplete="off" required readonly>
                                    </div>

                                    @error('slug')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>



                                <!-- STATUS & SHOW IN QUICK LINKS -->
                                <div class="form-group" style="margin-top: -5px; width: 20%">
                                    <div class="row">
                                        <label class="col-sm-2 control-label" for="form-field-1-1" style="margin-left: 90px"> Status </label>
                                        <div class="col-sm-2">
                                            <div class="material-switch pt-1 pl-3">
                                                <input type="checkbox" name="status" id="status" @if($instruction_note->status == 1 || old('status') == 'yes') checked @endif />
                                                <label for="status" class="badge-primary"></label>
                                            </div>
                                        </div>

                                    </div>
                                </div>



                            </div>
                        </div>


                        <div class="row" style="display: flex; justify-content:space-between">
                            <div class="col-md-11">

                                <!-- DESCRIPTION -->
                                <div class="form-group mb-1">
                                    <textarea class="form-control tiny-editor" name="description" id="description" cols="30" placeholder="Description ...">{!! old('description', $instruction_note->description) !!}</textarea>

                                    @error('description')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>




                                <!-- ACTION -->
                                <div class="btn-group pull-right mt-2">
                                    <button class="btn btn-sm btn-primary"> <i class="far fa-edit"></i> UPDATE </button>
                                    <a href="{{ route('website.instruction-notes.index') }}" class="btn btn-sm btn-secondary"> <i class="fa fa-list"></i> LIST </a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
