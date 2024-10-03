@extends('layouts.master')


@section('title')
    Add Faq
@endsection

@section('page-header')
    <i class="fa fa-plus-circle"></i> <span class="hide-in-sm">Add</span> Faq
@stop



@section('content')

    <div class="row p-20">
        <div class="col-12">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title"> @yield('page-header')</h4>
                    <span class="widget-toolbar">
                        <a href="{{ route('website.faqs.index') }}">
                            <i class="fa fa-list-alt"></i> <span class="hide-in-sm">Faq</span> List
                        </a>
                    </span>

                </div>

                <div class="widget-body">
                    <div class="widget-main">


                        @include('partials._alert_message')



                        <form method="POST" action="{{ route('website.faqs.store') }}" class="form-horizontal"
                            enctype="multipart/form-data">
                            @csrf




                            <!-- Title -->
                            <div class="form-group">
                                <label class="control-label col-sm-3 col-sm-3">Title<sup class="text-danger">*</sup>
                                    :</label>
                                <div class="col-md-5 col-sm-5">
                                    <input class="form-control name" type="text" name="title" autocomplete="off"
                                        value="{{ old('title') }}" placeholder="Title" required />
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="form-group">
                                <label class="control-label col-sm-3 col-sm-3">Description<sup class="text-danger">*</sup>
                                    :</label>
                                <div class="col-md-5 col-sm-5">
                                    <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                                   
                                </div>
                            </div>




                            <!-- Action -->
                            <div class="form-group">
                                <label class="control-label col-12"></label>
                                <div class="col-sm-12 text-center" style="width: 100%">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Add New Link
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection



@section('js')


    <script>
        $('#product_id').change(function() {

            $('.price').val($(this).find('option:selected').data('price'))
        })
    </script>


    <script>
        $('#profile_id').change(function() {
            let profile = $(this).find('option:selected');

            $('.name').val(profile.text())
            $('.mobile').val(profile.data('mobile'))
            $('.email').val(profile.data('email'))
            $('.age').val(profile.data('age'))
            $('.country').val(profile.data('country'))
        })
    </script>


@endsection
