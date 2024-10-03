@extends('layouts.master')


@section('title')
    Add Testimonial
@endsection

@section('page-header')
    <i class="fa fa-plus-circle"></i> <span class="hide-in-sm">Add</span> Testimonial
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
                            <a href="{{ route('website.testimonials.index') }}">
                                <i class="fa fa-list-alt"></i> <span class="hide-in-sm"> Testimonial</span> List
                            </a>
                        @endif
                        
                    </span>

                </div>

                <div class="widget-body">
                    <div class="widget-main">


                        @include('partials._alert_message')



                        <form method="POST" action="{{ route('website.testimonials.store') }}" class="form-horizontal"
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
                                <label class="control-label col-sm-3 col-sm-3">Designation<sup
                                        class="text-danger">*</sup>
                                    :</label>
                                <div class="col-md-5 col-sm-5">
                                    <input class="form-control" id="designation" type="text" name="designation"
                                        autocomplete="off" value="{{ old('designation') }}" placeholder="Designation" />
                                </div>
                            </div>


                            <!-- Icon -->
                            <div class="form-group">
                                <label class="control-label col-sm-3 col-sm-3">Country
                                    :</label>
                                <div class="col-md-5 col-sm-5">
                                    {{-- <input class="form-control" id="country" type="text" name="country" autocomplete="off" value="{{ old('country') }}" placeholder="Country" /> --}}
                                    <select name="country_id" id="country_id" class="form-control select2" value="{{ old('country_id') }}" data-placeholder="--- Select Country ---" style="width: 100%">
                                        <option value="">--- Select ---</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <!-- Order -->
                            <div class="form-group">
                                <label class="control-label col-sm-3 col-sm-3">Description<sup
                                        class="text-danger">*</sup>
                                    :</label>
                                <div class="col-md-5 col-sm-5">
                                    <textarea name="description" id="" class="form-control input-sm"
                                        name="description">{{ old('description') }}</textarea>
                                </div>
                            </div>


                            <!-- Position -->
                            <div class="form-group">
                                <label class="control-label col-sm-3 col-sm-3">Rating<sup class="text-danger">*</sup>
                                    :</label>
                                <div class="col-md-5 col-sm-5">
                                    <select name="ratings" class="form-control select2" data-placeholder="--- Rating ---"
                                        style="width: 100%" required>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5" selected>5</option>
                                    </select>
                                </div>
                            </div>


                            <!-- Image -->
                            <div class="form-group">
                                <label class="control-label col-sm-3 col-sm-3">Image :</label>
                                <div class="col-md-5 col-sm-5">
                                    <input class="ace-file-upload" type="file" name="image" />
                                    <small style="margin-left: 1px;"><b>Image size must be 60x60.</b></small>
                                </div>
                            </div>
                            

                            {{-- Status --}}
                            <div class="form-group">
                                <label class="col-sm-3 col-sm-3 text-right" for="form-field-1-1"> Status : </label>
                                <div class="col-md-5 col-sm-5">
                                    <label>
                                        <input name="status" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                            </div>


                            <!-- Action -->
                            <div class="form-group">
                                <label class="control-label col-12"></label>
                                <div class="col-sm-12 text-center" style="width: 100%">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Save
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
