@extends('layouts.master')


@section('title')
    Edit Website Menu
@endsection

@section('page-header')
    <i class="fa fa-edit"></i> <span class="hide-in-sm">Edit</span> Menu
@stop



@section('content')

    <div class="row p-20">
        <div class="col-12">
            <div class="widget-box">
                <div class="widget-header">
                    <h4 class="widget-title"> @yield('page-header')</h4>
                    <span class="widget-toolbar">
                        <a href="{{ route('website.widget-menus.index') }}">
                            <i class="fa fa-list-alt"></i> <span class="hide-in-sm">Website Menu</span> List
                        </a>
                    </span>

                </div>

                <div class="widget-body">
                    <div class="widget-main">


                        @include('partials._alert_message')



                        <form method="POST" action="{{ route('website.widget-menus.update', $menu->id) }}" class="form-horizontal"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')


                            <!-- Category -->
                            <div class="form-group">
                                <label class="control-label col-sm-3 col-sm-3">Category<sup
                                        class="text-danger">*</sup>:</label>
                                <div class="col-md-5 col-sm-5">
                                    <select name="menu_category_id" class="form-control select2" data-selected="{{ $menu->menu_category_id }}"
                                        data-placeholder="--- Select Category ---" style="width: 100%" required>
                                        <option></option>
                                        @foreach ($categories as $id => $name)
                                            <option value="{{ $id }}">
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <!-- Parent -->
                            <div class="form-group">
                                <label class="control-label col-sm-3 col-sm-3">Parent Menu
                                    :</label>
                                <div class="col-md-5 col-sm-5">
                                    <select name="parent_id" class="form-control select2"
                                        data-placeholder="--- Select Parent Menu ---" style="width: 100%">
                                        @foreach ($parent_menus as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ request('parent_id') == $id ? 'selected' : '' }}>{{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>




                            <!-- Name -->
                            <div class="form-group">
                                <label class="control-label col-sm-3 col-sm-3">Name<sup class="text-danger">*</sup>
                                    :</label>
                                <div class="col-md-5 col-sm-5">
                                    <input class="form-control name" type="text" name="name" autocomplete="off"
                                        value="{{ old('name', $menu->name) }}" placeholder="Name" required />
                                </div>
                            </div>

                            <!-- Slug -->
                            <div class="form-group">
                                <label class="control-label col-sm-3 col-sm-3">Slug<sup class="text-danger">*</sup>
                                    :</label>
                                <div class="col-md-5 col-sm-5">
                                    <input class="form-control slug" id="slug" type="text" name="slug" autocomplete="off"
                                        value="{{ old('slug',$menu->slug) }}" placeholder="Slug" required />
                                </div>
                            </div>


                            <!-- Icon -->
                            <div class="form-group">
                                <label class="control-label col-sm-3 col-sm-3">Icon
                                    :</label>
                                <div class="col-md-5 col-sm-5">
                                    <input class="form-control" id="icon" type="text" name="icon" autocomplete="off"
                                        value="{{ old('icon',$menu->icon) }}" placeholder="Icon" />
                                </div>
                            </div>


                            <!-- Order -->
                            <div class="form-group">
                                <label class="control-label col-sm-3 col-sm-3">Order<sup class="text-danger">*</sup>
                                    :</label>
                                <div class="col-md-5 col-sm-5">
                                    <input class="form-control" type="number" name="order_no" autocomplete="off"
                                        value="{{ old('order_no',$menu->order_no) }}" placeholder="Order No." required />
                                </div>
                            </div>


                            <!-- Position -->
                            <div class="form-group">
                                <label class="control-label col-sm-3 col-sm-3">Position<sup class="text-danger">*</sup>
                                    :</label>
                                <div class="col-md-5 col-sm-5">
                                    <select name="position" class="form-control select2" data-selected="{{ $menu->position }}"
                                        data-placeholder="--- Select Position ---" style="width: 100%" required>
                                        <option value="Top" selected>Top</option>
                                        <option value="Bottom">Bottom</option>
                                        <option value="Middle">Middle</option>
                                        <option value="Left Side">Left Side</option>
                                        <option value="Right Side">Right Side</option>
                                    </select>
                                </div>
                            </div>


                            <!-- Image -->
                            <div class="form-group">
                                <label class="control-label col-sm-3 col-sm-3">Image :</label>
                                <div class="col-md-5 col-sm-5">
                                    <input class="ace-file-upload" type="file" name="image" />
                                </div>
                            </div>



                            <!-- Action -->
                            <div class="form-group">
                                <label class="control-label col-12"></label>
                                <div class="col-sm-12 text-center" style="width: 100%">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fa fa-save"></i> Save Menu
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
