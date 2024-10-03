@extends('layouts.master')

@section('title', 'Category Create')

@section('content')
    <div class="row">
        <div class="col-12">


            <!-- heading -->
            <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                <h4 class="pl-2">
                    <i class="fa fa-plus"></i> Add New Category
                </h4>

                <ul class="breadcrumb mb-1">
                    <li><a href="{{ route('home') }}"><i class="ace-icon far fa-home-lg-alt"></i></a></li>
                    <li>Product Config</li>
                    <li><a class="text-muted" href="{{ route('pdt.categories.index') }}">Category</a></li>
                    <li class=""><a href="javascript:void(0)">Create</a></li>
                </ul>
            </div>



            <div class="widget-body">
                <div class="widget-main">
                    <form class="form-horizontal mt-2" action="{{ route('pdt.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @include('partials._alert_message')

                        <div class="row">
                            <div class="col-md-6 col-md-offset-3">

                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-sm-9 col-xs-4 text-right" for="form-field-1-1"> Show on Menu </label>
                                            <div class="col-sm-3 col-xs-8">
                                                <label>
                                                    <input name="show_on_menu" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-sm-9 col-xs-4 text-right" for="form-field-1-1"> Highlight </label>
                                            <div class="col-sm-3 col-xs-8">
                                                <label>
                                                    <input name="is_highlight" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-sm-9 col-xs-4 text-right" for="form-field-1-1"> Status </label>
                                            <div class="col-sm-3 col-xs-8">
                                                <label>
                                                    <input name="status" class="ace ace-switch ace-switch-6" type="checkbox" checked>
                                                    <span class="lbl"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <!-- PARENT CATEGORY TYPE -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Parent Category <sup class="text-danger">*</sup></span>
                                        <select name="parent_id" id="parent_id" class="form-control select2" style="width: 100%" onchange="getProductType(this)">
                                            <option value="">-- Select --</option>
                                            @foreach ($categories ?? [] as $parentCategory)

                                               <option value="{{ $parentCategory->id }}" data-product_type_id="{{ optional($parentCategory)->product_type_id }}">{{ $parentCategory->name }}</option>

                                                @foreach ($parentCategory->childCategories ?? [] as $childCategory)
                                                    <option value="{{ $childCategory->id }}" data-product_type_id="{{ optional($childCategory)->product_type_id }}" >
                                                        &nbsp;&raquo;&nbsp;{{ $childCategory->name }}
                                                    </option>

                                                    @include('category._inc._include-options', ['childCategory' => $childCategory, 'space' => 1])
                                                @endforeach

                                            @endforeach
                                        </select>
                                    </div>

                                    @error('attribute_type_id')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>




                                <!-- PRODUCT TYPE -->
                                <div class="form-group mb-1" id="productType">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Product Type <sup class="text-danger">*</sup></span>
                                        <select name="product_type_id" id="product_type_id" class="form-control product_type_id select2" style="width: 100%" required>
                                            @foreach($productTypes as $productType)
                                                <option value="{{ $productType->id }}" {{ old('product_type_id') == $productType->id ? 'selected' : '' }}>{{ $productType->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    @error('product_type_id')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>




                                <!-- NAME -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Name <sup class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="name" id="name"
                                        value="{{ old('name') }}" placeholder="Category Name" required>
                                        </div>

                                    @error('name')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>


                                <!-- SLUG -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Slug <sup class="text-danger">*</sup></span>
                                        <input type="text" class="form-control" name="slug" id="slug"
                                        value="{{ old('slug') }}" placeholder="Category Slug" required>
                                        </div>
                                    @error('slug')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>


                                <!-- TITLE -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Title <sup class="text-danger"></sup></span>
                                        <input type="text" class="form-control" name="title" id="title"
                                        value="{{ old('title') }}" placeholder="Category Title">
                                    </div>

                                    @error('title')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>




                                @if (hasAnyPermission(['website-cms.meta-tag'], $slugs))
                                    <!-- META TITLE  -->
                                    <div class="form-group">
                                        <div class="input-group width-100">
                                            <span class="input-group-addon width-30" style="text-align: left">Meta Title</span>
                                            <input type="text" class="form-control" name="meta_title" value="{{ old('meta_title') }}" placeholder="Meta Title Title">
                                        </div>
                                    </div>


                                    <!-- META DESCRIPTION -->
                                    <div class="form-group">
                                        <div class="input-group width-100">
                                            <span class="input-group-addon width-30" style="text-align: left">Meta Description</span>
                                            <textarea style="min-height: 70px" class="form-control" placeholder="Type Meta Description" name="meta_description">{{ old('meta_description') }}</textarea>
                                        </div>
                                    </div>



                                    <!-- IMAGE ALT TAGE  -->
                                    <div class="form-group">
                                        <div class="input-group width-100">
                                            <span class="input-group-addon width-30" style="text-align: left">Alt Text</span>
                                            <input type="text" class="form-control" name="alt_text" value="{{ old('alt_text') }}" placeholder="Meta Alt Text">
                                        </div>
                                    </div>
                                @endif



                                <!-- IMAGE -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Image <sup class="text-danger"></sup></span>
                                        <input type="file" class="form-control" name="image">
                                    </div>
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="background-color: transparent !important; border:none !important;"></span>
                                        <small style="margin-left: 13px;"><b>Image size must be 220x200.</b></small>
                                    </div>
                                    @error('image')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- Icon -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Icon <sup class="text-danger"></sup></span>
                                        <input type="file" class="form-control" name="icon">
                                    </div>
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="background-color: transparent !important; border:none !important;"></span>
                                        <small style="margin-left: 13px;"><b>Icon size must be 40x40.</b></small>
                                    </div>
                                    @error('icon')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- BANNER IMAGE -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Banner Image <sup class="text-danger"></sup></span>
                                        <input type="file" class="form-control" name="banner_image">
                                    </div>
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="background-color: transparent !important; border:none !important;"></span>
                                        <small style="margin-left: 13px;"><b>Banner Image size must be 580x210.</b></small>
                                    </div>
                                    @error('banner_image')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>

                                <!-- SERIAL NO -->
                                <div class="form-group mb-1">
                                    <div class="input-group width-100">
                                        <span class="input-group-addon width-30" style="text-align: left">Serial No</span>
                                        <input type="number" class="form-control" name="serial_no" id="serial_no" value="{{ old('serial_no') }}" placeholder="Serial No">
                                        </div>

                                    @error('serial_no')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror
                                </div>



                                <!-- ACTION -->
                                <div class="btn-group pull-right">
                                    <a href="{{ route('pdt.categories.index') }}" class="btn btn-sm btn-secondary"> <i class="fa fa-list"></i> List </a>
                                    <button class="btn btn-sm btn-primary"> <i class="fa fa-save"></i> Save </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
    @include('category/_inc/_script')
@endsection
