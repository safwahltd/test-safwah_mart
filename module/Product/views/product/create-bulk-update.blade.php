@extends('layouts.master')
@section('title', 'Bulk Update Create')

@section('content')
<div class="breadcrumbs ace-save-state" id="breadcrumbs">
    <h4 class="pl-2"><i class="fas fa-upload"></i> @yield('title')</h4>

    <ul class="breadcrumb mb-1">
        <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
        <li>Product Config</li>
        <li><a class="text-muted" href="{{ route('pdt.products.index') }}">Product</a></li>
        <li class=""><a href="javascript:void(0)">Bulk Update Create</a></li>
    </ul>
</div>


<div class="row">
    <div class="col-12">
        <form method="POST" action="{{ route('pdt.bulk-update.store') }}" class="form-horizontal" enctype="multipart/form-data">
            @csrf
            
            <input type="hidden" name="store_type" value="upload">

            <div class="row mt-3">
                <div class="col-sm-12">
                    <!-- file upload -->
                    <div class="col-sm-6 col-sm-offset-3">
                        <input type="file" id="csv_upload" class="form-control ace-file-upload" name="csv_file">
                    </div>




                    <!-- Action -->
                    <div class="col-sm-6 col-sm-offset-3 text-right">
                        <a href="{{ asset('sample/bulk-update-sample.csv') }}" download class="btn btn-inverse btn-sm">
                            <span class="translate">
                                Download Sample
                            </span>
                            <i class="fa fa-download"></i>
                        </a>
                        <button class="btn btn-primary btn-sm" type="submit">
                            <i class="far fa-check-circle"></i> UPDATE
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection


@section('js')
    <script>
        $('#csv_upload').ace_file_input({
            style: 'well',
            btn_choose: 'Attach Product CSV file',
            btn_change: null,
            no_icon: 'ace-icon fa fa-cloud-upload',
            droppable: true,
            thumbnail: 'small',
            preview_error : function(filename, error_code) {
            }
        }).on('change', function(){
        });
    </script>
@stop
