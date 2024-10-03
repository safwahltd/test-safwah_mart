
<script>

    var warehouse_id = $('#warehouse_id').find('option:selected').val();

    $('#warehouse_id').on('change', function () {
        getEcomAccountsByWarehouse()

        warehouse_id = $(this).find('option:selected').val();

        $('.new-tr').remove();
        $('.first-tr').find('.purchase-detail-id').val('');
        $('.first-tr').find('.product-is-variation').val('false');
        $('.first-tr').find('.products').val('');
        $('.first-tr').find('.products').select2();
        $('.first-tr').find('.unit-measure').val('');
        $('.first-tr').find('.product-variations').val('');
        $('.first-tr').find('.product-variations').select2();
        $('.first-tr').find('.lots').empty().select2();
        $('.first-tr').find('.lots').append(`<option value="" selected>- Select -</option>`).select2();
        $('.first-tr').find('.stock').val('');
        $('.first-tr').find('.purchase-price').val('');
        $('.first-tr').find('.sale-price').val('');
        $('.first-tr').find('.quantity').val('');
        $('.first-tr').find('.purchase-total').val('');
        $('.first-tr').find('.total').val('');
        $('.first-tr').find('.pdt-discount-percent').val('');
        $('.first-tr').find('.pdt-total-discount-amount').val('');


        $('#payment-table .first-tr').find('.ecom-accounts').val('');
        $('#payment-table .first-tr').find('.ecom-accounts').select2();
        $('#payment-table .first-tr').find('.payment-amount').val('');

        $('.select2').select2()

        calculatePaymentAmount()
        calculateTotalCost()
        calculateSubtotal()
        totalDiscountAmount()
    })





    function emptyRow(obj)
    {
        $(obj).closest('tr').find('.product-variations').empty().select2();
        $(obj).closest('tr').find('.product-variations').append(`<option value="" selected>- Select -</option>`).select2();
        $(obj).closest('tr').find('.quantity').val('');
        $(obj).closest('tr').find('.purchase-price').val('');
        $(obj).closest('tr').find('.sale-price').val('');
        $(obj).closest('tr').find('.pdt-total-discount-amount').val('');
        $(obj).closest('tr').find('.total').val('');
        $(obj).closest('tr').find('.purchase-total').val('');
        $(obj).closest('tr').find('.stock').val('');
    }




    function calculateRawTotal(obj)
    {
        let purchasePrice = Number($(obj).closest('tr').find('.purchase-price').val());
        let salePrice = Number($(obj).closest('tr').find('.sale-price').val());
        let quantity = Number($(obj).closest('tr').find('.quantity').val());
        let stock = Number($(obj).closest('tr').find('.stock').val());
        let pdtDiscountPercent = Number($(obj).closest('tr').find('.pdt-discount-percent').val());


        if (quantity > stock) {
            warning('toastr', 'You cannot select more then ' + stock + ' quantity');

            quantity = stock;

            $(obj).closest('tr').find('.quantity').val(quantity.toFixed(2))
        }

        let purchaseTotal = purchasePrice * quantity;
        let total = salePrice * quantity;
        let pdtTotalDiscountAmount = parseFloat(total - (total - ( total * pdtDiscountPercent / 100 )));

        Number($(obj).closest('tr').find('.purchase-total').val(purchaseTotal.toFixed(2)));
        Number($(obj).closest('tr').find('.total').val(total.toFixed(2)));
        Number($(obj).closest('tr').find('.pdt-total-discount-amount').val(pdtTotalDiscountAmount.toFixed(2)));

        calculateTotalCost()
        calculateSubtotal()
        totalDiscountAmount()
    }




    function calculateTotalCost()
    {
        let totalCost = 0;
        $('.purchase-total').each(function () {
            totalCost += Number($(this).val());
        })

        $('#total_cost').val(totalCost.toFixed(2))
    }




    function calculateSubtotal()
    {
        let subtotal = 0;
        $('.total').each(function () {
            subtotal += Number($(this).val());
        })

        $('#subtotal').val(subtotal.toFixed(2))


        calculateAllAmount()
    }




    function totalDiscountAmount()
    {
        let totalDiscountAmount = 0;
        $('.pdt-total-discount-amount').each(function () {
            totalDiscountAmount += Number($(this).val());
        })

        $('#total_discount_amount').val(totalDiscountAmount.toFixed(2))

        calculateDiscountPercent($('#total_discount_amount'))
    }




    function calculateAllAmount()
    {
        let subtotal = Number($('#subtotal').val());
        let totalVatPercent = Number($('#total_vat_percent').val());
        let discountAmount = Number($('#total_discount_amount').val());
        let subtotalWithVat = (subtotal + (subtotal / 100) * totalVatPercent);
        let totalVatAmount = subtotalWithVat - subtotal;
        let payableAmount = Math.ceil(subtotalWithVat)
        let paidAmount = Number($('#paid_amount').val());
        let rounding = payableAmount - subtotalWithVat;

        payableAmount = payableAmount - discountAmount;
        let dueAmount = payableAmount - paidAmount;
        let changeAmount = paidAmount - payableAmount;

        if (payableAmount > paidAmount) {
            changeAmount = 0
        }

        if (changeAmount > 0) {
            dueAmount = 0;
        }

        $('#total_vat_amount').val(totalVatAmount.toFixed(2));
        $('#payable_amount').val(payableAmount.toFixed(2));
        $('#rounding').val(rounding.toFixed(2));
        $('#due_amount').val(dueAmount.toFixed(2));
        $('#change_amount').val(changeAmount.toFixed(2));
    }




    function getProductVariations(obj)
    {
        if (warehouse_id == '') {
            warning('toastr', 'Please Select a Warehouse!');

            $(obj).closest('tr').find('.products').val('');
            $(obj).closest('tr').find('.products').select2();
            return;
        }

        $(obj).closest('tr').find('.pdt-discount-percent').val('');
        $(obj).closest('tr').find('.pdt-total-discount-amount').val('');

        const route = `{{ route('inv.sales.axios.get-product-variations') }}`;

        let _this                   = $(obj).find('option:selected');
        let product_id              = _this.val();
        let category                = _this.data('category');
        let unit_measure            = _this.data('unit-measure');
        let purchase_price          = _this.data('purchase-price');
        let sale_price              = _this.data('sale-price');
        let pdt_discount_percent    = _this.data('sale-discount-percent');

        $(obj).closest('tr').find('.category').val(category);
        $(obj).closest('tr').find('.unit-measure').val(unit_measure);
        $(obj).closest('tr').find('.pdt-discount-percent').val(pdt_discount_percent);

        axios.get(route, {
            params: { product_id : product_id }
        })
        .then(function (response) {
            let data = response.data;

            emptyRow(obj);

            if (data != '') {

                $(obj).closest('tr').find('.product-is-variation').val('true');
                $(obj).closest('tr').find('.product-variations').prop('required', true);
                $(obj).closest('tr').find('.lots').empty().select2();
                $(obj).closest('tr').find('.lots').append(`<option value="" selected>- Select -</option>`).select2();

                data.map(function(productVariation, index) {
                    $(obj).closest('tr').find('.product-variations').append(`<option value="${ productVariation.id }" data-variation-purchase-price="${ productVariation.purchase_price }" data-variation-sale-price="${ productVariation.sale_price }">${ productVariation.name }</option>`).select2();
                })

                checkItemExistOrNot(obj)

            } else {

                getLots(obj, product_id)

                $(obj).closest('tr').find('.purchase-price').val(purchase_price);
                $(obj).closest('tr').find('.sale-price').val(sale_price);
                $(obj).closest('tr').find('.product-variations').empty().select2();
                $(obj).closest('tr').find('.product-variations').append(`<option value="" selected>- Select -</option>`).select2();
                $(obj).closest('tr').find('.product-variations').prop('required', false);

                calculateRawTotal()

                checkItemExistOrNot(obj)
            }
        })
        .catch(function (error) { });
    }
</script>




<script>
    function getLots(obj, product_id, product_variation_id = null)
    {
        const route = `{{ route('inv.sales.axios.get-lots') }}`;

        axios.get(route, {
            params: {
                warehouse_id : warehouse_id,
                product_id : product_id,
                product_variation_id : product_variation_id,
            }
        })
        .then(function (response) {
            let data = response.data;

            if (data != '') {
                $(obj).closest('tr').find('.lots').empty().select2();
                $(obj).closest('tr').find('.lots').append(`<option value="" selected>- Select -</option>`).select2();

                data.map(function(lot, index) {
                    $(obj).closest('tr').find('.lots').append(`<option value="${ lot }">${ lot }</option>`).select2();
                })

            }
        })
        .catch(function (error) { });
    }
</script>









<script>
    function getItemStock(obj)
    {
        const route = `{{ route('inv.sales.axios.get-item-stock') }}`;
        let product_id = $(obj).closest('tr').find('.products').find('option:selected').val();
        let product_variation_id = $(obj).closest('tr').find('.product-variations').find('option:selected').val();
        let lot = $(obj).find('option:selected').val();

        axios.get(route, {
            params: {
                warehouse_id : warehouse_id,
                product_id : product_id,
                product_variation_id : product_variation_id,
                lot : lot,
            }
        })
        .then(function (response) {
            let data = response.data;

            if (data != '') {
                let stock = Number(data);

                $(obj).closest('tr').find('.stock').val(stock.toFixed(2))
            }
        })
        .catch(function (error) { });
    }
</script>




<script>
    function checkItemExistOrNot(obj)
    {
        let productId = $(obj).closest('tr').find('.products').find('option:selected').val();
        let lot = $(obj).closest('tr').find('.lots').find('option:selected').val();
        let variationId = $(obj).closest('tr').find('.product-variations').find('option:selected').val();
        let variationPurchasePrice = Number($(obj).closest('tr').find('.product-variations').find('option:selected').data('variation-purchase-price')).toFixed(2);
        let variationSalePrice = Number($(obj).closest('tr').find('.product-variations').find('option:selected').data('variation-sale-price')).toFixed(2);

        let is_find = 0;

        $('.products').each(function(index) {
            let product_id = $(this).val()
            let lot_numbers = $(this).closest('tr').find('.lots').val();
            let is_variation = $(this).closest('tr').find('.product-is-variation').val();
            let variation_id = $(this).closest('tr').find('.product-variations').val();


            if (is_variation == 'true' && lot == '') {

                getLots(obj, productId, variationId)

                if (isNaN(variationPurchasePrice)) {
                    variationPurchasePrice = '';
                }

                if (isNaN(variationSalePrice)) {
                    variationSalePrice = '';
                }

                $(obj).closest('tr').find('.purchase-price').val(variationPurchasePrice)
                $(obj).closest('tr').find('.sale-price').val(variationSalePrice)
            }


            if (product_id == productId && variationId == variation_id && lot == lot_numbers) {

                is_find += 1;
            }
        })


        if (is_find > 1) {
            warning('toastr', 'Item already exists!');

            $(obj).closest('tr').find('.products').val('');
            $(obj).closest('tr').find('.products').select2();
            $(obj).closest('tr').find('.category').val('');
            $(obj).closest('tr').find('.unit-measure').val('');
            $(obj).closest('tr').find('.lots').empty().select2();
            $(obj).closest('tr').find('.lots').append(`<option value="" selected>- Select -</option>`).select2();
            $(obj).closest('tr').find('.pdt-discount-percent').val('');

            emptyRow(obj)

            $('.select2').select2()

            calculateTotalCost()
            calculateSubtotal()
            totalDiscountAmount()

            return;
        }
    }
</script>




<script>
    $(document).ready(function() {


        $('#sidebar').addClass('menu-min');


        const rowItem = `<tr class="new-tr">
                            <input type="hidden" name="sale_detail_id[]" class="purchase-detail-id" value="">
                            <th width="25%">
                                <input type="hidden" class="product-is-variation" value="false">
                                <select name="product_id[]" id="product_id" class="form-control products select2" onchange="getProductVariations(this)" required>
                                    <option value="" selected>- Select -</option>
                                    @foreach ($products ?? [] as $product)
                                        <option value="{{ $product->id }}"
                                            data-category="{{ optional($product->category)->name }}"
                                            data-unit-measure="{{ optional($product->unitMeasure)->name }}"
                                            data-purchase-price="{{ number_format($product->purchase_price, 2, '.', '') }}"
                                            data-sale-price="{{ number_format($product->sale_price, 2, '.', '') }}"
                                            data-sale-discount-percent="{{ 0 }}"
                                            {{ old('product_id') == $product->id ? 'selected' : '' }}
                                        >{{ $product->name . ' - ' . $product->code }}</option>
                                    @endforeach
                                </select>
                            </th>
                            <th width="7%">
                                <input type="text" name="unit_measure_id[]" id="unit_measure_id" class="form-control unit-measure" readonly>
                            </th>
                            <th width="15%">
                                <select name="product_variation_id[]" id="product_variation_id" class="form-control product-variations select2" onchange="checkItemExistOrNot(this)">
                                    <option value="" selected>- Select -</option>
                                </select>
                            </th>
                            <th width="10%">
                                <select name="lot[]" id="lot" class="form-control lots select2" onchange="checkItemExistOrNot(this), getItemStock(this)">
                                    <option value="" selected>- Select -</option>
                                </select>
                            </th>
                            <th width="10%">
                                <input type="text" name="stock[]" id="stock" class="form-control text-center only-number stock" readonly>
                            </th>
                            <th width="10%">
                                <input type="hidden" name="purchase_price[]" id="purchase_price" class="form-control text-right only-number purchase-price" autocomplete="off" required>
                                <input type="number" name="sale_price[]" id="sale_price" class="form-control text-right only-number sale-price" autocomplete="off" onkeyup="calculateRawTotal(this)" required>
                            </th>
                            <th width="8%">
                                <input type="number" name="quantity[]" id="quantity" class="form-control text-center quantity" autocomplete="off" onkeyup="calculateRawTotal(this)" required>
                            </th>
                            <th width="10%">
                                <input type="hidden" name="purchase_total[]" id="purchase_total" class="form-control purchase-total text-right" readonly>
                                <input type="text" name="total[]" id="total" class="form-control total text-right" readonly>
                                <input type="hidden" name="pdt_discount_percent[]" class="form-control pdt-discount-percent text-right" readonly>
                                <input type="hidden" name="pdt_total_discount_amount[]" class="form-control pdt-total-discount-amount text-right" readonly>
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

            calculateTotalCost()
            calculateSubtotal()
            totalDiscountAmount()

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
    function calculateDiscountAmount(obj)
    {
        let subtotal = $('#subtotal').val();

        let discountPercent = parseFloat($(obj).val());
        let discountAmount = parseFloat(subtotal - (subtotal - ( subtotal * discountPercent / 100 )));

        if (isNaN(discountAmount)) {
            discountAmount = 0;
        }

        $('#total_discount_amount').val(discountAmount.toFixed(2));

        calculateAllAmount()
    }





    /*
     |--------------------------------------------------------------------------
     | CALCULATE DISCOUNT PERCENT
     |--------------------------------------------------------------------------
    */
    function calculateDiscountPercent(obj)
    {
        let subtotal = $('#subtotal').val();

        let discountAmount = parseFloat($(obj).val());
        let discountPercent = (discountAmount / subtotal) * 100;

        if (isNaN(discountPercent)) {
            discountPercent = 0
        }

        $('#total_discount_percent').val(discountPercent.toFixed(2));

        calculateAllAmount()
    }





    /*
     |--------------------------------------------------------------------------
     | ADD CUSTOMER (AXIOS)
     |--------------------------------------------------------------------------
    */
    function addCustomer(obj)
    {
        let _this           = $(obj).closest('#customerAddForm');
        let name            = _this.find('#name').val();
        let phone           = _this.find('#phone').val();
        let email           = _this.find('#email').val();
        let gender          = _this.find('#gender').find('option:selected').val();
        let address         = _this.find('#address').val();
        let is_default      = 0;


        if(_this.find('#is_default').prop("checked") == true){
            is_default = 1
        }
        else if(_this.find('#is_default').prop("checked") == false){
            is_default = 0
        }

        if (phone == '') {
            alert('Customer Phone is required!');
            return;
        }

        if (phone.length != 11) {
            alert('Phone Number must be 11 digits!');
            return;
        }


        const route = `{{ route('inv.sales.axios.create-customer') }}`;

        axios.post(route, {

            name            : name,
            phone           : phone,
            email           : email,
            gender          : gender,
            address         : address,
            is_default      : is_default,
        })
        .then(function (response) {

            $('#customerAddModal').modal('hide');

            appendAndSelectCustomer(response.data);

            _this.find('#name').val('');
            _this.find('#phone').val('');
            _this.find('#email').val('');
            _this.find('#gender').find('option:selected').val('');
            _this.find('#address').val('');
        })
        .catch(function (error) { });
    }





    function appendAndSelectCustomer(response)
    {
        let is_new = response.is_new;
        let data = response.data;

        if (is_new == 'Yes') {

            $('#customer_id').append(`<option value='${ data.id }' selected>${ data.name + ' - ' + data.phone }</option>`);

            success('toastr', 'New Customer has been Create Successfully !')

        } else {

            $("#customer_id option").each(function() {

                if ($(this).val() == data.id) {
                    $("#customer_id option[value='" + data.id + "']").attr('selected', 'selected');
                }
            });

            success('toastr', 'Customer Already Exists !')
        }

        $('.select2').select2();
    }

</script>




<script>

    $('#paid_amount').on('keyup', function () {
        $(this).val('');
    })

    $('#paid_amount').on('focus', function () {
        if (warehouse_id == '') {
            warning('toastr', 'Please Select a Warehouse!');
            return
        }

        $(this).prop('readonly', true);
        $('#payment-table').show()

        $('#payment-table').find('.ecom-accounts').prop('required', true)
        $('#payment-table').find('.payment-amount').prop('required', true)
    })



    const accountRow =  `<tr class="new-tr">
                            <td style="width: 4%"><span class="sn-no">1</span></td>
                            <td style="width: 50%">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <label class="input-group-text">
                                            Account
                                        </label>
                                    </div>
                                    <select name="ecom_account_id[]" class="form-control select2 ecom-accounts" onchange="checkAccountExistOrNot(this)" style="width: 100%">
                                        <option value="" selected>- Select -</option>
                                    </select>
                                </div>
                            </td>

                            <td style="width: 40%">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <label class="input-group-text">
                                            Amount
                                        </label>
                                    </div>
                                    <input type="text" name="payment_amount[]" class="form-control only-number text-right payment-amount" onkeyup="calculatePaymentAmount()" placeholder="Type amount" autocomplete="off">
                                </div>
                            </td>

                            <td class="text-center" style="width: 6%">
                                <div class="btn-group">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-danger" onclick="removeAccount(this)" type="button">
                                        <i class="fas fa-times"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>`;




    function addAccount()
    {
        $('#payment-table').append(accountRow)

        serial()

        getEcomAccountsByWarehouse()

        $('.select2').select2()

        calculatePaymentAmount();
    }



    function removeAccount(obj)
    {
        $(obj).closest("tr").remove();
        serial();
        calculatePaymentAmount();
    }



    function serial()
    {
        $('.sn-no').each(function(index) {
            $(this).text(index + 1)
        })
    }


    function calculatePaymentAmount()
    {
        let totalPaymentAmount = 0;
        $('.payment-amount').each(function () {
            totalPaymentAmount += Number($(this).val());
        })

        $('#total_payment_amount').text(totalPaymentAmount.toFixed(2))
        $('#paid_amount').val(totalPaymentAmount.toFixed(2))

        calculateAllAmount()
    }

    calculatePaymentAmount()


</script>



<script>
    function getEcomAccountsByWarehouse()
    {
        let getEcomAccounts = $('#warehouse_id').find('option:selected').data('ecom-accounts');
        let oldWarehouseId = `{{ old('warehouse_id') }}`;

        if (oldWarehouseId == '') {
            $('.ecom-accounts').empty().select2();
            $('.ecom-accounts').append(`<option value="" selected>- Select -</option>`).select2();

            $.each(getEcomAccounts, function (key, item) {
                $('.ecom-accounts').append(`<option value="${ item.id }">${ item.name } &mdash; ${ item.account_no }</option>`).select2();
            })
        }
    }

    getEcomAccountsByWarehouse()




    function checkAccountExistOrNot(obj)
    {
        let accountId = $(obj).closest('tr').find('.ecom-accounts').find('option:selected').val();

        let is_find = 0;

        $('.ecom-accounts').each(function(index) {
            let account_id = $(this).val()

            if (accountId == account_id) {

               is_find += 1;
            }
        })


        if (is_find > 1) {
            warning('toastr', 'Account already exists!');

            $(obj).closest('tr').find('.ecom-accounts').val('');
            $(obj).closest('tr').find('.ecom-accounts').select2();
            $(obj).closest('tr').find('.payment-amount').val('');

            calculatePaymentAmount()

            return;
        }
    }
</script>
