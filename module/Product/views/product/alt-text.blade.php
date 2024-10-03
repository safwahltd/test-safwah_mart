@extends('layouts.master')
@section('title', 'Edit Product Alt Text')


@section('css')
    <link rel="stylesheet" href="{{ asset('assets/custom_css/image-plugin.css') }}">

    <style>
        .show-multiple-image {
            position: relative;
            border: 1px solid #ccc;
        }

        .show-multiple-image .image {
            opacity: 1;
            display: block;
            width: 80px;
            height: 80px;
            transition: .5s ease;
            backface-visibility: hidden;
        }

        .action {
            transition: .5s ease;
            opacity: 0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            text-align: center;
        }

        .show-multiple-image:hover .image {
            opacity: 0.1;
        }

        .show-multiple-image:hover .action {
            opacity: 1;
        }

        .show-multiple-image .action a {
            color: red;
            font-size: 16px;
        }
    </style>
@endsection


@section('content')




    <!-- heading -->
    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
        <h4 class="pl-2"><i class="fa fa-edit"></i> @yield('title')</h4>

        <ul class="breadcrumb mb-1">
            <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
            <li>Product Config</li>
            <li><a class="text-muted" href="{{ route('pdt.products.index') }}">Product</a></li>
            <li class=""><a href="javascript:void(0)">Edit</a></li>
        </ul>
    </div>




    <div class="row">
        <div class="col-12">

            <div class="widget-body">
                <div class="widget-main">
                    <form id="productEditForm" class="form-horizontal mt-2" action="{{ route('pdt.products.alt-text.save', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @include('partials._alert_message')

                        @if($multipleImages->count() > 0)
                            <div class="row add-image mt-1">
                                <div class="col-md-6 col-md-offset-3">
                                    <div class="upload-section" id="loadProductMultipleImage">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th style="width: 20px">SL</th>
                                                    <th style="width: 100px" class="text-center">Image</th>
                                                    <th>Alt Text</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($multipleImages as $multipleImage)
                                                    <tr>
                                                        <td style="vertical-align: middle; border: none">{{ $loop->iteration }}</td>
                                                        <td  style="vertical-align: middle; border: none"class="text-center">
                                                            <img style="height: 80px; width: 80px" src="{{ asset($multipleImage->image) }}">
                                                        </td>
                                                        <td style="vertical-align: middle; border: none">
                                                            <input type="text" class="form-control" name="alt_texts[{{ $multipleImage->id }}]" value="{{ $multipleImage->alt_text }}">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>

                                            <tfoot>
                                                <tr>
                                                    <th colspan="3" class="text-right">
                                                        <div class="btn-group">
                                                            <a href="{{ route('pdt.products.index') }}" class="btn btn-md btn-default">
                                                                <i class="fa fa-list-alt"></i> List
                                                            </a>

                                                            <button type="submit" class="btn btn-md btn-primary">
                                                                <i class="fa fa-save"></i> Save
                                                            </button>
                                                        </div>
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @else
                            <h3 class="text-center font-weight-bold mt-5 text-danger" style="font-size: 32px; font-weight: 600;">
                                No images found for alt text
                            </h3>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>



@endsection


@section('js')

    <script src="{{ asset('assets/custom_js/image-plugin.js') }}"></script>

@stop
