
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

                checkItemExistOrNot(obj)

            } else {

                checkItemExistOrNot(obj)

                $(obj).closest('tr').find('.purchase-price').val(purchase_price);
                $(obj).closest('tr').find('.product-variations').empty().select2();
                $(obj).closest('tr').find('.product-variations').append(`<option value="" selected>- Select -</option>`).select2();
                $(obj).closest('tr').find('.product-variations').prop('required', false);

            }
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
            let is_variation = $(this).closest('tr').find('.product_is_variation').val();
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


        if (is_find > 1) {
            warning('toastr', 'Item already exists!');

            $(obj).closest('tr').find('.products').val('');
            $(obj).closest('tr').find('.products').select2();
            $(obj).closest('tr').find('.category').val('');
            $(obj).closest('tr').find('.unit-measure').val('');
            emptyVariationQtyComment(obj)

            $('.select2').select2()

            return;
        }
    }
</script>




<script>
    $(document).ready(function() {


        $('#sidebar').addClass('menu-min');


        const rowItem = `<tr>
                            <input type="hidden" name="purchase_detail_id[]" value="">
                            <input type="hidden" class="product_is_variation" value="false">
                            <th width="25%">
                                <select name="product_id[]" id="product_id" class="form-control products select2" data-placeholder="- Select -" onchange="getProductVariations(this)" required>
                                    <option></option>
                                    @foreach ($products ?? [] as $product)
                                        <option value="{{ $product->id }}"
                                            data-category="{{ optional($product->category)->name }}"
                                            data-unit-measure="{{ optional($product->unitMeasure)->name }}"
                                            data-purchase-price="{{ number_format($product->purchase_price, 2, '.', '') }}"
                                        >{{ $product->name . ' - ' . $product->code }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th width="10%">
                                <input type="text" name="category_id[]" id="category_id" class="form-control category" readonly>
                            </th>
                            <th width="10%">
                                <input type="text" name="unit_measure_id[]" id="unit_measure_id" class="form-control unit-measure" readonly>
                            </th>
                            <th width="15%">
                                <select name="product_variation_id[]" id="product_variation_id" class="form-control product-variations select2" onchange="checkItemExistOrNot(this)">
                                    <option value="" selected>- Select -</option>
                                </select>
                            </th>
                            <th width="10%">
                                <input type="text" name="lot[]" id="lot" class="form-control lot" autocomplete="off">
                            </th>
                            <th width="10%">
                                <input type="text" name="purchase_price[]" id="purchase_price" class="form-control text-right only-number purchase-price" autocomplete="off" required>
                            </th>
                            <th width="10%">
                                <input type="number" name="quantity[]" id="quantity" class="form-control text-center quantity" autocomplete="off" required>
                            </th>
                            <th width="10%">
                                <input type="text" name="special_comment[]" id="special_comment" class="form-control special_comment" autocomplete="off">
                            </th>
                            <th width="5%" class="text-center">
                                <button type="submit" class="btn btn-sm btn-danger remove-row" title="Remove"><i class="fa fa-times"></i></button>
                            </th>
                        </tr>`;


        let i = 0

        $("#addrow").on("click", function() {
            $("#purchaseTable").append(rowItem)
            $('.select2').select2();
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
