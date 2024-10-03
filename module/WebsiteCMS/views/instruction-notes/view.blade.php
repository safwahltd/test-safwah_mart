@extends('layouts.master')
@section('title', 'View Instruction Note')
@section('css')
    <style>
        .modal-target {
            width: 300px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
            }

            .modal-target:hover {opacity: 0.7;}

            /* The Modal (background) */
            .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 99; /* Sit on top */
            padding-top: 60px; /* Location of the box */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.8); /* Black w/ opacity */
            }

            /* Modal Content (image) */
            .modal-content {
                margin-left: auto;
                display: block;
                margin-right: 26%;
                width: 35%;
                height: 88vh;
                opacity: 1 !important;
                max-width: 1200px;
            }

            /* Caption of Modal Image */
            .modal-caption {
            margin: auto;
            display: block;
            width: 80%;
            max-width: 1200px;
            text-align: center;
            color: white;
            font-weight: 700;
            font-size: 1em;
            margin-top: 32px;
            }

            /* Add Animation */
            .modal-content, .modal-caption {
            -webkit-animation-name: zoom;
            -webkit-animation-duration: 0.6s;
            animation-name: zoom;
            animation-duration: 0.6s;
            }

            @-webkit-keyframes zoom {
            from {-webkit-atransform:scale(0)}
            to {-webkit-transform:scale(1)}
            }

            @keyframes zoom {
            from {transform:scale(0)}
            to {transform:scale(1)}
            }

            /* The Close Button */
            .modal-close {
            position: absolute;
            top: 45px;
            right: 35px;
            color: #f1f1f1;
            font-size: 40px;
            font-weight: bold;
            transition: 0.3s;
            }

            .modal-close:hover,
            .modal-close:focus {
            color: #bbb;
            text-decoration: none;
            cursor: pointer;
            }

    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <h4 class="pl-2"><i class="fa fa-plus"></i> @yield('title')</h4>

                <ul class="breadcrumb mb-1">
                    <li><a href="{{ route('home') }}"><i class="ace-icon fa fa-home"></i></a></li>
                    <li>Website-CMS</li>
                    <li><a class="text-muted" href="{{ route('website.instruction-notes.index') }}">Instruction Note</a></li>
                    <li class=""><a href="javascript:void(0)">View</a></li>
                </ul>
            </div>


            <div class="widget-body">
                <div class="widget-main">
                    <div class="row">
                        <div class="col-md-8 col-md-offset-2">


                            <!-- NAME -->
                            <div class="form-group">
                                <div class="input-group width-100">
                                    <span class="input-group-addon width-30" style="text-align: left">Name</span>
                                    <input type="text" class="form-control" value="{{ old('name', $instruction_note->name) }}" placeholder="Name" readonly style="background: white !important;">
                                </div>
                            </div>


                            <!-- Description -->
                            <div class="form-group">
                                <div class="input-group width-100">
                                    <span class="input-group-addon width-30" style="text-align: left">Description</span>
                                    <textarea class="form-control" cols="30" rows="8" readonly placeholder="Description" style="background: white !important;">{{ old('description', $instruction_note->description) }}</textarea>
                                </div>
                            </div>




                            <!-- Status -->
                            <div class="form-group">
                                <div class="input-group width-100">
                                    <span class="input-group-addon width-30" style="text-align: left">Status</span>
                                    <input type="text" class="form-control" value="{{ $instruction_note->status == 1 ? 'Active' : 'Inactive' }}" placeholder="Status" readonly style="background: white !important;">
                                </div>
                            </div>



                            <!-- ACTION -->
                            <div class="btn-group pull-right">
                                <button class="btn btn-sm btn-primary" onclick="location.href='{{ route('website.instruction-notes.index') }}'"> <i class="fa fa-save"></i> Back </button>
                                <a href="{{ route('website.instruction-notes.index') }}" class="btn btn-sm btn-secondary"> <i class="fa fa-list"></i> List </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

