@extends('layouts.master')

@section('title', 'Create Seo Info')


@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">


            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('website.seo-infos.store', $page_title) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('partials._alert_message')

                        <div class="row">
                            <div class="col-md-10 col-md-offset-1">

                                <h3>
                                    <strong><i>Seo Info for '{{ $page_title }}'</i></strong>
                                </h3>


                                <!-- META TITLE  -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Meta Title</span>
                                        <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title', optional($seoInfo)->meta_title) }}" placeholder="Meta Title Title">
                                    </div>
                                </div>


                                <!-- META DESCRIPTION -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Meta Description</span>
                                        <textarea style="min-height: 70px" class="form-control" placeholder="Type Meta Description" name="meta_description">{{ old('meta_description', optional($seoInfo)->meta_description) }}</textarea>
                                    </div>
                                </div>



                                <!-- IMAGE ALT TAGE  -->
                                <div class="form-group">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Alt Text</span>
                                        <input type="text" class="form-control" name="alt_text" value="{{ old('alt_text', optional($seoInfo)->alt_text) }}" placeholder="Meta Alt Text">
                                    </div>
                                </div>


                                <!-- ACTION -->
                                <div class="btn-group pull-right">
                                    <a class="btn btn-sm btn-warning" href="{{ $previous_url ?? url()->previous() }}"><i class="fa fa-arrow-left"></i> Back</a>
                                    <button class="btn btn-sm btn-primary"><i class="fa fa-save"></i> Save</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
