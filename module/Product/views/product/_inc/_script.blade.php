@php
    $sku = generateSKU();
    $category_id = '';
    $brand_id = '';

    if (isset($product->category_id)) {
        $category_id = $product->category_id;
    }

    if (isset($product->brand_id)) {
        $brand_id = $product->brand_id;
    }
@endphp



<script>

    $('#is_variation').click(function () {
        let checked = $(this).is(':checked');

        if (checked) {
            $('#addMeasurement').hide();
        } else {
            $('#addMeasurement').show();
        }
    })





    let productMultipleImageArr = [];



    function getProductType(obj)
    {
        let productTypeId = $(obj).find('option:selected').data('product_type_id');

        $("#product_type_id option").each(function() {
            if ($(this).val() == productTypeId) {
                $("#product_type_id option[value='" + productTypeId + "']").prop("selected", true);
                productTypeData($('#product_type_id'))
            }
        });

        $('.select2').select2();
    }





    /*
     |--------------------------------------------------------------------------
     | PRODUCT TYPE DATA
     |--------------------------------------------------------------------------
    */
    function productTypeData(object)
    {
        let product_type_id = $(object).find('option:selected').val();


        if(product_type_id == 1 || product_type_id == 2 || product_type_id == 3 || product_type_id == 5) {
            $('#attributeSelect').show();
            $('.fashion-type-field').show();
            $('.book-type-field').hide();
            $('#nameLabel').text('Product Name');
            $('#slugLabel').text('Product Slug');
            $('#skuLabel').text('Product SKU');
            $('#codeLabel').text('Product Code');
        }


        if(product_type_id == 4) {
            $('.fashion-type-field').hide();
            $('.book-type-field').show();
            $('#nameLabel').text('Book Name');
            $('#slugLabel').text('Book Slug');
            $('#skuLabel').text('Book SKU');
            $('#codeLabel').text('Book Code');
        }
    }





    $(document).ready(function() {
        $('.summernote').summernote({
            placeholder: 'Write Here .....',
            height: 300
        });



        if ($('#is_variation').is(":checked") == 'No') {
            $('#productVariationDiv').hide();
            $('.product-variation').hide();
        }
    });






    $('.btnNext').click(function(){
        $('.nav-tabs > .active').next('li').find('a').trigger('click');
    });

    $('.btnPrevious').click(function(){
        $('.nav-tabs > .active').prev('li').find('a').trigger('click');
    });








    $('#is_variation').on('click', function () {
        if ($(this).prop("checked") == true) {
            $('#opening_quantity').val(0);
            $('#productOpeningDiv').hide();
            $('#productVariationDiv').show();
            $('.product-variation').show();
            $('#addMultipleImage').hide();
        } else if ($(this).prop("checked") == false) {
            $('#productOpeningDiv').show();
            $('#productVariationDiv').hide();
            $('.product-variation').hide();
            $('#addMultipleImage').show();
        }
    })










    /*
     |--------------------------------------------------------------------------
     | CONVERT IMAGE TO BASE 64
     |--------------------------------------------------------------------------
    */
    function convertImageToBase64(obj, render_id)
    {
        let file = obj.files[0];
        let reader = new FileReader();
        reader.onloadend = function() {
            $('#' + render_id).val(reader.result);
        }
        reader.readAsDataURL(file);
    }










    /*
     |--------------------------------------------------------------------------
     | CONVERT VARIATION IMAGE TO BASE 64
     |--------------------------------------------------------------------------
    */
    function convertVariationImageToBase64(obj)
    {
        let key = $(obj).data('key');
        let total_file = document.getElementById("variation_images" + key).files.length;

        let multipleImageTextarea = '';

        for(let i = 0; i < total_file; i++) {

            let file = event.target.files[i];
            let reader = new FileReader();

            reader.onloadend = function() {

                multipleImageTextarea += `<textarea class="multiple_images" style="display:none">${ reader.result }</textarea>`;

                document.getElementById("variation_images_div" + key).innerHTML = '';

                document.getElementById("variation_images_div" + key).innerHTML = multipleImageTextarea
                document.getElementById("variation_images_count" + key).innerHTML = total_file + ' files'
            }

            reader.readAsDataURL(file);
        }
    }












    function convertMultipleImageToBase64(obj, event, render_id)
    {
        let key = $(obj).data('key');
        let total_file = document.getElementById(event.target.id).files.length;

        let multipleImageTextarea = '';

        for(let i = 0; i < total_file; i++) {

            let file = event.target.files[i];
            let reader = new FileReader();

            reader.onloadend = function() {

                multipleImageTextarea += `<textarea class="pdt_multiple_images form-control" style="display:none">${ reader.result }</textarea>`;

                document.getElementById("productMultipleImage" + key).innerHTML = '';

                document.getElementById("productMultipleImage" + key).innerHTML = multipleImageTextarea
            }

            reader.readAsDataURL(file);
        }
    }





    function priceValidation(e)
    {
        e.preventDefault();

        let purchase_price  = Number($('#purchase_price').val());
        let wholesale_price = Number($('#wholesale_price').val());
        let sale_price      = Number($('#sale_price').val());

        if (wholesale_price > 0) {
            if (purchase_price > wholesale_price) {
                warning('toastr', "Wholesale price can't less then purchase price");
                return;
            }
            else if (wholesale_price > sale_price) {
                warning('toastr', "Sale price can't less then wholesale price");
                return;
            }
        } else if (purchase_price > sale_price) {
            warning('toastr', "Sale price can't less then purchase price");
            return;
        }

        $('#productEditForm').submit();
    }




    function getProductMultipleImageArr()
    {
        $('#productMultipleImage').find('.pdt_multiple_images').each(function () {

            productMultipleImageArr.push({
                'pdt_multiple_images' : $(this).val()
            })
        });

        return productMultipleImageArr;
    }




    function removeProductMultipleImageArr()
    {
        $('#product_multiple_image').val('');
        $('#productMultipleImage').html('');
        $('.pdt_multiple_images').val('');
        productMultipleImageArr = [];
        getProductMultipleImageArr();
    }











    let sl_no = $('.variation_sku').length > 0 ? $('.variation_sku').length : 0;










    /*
     |--------------------------------------------------------------------------
     | APPEND SELECTED ATTRIBUTE
     |--------------------------------------------------------------------------
    */
    $("#atrributes_id").on("change", function () {

        $('.selected-attributes').html('');
        $('#variant-tbody tr').remove();
        $("#atrributes_id option:selected").map(function () {

            let id = $(this).val();
            let text = $(this).text();

            if ($("#selected-div-" + id).length == 0) {
                let selectField =   `<div class="col-lg-6 col-md-offset-3 selected-attribute-div" id="selected-div-${ id }">
                                        <div class="input-group mb-1 width-100">
                                            <input type="hidden" class="attribute-no" value="${ id }">
                                            <input type="hidden" name="attribute_name[]" value="${ text }">
                                            <span class="input-group-addon width-30">
                                                ${ text }<span class="label-required">*</span>
                                            </span>
                                            <select name="attribute_value_${ id }[]" id="select-${ id }" class="form-control select2 attribute-value" data-placeholder="--- Select ---" style="width: 100%" multiple>
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>`;

                $('.selected-attributes').append(selectField);
                $('.select2').select2()

                $.ajax({
                    type: 'GET',
                    url: '{{ route("pdt.products.create") }}',
                    data: {
                        id: id
                    },
                    success: function (data) {
                        attributeAppend(id, data);
                    },
                    error: function () {
                        alert("Error");
                    }
                });
            }

        }).get();
    });










    /*
     |--------------------------------------------------------------------------
     | ATTRIBUTE APPEND
     |--------------------------------------------------------------------------
    */
    function attributeAppend(id, attributes)
    {
        $.each(attributes, function (key, attribute) {
            let option = `<option value="${ attribute.id + '_' + attribute.name }">${ attribute.name }</option>`;
            $('#select-' + id).append(option);
        });
    }










    /*
     |--------------------------------------------------------------------------
     | GENERATE VARIATION
     |--------------------------------------------------------------------------
    */
    function generateVariation()
    {

        $('#variationTable').show()

        $('#variant-tbody tr').remove();
        let options_name = [];
        let options_id = [];

        if ($(".selected-attribute-div")[0]) {

            $.each($(".selected-attribute-div"), function () {
                let data_name = [];
                let data_id = [];
                let data = $(this).find(".attribute-value").val();

                if (data) {
                    $.each(data, function (key, value) {
                        let item = value.split('_');
                        data_name.push(item[1]);
                        data_id.push(item[0]);
                    });
                    options_name.push(data_name);
                    options_id.push(data_id);
                }
            });

            let product_variation_id = makeCombination(options_id);
            let variation_name = makeCombination(options_name);

            makeVariation(product_variation_id, variation_name);
        }
    }










    /*
     |--------------------------------------------------------------------------
     | MAKE COMBINATION
     |--------------------------------------------------------------------------
    */
    function makeCombination(arrays) {
        let result = [[]];

        $.each(arrays, function (property, property_values) {
            let tmp = [];

            $.each(result, function (key, result_item) {
                $.each(property_values, function (key, property_value) {
                    tmp.push(result_item.concat(property_value));
                });
            });

            result = tmp;
        });

        return result;
    }










    /*
     |--------------------------------------------------------------------------
     | MAKE VARIATION
     |--------------------------------------------------------------------------
    */
    function makeVariation(product_variation_id, variation_name) {

        let purchase_price = Number($('#purchasePrice').val()) ?? 0;
        let wholesale_price = Number($('#wholesalePrice').val()) ?? 0;
        let sale_price = Number($('#salePrice').val()) ?? 0;

        let sku = `{{ $sku }}`;

        $('#variant-tbody tr').remove();
        $('#newVariation').show();

        $.each(variation_name, function (key, name) {

            let is_variation = false;

            $.each($(".current_variant_name"), function() {

                if($(this).val() == name) {
                    is_variation = true;

                    warning('toastr', name + ' variation already exists in current variation.');
                }
            });


            if (is_variation == false) {

                let generateSKU = Number(sku) + key + 1;

                let isProductCreate = `{{ isProductCreate() }}`;

                let tr  =  `<tr>
                                <td style="padding-top: 15px;">
                                    ${ sl_no + key + 1 }
                                    <input type="hidden" class="is_sync" name="is_sync[]" value="Yes">
                                    <input type="hidden" class="variation_barcode[]" value="Yes">
                                </td>
                                <td>
                                    <input type="hidden" class="product_variation_id" name="product_variation_id[]" value="${ product_variation_id[key] }">
                                    <input type="text" class="form-control text-center variation_name" name="variation_name[]" value="${ name }" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control text-right only-number variation_purchase_price" name="variation_purchase_price[]" value="${ purchase_price }" autocomplete="off">
                                </td>
                                <td>
                                    <input type="text" class="form-control text-right only-number variation_wholesale_price" name="variation_wholesale_price[]" value="${ wholesale_price }" autocomplete="off">
                                </td>
                                <td>
                                    <input type="text" class="form-control text-right only-number variation_sale_price" name="variation_sale_price[]" value="${ sale_price }" autocomplete="off" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control text-center variation_sku" name="variation_sku[]" value="${ generateSKU }" readonly required>
                                </td>
                                <td>
                                    <input type="text" class="form-control only-number variation_lot" name="variation_lot[]">
                                </td>
                                <td>
                                    <input type="text" class="form-control text-center only-number variation_opening_stock" name="variation_opening_stock[]" value="0" required>
                                </td>
                                <td>
                                    <input type="text" class="form-control text-center only-number date-picker" name="expired_dates[]" data-date-format="yyyy-mm-dd" value="" readonly >
                                </td>
                                <td>
                                    <button type="button" data-key="${ sl_no + key }" data-variation-id="${ product_variation_id[key] }" data-image-count="0" class="form-control btn btn-next" data-toggle="modal" data-target="#multipleImageModal">
                                        Browse ...
                                    </button>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-danger" onclick="removeTableRow(this)"><i class="fa fa-times"></i></a>
                                </td>
                            </tr>`;

                            // <input type="file" class="form-control variation_images" id="variation_images${ key }" name="variation_image_${ key }[]" multiple readonly accept="image/*">

                $('#variant-tbody').append(tr);


                $('.date-picker').datepicker({
                    autoclose  : true,
                    format     : 'yyyy-mm-dd',
                    viewMode   : "days",
                    minViewMode: "days",
                })
                appendDefaultVariationImagesInput()

            }
        });
    }










    /*
     |--------------------------------------------------------------------------
     | REMOVE TABLE ROW
     |--------------------------------------------------------------------------
    */
    function removeTableRow(object) {

        $(object).closest('tr').remove();

        appendDefaultVariationImagesInput()

    }









    function getVariationImages(key, product_variation_id)
    {
        let route = `{{ route('pdt.get-variation-images', ':id') }}`;
        route = route.replace(':id', product_variation_id);

        axios.get(route, { id: product_variation_id })
        .then(function (response) {

            console.log(response.data)

            $('.gallery-images').empty()
            $.each(response.data, function(index, item) {

                $('.gallery-images-'+key).append(`
                <label class="gallery-image gallery-image-${key}" data-parent-id="${ item.id }" data-image-path="${ item.image }">
                    <img src="{{ asset('${ item.image }') }}" class="img-responsive">
                    <a href="javascript:void(0)" class="btn btn-xs delete-image" data-id="${ item.id }" data-key="${key}" data-variation-id="${product_variation_id}" onclick="deleteVariationImage(this)" style="background: red !important; color: #ffffff;"><i class="fa fa-trash"></i></a>
                </label>`)
            })

            imageCheckedAndDisabled(key)

        })
        .catch(function (error) {
            console.log(error);
        });
    }




    function removeVideoThumbnailImage(id)
    {
        let route               = `{{ route('pdt.delete-video-thumbnail-image', ':id') }}`;
        route                   = route.replace(':id', id);

        const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-xs btn-success',
                    cancelButton: 'btn btn-xs btn-danger mr-1'
                },
                buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                axios.delete(route, {
                    id: id
                })
                .then(function (response) {

                    $('#loadVideoThumbnail').empty();

                    $('#loadVideoThumbnail').html(`
                        <div class="add-image upload-section">
                            <label class="upload-image" for="video_thumbnail">
                                <input type="file" id="video_thumbnail" name="video_thumbnail" accept="image/*" onchange="loadPhoto(this, 'videoThumbnailImage')">
                                <img id="videoThumbnailImage" src="" class="img-responsive" style="display: none">
                            </label>
                        </div>
                        <small style="margin-left: 13px;"><b>Video Thumbnail Image</b></small>
                    `)

                    swalWithBootstrapButtons.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                })
                .catch(function (error) {
                    console.log(error);
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your data is safe',
                    'error'
                )
            }
        })
    }







    function deleteProductImage(id, productId)
    {
        let route               = `{{ route('pdt.delete-variation-image', ':id') }}`;
        route                   = route.replace(':id', id);

        const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-xs btn-success',
                    cancelButton: 'btn btn-xs btn-danger mr-1'
                },
                buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                axios.delete(route, {
                    id: id
                })
                .then(function (response) {

                    loadProductMultipleImage(productId);

                    swalWithBootstrapButtons.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                })
                .catch(function (error) {
                    console.log(error);
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your data is safe',
                    'error'
                )
            }
        })
    }










    function deleteVariationImage(obj)
    {
        let id                      = $(obj).data('id');
        let key                     = $(obj).data('key');
        let product_variation_id    = $(obj).data('variation-id');

        let route               = `{{ route('pdt.delete-variation-image', ':id') }}`;
        route                   = route.replace(':id', id);

        const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-xs btn-success',
                    cancelButton: 'btn btn-xs btn-danger mr-1'
                },
                buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                axios.delete(route, {
                    id: id
                })
                .then(function (response) {
                    swalWithBootstrapButtons.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )

                    getVariationImages(key, product_variation_id);
                })
                .catch(function (error) {
                    console.log(error);
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your data is safe',
                    'error'
                )
            }
        })
    }









    function deleteVariation(object, product_variation_id)
    {
        let route               = `{{ route('pdt.delete-variation', ':id') }}`;
        route                   = route.replace(':id', product_variation_id);


        const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-xs btn-success',
                    cancelButton: 'btn btn-xs btn-danger mr-1'
                },
                buttonsStyling: false
        })
        swalWithBootstrapButtons.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.value) {
                axios.delete(route, {
                    id: product_variation_id
                })
                .then(function (response) {
                    swalWithBootstrapButtons.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )

                    removeTableRow(object);
                })
                .catch(function (error) {
                    console.log(error);
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                swalWithBootstrapButtons.fire(
                    'Cancelled',
                    'Your data is safe',
                    'error'
                )
            }
        })
    }









    function generateBarcode()
    {
        let randomChars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let length = 12;
        let result = '';
        for ( let i = 0; i < length; i++ ) {
            result += randomChars.charAt(Math.floor(Math.random() * randomChars.length));
        }

        $('#barcode').val(result);
    }


    function generateSKU()
    {
        let randomNumbers = '0123456789';
        let length = 8;
        let result = '';
        for ( let i = 0; i < length; i++ ) {
            result += randomNumbers.charAt(Math.floor(Math.random() * randomNumbers.length));
        }

        $('#sku').val(result);
    }





    function loadProductMultipleImage(id)
    {
        let route = `{{ route('pdt.get-multiple-images', ':id') }}`;
        route = route.replace(':id', id);

        $('#loadProductMultipleImage').empty();

        axios.get(route)
        .then(function (response) {

            if (response.data.productImages != '') {
                $.each(response.data.productImages, function(index, item) {
                    $('#loadProductMultipleImage').append(`
                        <label class="gallery-image" for="image${index}">
                            <input type="file" class="multiple-image" id="image${index}" name="multiple_image[]" accept="image/*" onchange="loadPhoto(this, 'loadImage${index}')">
                            <img id="loadImage${index}" src="{{ asset('${item.image}') }}" class="img-responsive">
                            <a href="javascript:void(0)" class="btn btn-xs delete-image" onclick="deleteProductImage(${item.id}, ${response.data.product.id})" style="background-color: red !important; color: white !important;"><i class="fas fa-trash"></i></a>
                        </label>
                    `)
                })
            }

        })
        .catch(function (error) { });
    }
</script>












<script>
    const productMeasurement = `<div class="input-group width-100 mb-1 product-measurements">
                                    <span class="input-group-addon" style="text-align: left">
                                        <span>Title</span>
                                    </span>
                                    <input type="text" class="form-control text-center measurement-title" id="measurementTitle" name="product_measurement_title[]" autocomplete="off" placeholder="Title" required>

                                    <span class="input-group-addon" style="text-align: left">
                                        <span>Value</span>
                                    </span>
                                    <input type="text" class="form-control text-center measurement-value only-number" id="measurementValue" name="product_measurement_value[]" autocomplete="off" placeholder="e.g. 10" required>

                                    <span class="input-group-addon" style="text-align: left">
                                        <span>SKU</span>
                                    </span>
                                    <input type="text" class="form-control text-center measurement-sku" id="measurementSKU" name="product_measurement_sku[]" autocomplete="off" placeholder="SKU" readonly required>

                                    <a href="javascript:void(0)" class="input-group-addon rounded-0 bg-dark remove-measurement" style="background-color: #ffbaba !important; color: #000000 !important;">
                                        <i class="fa fa-times"></i>
                                    </a>
                                </div>`;




    function addProductMeasurement(obj)
    {
        let unitMeasure = $.trim($(obj).find('option:selected').text());

        if (unitMeasure) {
            $('#productMeasurementDiv').show();
            $('#productMeasurementTitle').val(`Product Measurement in (${unitMeasure})`)
        }
    }




    $('#addMeasurement').on('click', function () {
        $('#productMeasurement').append(productMeasurement)
        generateMeasurementSKU()
    })



    $('#addInEditMeasurement').on('click', function () {
        $('#addInEditProductMeasurement').append(productMeasurement)
        generateMeasurementSKU()
    })




    $(document).on('click', '.remove-measurement', function () {
        $(this).closest("div").remove();
        generateMeasurementSKU()
    })



    measurementSKU()
    function measurementSKU()
    {
        let randomNumbers = '0123456789';
        let length = 8;
        let result = '';
        for ( let i = 0; i < length; i++ ) {
            result += randomNumbers.charAt(Math.floor(Math.random() * randomNumbers.length));
        }

        $('.f-measurement-sku').val(result);
    }



    function generateMeasurementSKU()
    {
        let sku = Number($('#measurementSKU').val());

        $('.measurement-sku').each(function(index) {
            $(this).val(sku + index)
        })
    }
</script>
