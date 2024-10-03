@extends('layouts.master')


@section('title')
    Add Social Link
@endsection

@section('page-header')
    <i class="fa fa-plus-circle"></i> <span class="hide-in-sm">Add</span> Social Link
@stop



@section('content')

    <div class="row p-20">
        <div class="col-12">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title"> @yield('page-header')</h4>
                    <span class="widget-toolbar">

                        <!--------------- INDEX---------------->
                        @if(hasPermission("website-cms.index", $slugs))
                            <a href="{{ route('website.social-links.index') }}">
                                <i class="fa fa-list-alt"></i> <span class="hide-in-sm">Social Link</span> List
                            </a>
                        @endif
                        
                    </span>

                </div>

                <div class="widget-body">
                    <div class="widget-main">


                        @include('partials._alert_message')



                        <form method="POST" action="{{ route('website.social-links.store') }}" class="form-horizontal"
                            enctype="multipart/form-data">
                            @csrf




                            <!-- Name -->
                            <div class="form-group">
                                <label class="control-label col-sm-3 col-sm-3">Name<sup class="text-danger">*</sup>
                                    :</label>
                                <div class="col-md-5 col-sm-5">
                                    <input class="form-control name" type="text" name="name" autocomplete="off"
                                        value="{{ old('name') }}" placeholder="Name" required />
                                </div>
                            </div>

                            <!-- Slug -->
                            <div class="form-group">
                                <label class="control-label col-sm-3 col-sm-3">Url<sup class="text-danger">*</sup>
                                    :</label>
                                <div class="col-md-5 col-sm-5">
                                    <input class="form-control slug" id="url" type="text" name="url" autocomplete="off"
                                        value="{{ old('url') }}" placeholder="Url" required />
                                </div>
                            </div>


                            <!-- Icon -->
                            <div class="form-group pr">
                                <label class="control-label col-sm-3 col-sm-3">Icon
                                    :</label>
                                <div class="col-md-5 col-sm-5">
                                    <input class="form-control fontawesome" id="icon" type="text" name="icon" autocomplete="off"
                                        value="{{ old('icon') }}" placeholder="Icon" />
                                </div>
                                {{-- <a href="https://fontawesome.com/v5/search" target="_blank" class="suggest-fontawesome">fontawesome.com</a> --}}
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
