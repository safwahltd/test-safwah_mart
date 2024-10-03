
<script>


    function emptyVariationQtyComment(obj)
    {
        $(obj).closest('tr').find('.product-variations').empty().select2();
        $(obj).closest('tr').find('.product-variations').append(`<option value="" selected>- Select -</option>`).select2();
        $(obj).closest('tr').find('.lot').val('');
        $(obj).closest('tr').find('.purchase-price').val('');
        $(obj).closest('tr').find('.quantity').val('');
        $(obj).closest('tr').find('.special_comment').val('');
    }





    function getProductVariations(obj)
    {
        const route = `{{ route('inv.purchases.axios.get-product-variations') }}`;

        let _this           = $(obj).find('option:selected');
        let product_id      = _this.val();
        let category        = _this.data('category');
        let unit_measure    = _this.data('unit-measure');
        let purchase_price  = _this.data('purchase-price');
        let sku  = _this.data('sku');


        $(obj).closest('tr').find('.category').val(category);
        $(obj).closest('tr').find('.unit-measure').val(unit_measure);

        axios.get(route, {
            params: { product_id : product_id }
        })
        .then(function (response) {
            let data = response.data;

            emptyVariationQtyComment(obj);

            if (data != '') {

                $(obj).closest('tr').find('.product_is_variation').val('true');
                $(obj).closest('tr').find('.product-variations').prop('required', true);

                data.map(function(productVariation, index) {
                    $(obj).closest('tr').find('.product-variations').append(`<option value="${ productVariation.id }" data-variation-purchase-price="${ productVariation.purchase_price }">${ productVariation.name }</option>`).select2();
                })

            } else {

                $(obj).closest('tr').find('.purchase-price').val(purchase_price);
                $(obj).closest('tr').find('.sku-code').val(sku);
                $(obj).closest('tr').find('.product-variations').empty().select2();
                $(obj).closest('tr').find('.product-variations').append(`<option value="" selected>- Select -</option>`).select2();
                $(obj).closest('tr').find('.product-variations').prop('required', false);
            }


            checkItemExistOrNot(obj)
        })
        .catch(function (error) { });
    }
</script>




<script>
    function checkItemExistOrNot(obj)
    {
        let productId = $(obj).closest('tr').find('.products').find('option:selected').val();
        let variationId = $(obj).closest('tr').find('.product-variations').find('option:selected').val();
        let variationPurchasePrice = Number($(obj).closest('tr').find('.product-variations').find('option:selected').data('variation-purchase-price')).toFixed(2);

        let is_find = 0;


        $('.products').each(function(index) {
            let product_id = $(this).val()
            let is_variation = $(this).closest('tr').find('.product-is-variation').val();
            let variation_id = $(this).closest('tr').find('.product-variations').val();


            if (product_id == productId) {

                if (is_variation == 'true') {

                    if (isNaN(variationPurchasePrice)) {
                        variationPurchasePrice = '';
                    }
                    $(obj).closest('tr').find('.purchase-price').val(variationPurchasePrice)
                    if (variationId == variation_id) {
                        is_find += 1;
                    }
                } else {
                    is_find += 1;
                }
            }
        })

        /*-------------------------------------*/


        /*--------------------------------------*/


        if (is_find > 1) {
            return; // disable duplicate check
            warning('toastr', 'Item already exists !');
            $(obj).closest('tr').remove();

            // $(obj).closest('tr').find('.products').val('');
            // $(obj).closest('tr').find('.products').select2();
            // $(obj).closest('tr').find('.category').val('');
            // $(obj).closest('tr').find('.unit-measure').val('');
            // $(obj).closest('tr').find('.purchase-cost').val('')
            emptyVariationQtyComment(obj)

            // $('.select2').select2()

            return;
        }
    }
</script>




<script>
 let i = 0;
        let product_sn = 0;
    $(document).ready(function() {



        $('#sidebar').addClass('menu-min');





        let i = 0

        $("#addrow").on("click", function() {
            $("#purchaseTable").append(`<tr>
                            <input type="hidden" name="purchase_detail_id[]" value="">
                            <input type="hidden" class="product_is_variation" value="false">
                            <th>
                                <select name="product_id[]" id="product_id" class="form-control products product_id product_id-${product_sn} select2" data-placeholder="- Select -" onchange="getProductVariations(this)" required>
                                    <option></option>

                                </select>
                            </th>
                            <th>
                                <select name="product_variation_id[]" id="product_variation_id" class="form-control product-variations select2" onchange="checkItemExistOrNot(this)">
                                    <option value="" selected>- Select -</option>
                                </select>
                            </th>
                            <th>
                                <input type="text" name="" id="sku[]" value="" class="form-control sku-code" readonly>
                            </th>
                            <th>
                                <input type="text" name="category_id[]" id="category_id" class="form-control category" readonly>
                            </th>
                            <th>
                                <input type="text" name="unit_measure_id[]" id="unit_measure_id" class="form-control unit-measure" readonly>
                            </th>
                            <th>
                                <input type="text" name="lot[]" id="lot" class="form-control lot" autocomplete="off">
                            </th>
                            <th>
                                <input type="text" name="purchase_price[]" id="purchase_price" class="form-control text-right only-number purchase-price purchase-cost" autocomplete="off" required>
                            </th>
                            <th>
                                <input type="number" name="quantity[]" id="quantity" class="form-control text-center quantity" autocomplete="off" required>
                            </th>
                            <th>
                                <input type="text" name="expired_dates[]" data-date-format="yyyy-mm-dd" class="form-control date-picker" readonly autocomplete="off">
                            </th>
                            <th>
                                <input type="text" name="special_comment[]" id="special_comment" class="form-control special_comment" autocomplete="off">
                            </th>
                            <th class="text-center">
                                <button type="submit" class="btn btn-sm btn-danger remove-row" title="Remove"><i class="fa fa-times"></i></button>
                            </th>
                        </tr>`

            )



            $('.date-picker').datepicker({
                autoclose: true,
                format:'yyyy-mm-dd',
                viewMode: "days",
                minViewMode: "days",
            })

            $(".product_id-"+product_sn).select2({
                ajax: {
                    url: `{{ route('get-sale-products') }}`,
                    type: 'GET',
                    dataType: 'json',
                    delay: 250,
                    data : function(params) {
                        return {
                            q: params.term, // search term
                            page: params.current_page
                        };
                    },
                    processResults: function(data, params) {
                        params.current_page = params.current_page || 1;

                        return {
                            results: data.data,
                            pagination: {
                                more: (params.current_page * 30) < data.total
                            }
                        };
                    },
                    autoWidth: true,
                    cache: true
                },
                placeholder: 'Search Product',
                minimumInputLength: 1,
                templateResult: formatProduct,
                templateSelection: formatProductSelection
            }).on('change', function(e) {

                // $(this).find('option').remove();
                $(this).append(`
                <option value='${ $(this).select2('data')[0].id }'
                    data-sku               = "${ $(this).select2('data')[0].sku }"
                    data-category               = "${ $(this).select2('data')[0].category.name }"
                    data-unit-measure           = "${ $(this).select2('data')[0].unit_measure.name }"
                    data-purchase-price         = "${ Number($(this).select2('data')[0].purchase_price) }"
                    selected
                > ${ $(this).select2('data')[0].name + ' - ' + $(this).select2('data')[0].sku }
                </option>`);
            });

            function formatProduct(product) {
                if (product.loading) {
                    return product.text;
                }

                var $container = $(`
                    <div class='select2-result-product clearfix'>
                        <div class='select2-result-product__title'>
                            ${ product.name + ' -> ' + product.sku }
                        </div>
                    </div>
                `);

                return $container;
            }

            function formatProductSelection(product) {
                return product.name || product.text;
            }
            // $('.select2').select2();
            i++
        });

        $("#purchaseTable").on("click", ".remove-row", function(event) {
            $(this).closest("tr").remove();
            $('.select2').select2();
            i--
        });
    });
</script>





<script>


    /*
     |--------------------------------------------------------------------------
     | CALCULATE DISCOUNT AMOUNT
     |--------------------------------------------------------------------------
    */
    function calculateDiscountAmount(object)
    {
        let subtotal = $('#subtotal').val();

        let discountPercent = parseFloat($(object).val());
        let discountAmount = parseFloat(subtotal - (subtotal - ( subtotal * discountPercent / 100 )));

        if (isNaN(discountAmount)) {
            discountAmount = 0;
        }

        $('#total_discount_amount').val(discountAmount.toFixed(2));

        calculateAmount()
    }





    /*
     |--------------------------------------------------------------------------
     | CALCULATE DISCOUNT PERCENT
     |--------------------------------------------------------------------------
    */
    function calculateDiscountPercent(object)
    {
        let subtotal = $('#subtotal').val();

        let discountAmount = parseFloat($(object).val());
        let discountPercent = (discountAmount / subtotal) * 100;

        if (isNaN(discountPercent)) {
            discountPercent = 0
        }

        $('#total_discount_percent').val(discountPercent.toFixed(2));

        calculateAmount()
    }





    /*
     |--------------------------------------------------------------------------
     | CALCULATE AMOUNT
     |--------------------------------------------------------------------------
    */
    function calculateAmount()
    {
        let subtotal        = $('#subtotal').val();
        let paidAmount      = $('#paid_amount').val();
        let discountAmount  = $('#total_discount_amount').val();
        let newPayable      = subtotal - discountAmount;
        let dueAmount       = newPayable - paidAmount;

        $('#payable_amount').val(newPayable.toFixed(2));
        $('#due_amount').val(dueAmount.toFixed(2));
    }





    /*
     |--------------------------------------------------------------------------
     | ATTACHMENT
     |--------------------------------------------------------------------------
    */
    $('#attachment').ace_file_input({
        style: 'well',
        btn_choose: 'UPLOAD ATTACHMENT',
        btn_change: null,
        no_icon: 'ace-icon fa fa-cloud-upload',
        droppable: true,
        thumbnail: 'small',
        preview_error : function(filename, error_code) {
        }
    }).on('change', function(){
    });


</script>
