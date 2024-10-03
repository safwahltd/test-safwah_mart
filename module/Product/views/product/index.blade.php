@extends('layouts.master')

@section('title', 'Product List')

@section('content')
    <div class="page-header">
        <h4 class="page-title"><i class="fa fa-list"></i> @yield('title')</h4>
        <div class="btn-group">

            <!----------- UPLOAD ------------>
            <a class="btn btn-sm btn-theme" href="{{ route('pdt.bulk-update.create') }}">
                <i class="fa fa-upload"></i>
                Bulk Update
            </a>

            <!----------- UPLOAD ------------>
            @if ((hasPermission("products.upload", $slugs)))
                <a class="btn btn-sm btn-pink" href="{{ route('pdt.products.create', ['upload' => 'product']) }}">
                    <i class="fa fa-upload"></i>
                    Upload CSV
                </a>
            @endif

            <!----------- CREATE ------------>
            @if ((hasPermission("products.create", $slugs)))
                <a class="btn btn-sm btn-primary" href="{{ route('pdt.products.create') }}">
                    <i class="fa fa-plus-circle"></i>
                    Add New
                </a>
            @endif
        </div>
    </div>

    @include('partials._alert_message')

    <div class="row">
        <form id="searchForm" action="" method="GET">
            <div class="col-sm-12">
                <table class="table table-bordered">
                    <tr>
                        <!-- PRODUCT TYPE -->
                        <td width="25%">
                            <select name="product_type_id" id="product_type_id" class="form-control select2" style="width: 100%">
                                <option value="">All Type</option>
                                @foreach($types ?? [] as $type)
                                    <option value="{{ $type->id }}" {{ request('product_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </td>





                        <!-- BRAND -->
                        <td width="25%">
                            <select name="brand_id" id="brand_id" class="form-control select2" style="width: 100%">
                                <option value="" selected>All Brand</option>
                                @foreach($brands ?? [] as $brand)
                                    <option value="{{ $brand->id }}" {{ request('brand_id') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                                @endforeach
                            </select>
                        </td>





                        <!-- CATEGORY -->
                        <td width="25%">
                            <select name="category_id" id="category_id" class="form-control select2" style="width: 100%">
                                <option value="" selected>All Category</option>
                                @foreach ($categories ?? [] as $parentCategory)
                                    <option value="{{ $parentCategory->id }}"
                                        {{ request('category_id') == $parentCategory->id ? 'selected' : '' }}>
                                        {{ $parentCategory->name }}
                                    </option>


                                    @foreach ($parentCategory->childCategories ?? [] as $childCategory)
                                        <option value="{{ $childCategory->id }}"
                                            {{ request('category_id') == $childCategory->id ? 'selected' : '' }}>
                                            &nbsp;&raquo;&nbsp;{{ $childCategory->name }}
                                        </option>

                                        @include('category/_inc/_search-options', ['childCategory' => $childCategory, 'space' => 1])
                                    @endforeach
                                @endforeach
                            </select>
                        </td>





                        <!-- NAME -->
                        <td width="25%">
                            <input type="text" class="form-control" name="search" value="{{ request('search') }}" placeholder="Search By Name, SKU">
                        </td>
                    </tr>





                    <tr>
                        <!-- ACTION -->
                        <td colspan="4" class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-primary" style="padding-top: 6px; padding-bottom: 6px;"><i class="fa fa-search"></i> SEARCH</button>
                                <a href="{{ request()->url() }}" class="btn btn-sm btn-light" style="width: 49%; padding-top: 6px; padding-bottom: 6px;"><i class="fa fa-refresh"></i> REFRESH</a>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
        </form>



        <form id="bulkForm" action="{{ route('pdt.update-product-field') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="field_name" id="fieldName">

            <div class="col-xs-12">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead style="border-bottom: 3px solid #346cb0 !important">
                            <tr id="bulkAction" style="background: #e1ecff !important; color:black !important; display: none">
                                <th colspan="12">
                                    <button class="btn-red" id="bulkDelete" type="button">Delete All</button>
                                </th>
                            </tr>
                            <tr style="background: #e1ecff !important; color:black !important">
                                <th width="2%">
                                    <div class="checkbox" style="margin-top: 0px; margin-bottom: 0px">
                                        <label style="padding-left: 12px">
                                            <input type="checkbox" class="ace check-all-item">
                                            <span class="lbl"></span>
                                        </label>
                                    </div>
                                </th>
                                <th width="3%" class="text-center">SL</th>
                                <th width="100px">Image</th>
                                <th width="25%">Name</th>
                                <th width="10%">SKU</th>
                                <th width="5%">Type</th>
                                <th width="10%">Category</th>
                                <th width="10%">Brand</th>
                                <th width="8%">MRP</th>
                                <th width="5%" class="text-center">Refundable</th>
                                <th width="5%" class="text-center">Status</th>
                                <th width="5%" class="text-center action">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($products as $item)
                                <tr>
                                    <td>
                                        <div class="checkbox" style="margin-top: 0px; margin-bottom: 0px">
                                            <label style="padding-left: 12px">
                                                <input type="checkbox" name="product_ids[]" value="{{ $item->id }}" class="ace check-item">
                                                <span class="lbl"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="text-center td">{{ $products->firstItem() + $loop->index }}</td>
                                    <td class="td">
                                        <img src="{{ file_exists($item->thumbnail_image) ? asset($item->thumbnail_image) : asset('default.svg') }}" alt="product img" width="60px;">
                                        <a class="bulk-edit-btn" onclick="editField(this, 'thumbnail_image')" type="button" data-toggle="modal" data-target="#editFieldModal" href="javascript:void(0)" style="display: none;">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    </td>
                                    <td class="td">
                                        <span class="item-field">{{ $item->name }}</span>
                                        <a class="bulk-edit-btn" onclick="editField(this, 'name')" type="button" data-toggle="modal" data-target="#editFieldModal" href="javascript:void(0)" style="display: none;">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    </td>
                                    <td class="td">
                                        <span class="item-field">{{ $item->sku }}</span>
                                    </td>
                                    <td class="td">
                                        <span class="item-field">{{ optional($item->productType)->name }}</span>
                                    </td>
                                    <td class="td">
                                        <span class="item-field" style="display: none">{{ $item->category->id }}</span>
                                        {{ optional($item->category)->name }}
                                        <a class="bulk-edit-btn" onclick="editField(this, 'category_id')" type="button" data-toggle="modal" data-target="#editFieldModal" href="javascript:void(0)" style="display: none;">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    </td>
                                    <td class="td">
                                        <span class="item-field" style="display: none">{{ $item->brand_id }}</span>
                                        {{ optional($item->brand)->name }}
                                        <a class="bulk-edit-btn" onclick="editField(this, 'brand_id')" type="button" data-toggle="modal" data-target="#editFieldModal" href="javascript:void(0)" style="display: none;">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    </td>
                                    <td class="text-right td">
                                        <span class="item-field">{{ number_format($item->sale_price, 2, '.', '') }}</span>
                                        <a class="bulk-edit-btn" onclick="editField(this, 'sale_price')" type="button" data-toggle="modal" data-target="#editFieldModal" href="javascript:void(0)" style="display: none;">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    </td>
                                    <td class="text-center td">
                                        <span class="badge label-{{ $item->is_refundable == 'Yes' ? 'success' : 'danger' }}">
                                            {{ $item->is_refundable == 'Yes' ? 'Yes' : 'No' }}
                                        </span>
                                        <span class="item-field" style="display: none">{{ $item->is_refundable }}</span>
                                        <a class="bulk-edit-btn" onclick="editField(this, 'is_refundable')" type="button" data-toggle="modal" data-target="#editFieldModal" href="javascript:void(0)" style="display: none;">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    </td>
                                    <td class="text-center td">
                                        <x-status status="{{ $item->status }}" id="{{ $item->id }}" table="{{ $table }}" />
                                    </td>
                                    <td class="text-center action">
                                        <div class="dropdown">
                                            <a href="javascript:void(0)" class="text-danger fas fa-ellipsis-h" type="button" data-toggle="dropdown" style="font-size: 20px"></a>
                                            <ul class="dropdown-menu dropdown-menu-right">
                                                <li>
                                                    @php
                                                        $website = \App\Models\Company::find(1)->website;
                                                    @endphp
                                                    <a href="{{ $website . 'product-details' . '/' . $item->slug }}" target="_blank">
                                                        <i class="fa fa-eye"></i> Show
                                                    </a>
                                                </li>


                                                <!----------- EDIT ------------>
                                                @if ((hasPermission("products.edit", $slugs)))
                                                    <li>
                                                        <a href="{{ route('pdt.products.edit', $item->id) }}" title="Edit">
                                                            <i class="fa fa-pencil-square-o"></i> Edit
                                                        </a>
                                                    </li>
                                                @endif

                                                @if (hasAnyPermission(['website-cms.meta-tag'], $slugs))
                                                    <li>
                                                        <a href="{{ route('pdt.products.alt-text', $item->id) }}" title="Alt Text">
                                                            <i class="fa fa-pencil-square-o"></i> Alt Text
                                                        </a>
                                                    </li>
                                                @endif


                                                <!----------- DELETE ------------>
                                                @if ((hasPermission("products.delete", $slugs)))
                                                    <li>
                                                        <a href="javascript:void(0)" title="Delete" onclick="delete_item('{{ route('pdt.products.destroy', $item->id) }}')" type="button">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </a>
                                                    </li>
                                                @endif

                                                <li class="divider"></li>
                                                <li>
                                                    @include('partials._new-user-log', ['data' => $item])
                                                </li>
                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    @include('partials._paginate', ['data'=> $products])
                </div>
            </div>

            @include('product/_inc/bulk/edit-field-modal')
        </form>
    </div>
@endsection

@section('script')

    <script>
        function editField(obj, field_name)
        {
            $('.change-field-div').hide();
            $('.change-field-div-'+field_name).show();

            $('.change-field').prop('disabled', true)
            $('.change-field-'+field_name).prop('disabled', false)

            let val = $(obj).closest('td').find('.item-field').text();

            if (field_name == 'category_id' || field_name == 'brand_id' || field_name == 'is_refundable') {
                $(".change-field-"+field_name+" option[value='" + val + "']").attr("selected", "selected");
            } else {
                $('.change-field-'+field_name).val(val)
            }

            $('#fieldName').val(field_name)

            $('.select2').select2()
        }
    </script>

    <script>
        $(document).on('click', '.check-all-item', function() {
            let check = $(this).is(':checked');
            if (check) {
                $('.check-item').prop('checked', true);
                $('.action').hide();
                $('#bulkAction').show();
            } else {
                $('.check-item').prop('checked', false);
                $('.action').show();
                $('#bulkAction').hide();
            }
        });


        $(document).on('click', '.check-item', function() {

            if($(this).prop("checked") == true){
                $(this).closest('tr').find('.action').hide();
                $('#bulkAction').show();
            }
            else if($(this).prop("checked") == false) {
                $(this).closest('tr').find('.action').show();
            }

            let count = 0;
            $('.check-item').each(function(index) {
                count += $(this).is(':checked') ? 1 : 0;
            })

            if (count == 0) {
                $('#bulkAction').hide();
            }
        });



        $(document).on('mouseover', '.td', function () {

            let isChecked = $(this).closest('tr').find('.check-item').is(':checked') ? true : false;

            if (isChecked)
                $(this).find('.bulk-edit-btn').show();
        })



        $(document).on('mouseout', '.td', function () {
            $(this).find('.bulk-edit-btn').hide();
        })


        $('#bulkDelete').click(function()
        {
            Swal.fire({
                title: 'Are you sure ?',
                html:   `<div style='margin: 10px 0'>
                            <b>You will delete this record(s) permanently !</b>
                        </div>`,
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                width:400,
            }).then((result) =>{
                if(result.value){
                    let route = `{{ route('pdt.bulk-product-delete') }}`;
                    $('#bulkForm').attr('action', route).submit();
                }
            })
        });
    </script>

@endsection
