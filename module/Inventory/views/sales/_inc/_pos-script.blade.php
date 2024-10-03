<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<!-- Toastr -->
<script src="{{ asset('assets/js/toastr.min.js') }}"></script>
<script src="{{ asset('assets/custom_js/message-display.js') }}"></script>




<script>

    $(document).ready(function () {
        searchItem($('#warehouse_id'), '')
    })

    var prevWarehouse = '';
    var thisWarehouse = $('#warehouse_id').find('option:selected').val();

    $('#warehouse_id').on('change', function (e) {

        prevWarehouse = thisWarehouse;
        thisWarehouse = $(this).find('option:selected').val();

        Swal.fire({
            title: 'Are you sure?',
            text: "If you change warehouse it will reset your cart!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ok'
        }).then((result) => {
            if (result.isConfirmed) {
                searchItem($('#warehouse_id'), e)
                $('#t-body').empty();
                calculateAllAmounts()
            } else {
                $("#warehouse_id option[value='" + prevWarehouse + "']").prop("selected", true);
                $("#warehouse_id").select2({ theme: "bootstrap-5" });
            }
        })

    })



    function searchItem(obj, event, page = 1)
    {
        const route = `{{ route('inv.sales.create.pos-sale') }}`;
        let search = $('#search').val() || '';
        let warehouse_id = $('#warehouse_id').find('option:selected').val() || '';
        let category_id = $('#category_id').find('option:selected').val() || '';

        axios.get(route, {
            params: {
                warehouse_id: warehouse_id,
                category_id: category_id,
                search: search,
                is_search: 1,
                page: page
            }
        })
        .then(function (response) {

            let keycode = (event.keyCode ? event.keyCode : event.which);

            if (keycode == 13) {

                event.preventDefault();

                let product = response.data.products.data[0];

                if (product == undefined) {
                    warning('toastr', 'Item Not Found');
                    return;
                }

                let productMeasurement = response.data.productMeasurement;
                let productVariation = response.data.productVariation;

                if (productMeasurement === '' && product.is_variation === 'No') {
                    productMeasurement = product.product_measurements[0] ?? '';
                }

                if (productVariation === '' && product.is_variation === 'Yes') {
                    productVariation = product.product_variations[0] ?? '';
                }

                let productSKU = product.sku;
                let purchasePrice = product.purchase_price;
                let salePrice = product.sale_price;
                let currentStock = product.current_stock;

                let productUnitMeasure = product.sub_text != '' ? product.sub_text + ' ' + product.unit_measure.name : product.unit_measure.name;;
                let measurementTitle = '';
                let measurementSKU = '';
                let measurementValue = '';
                let variationId = '';
                let variationName = '';

                if (productMeasurement !== '' && product.is_variation === 'No') {

                    productUnitMeasure = productMeasurement.title;
                    measurementTitle = productMeasurement.title;
                    measurementSKU = productMeasurement.sku;
                    measurementValue = productMeasurement.value;

                    productSKU = productMeasurement.sku;
                    purchasePrice = purchasePrice - (purchasePrice - ( purchasePrice * (measurementValue * 100) / 100 ));
                    salePrice = salePrice - (salePrice - ( salePrice * (measurementValue * 100) / 100 ));
                }
                else if (productVariation !== '' && product.is_variation === 'Yes') {

                    variationId = productVariation.id
                    variationName = productVariation.name
                    productSKU = productVariation.sku;
                    purchasePrice = productVariation.purchase_price;
                    salePrice = productVariation.sale_price;
                    currentStock = productVariation.current_stock
                }

                let discountPercent = 0;
                let discountPrice = 0;

                if (product.discount != null) {
                    discountPercent = product.discount.discount_percentage;
                    discountPrice = Math.round(getDiscountPrice(salePrice, discountPercent));

                    if (productMeasurement != '') {
                        let itemMeasurementValue = productMeasurement.value * 100;
                        discountPrice = Math.round(getDiscountPrice(salePrice, discountPercent));
                    }
                } else if(product.discount_percentage > 0) {
                    discountPercent = product.discount_percentage;
                    discountPrice = Math.round(getDiscountPrice(salePrice, discountPercent));

                    if (productMeasurement != '') {
                        let itemMeasurementValue = productMeasurement.value * 100;
                        discountPrice = Math.round(getDiscountPrice(salePrice, discountPercent));
                    }
                }


                let vatPercent = product.vat ?? 0;

                if(product.vat != null && product.vat_type == 'Flat') {
                    let price = discountPrice != 0 ? discountPrice : salePrice;
                    vatPercent = (product.vat / price) * 100;
                }



                let is_find = 0;

                $('.product-sku').each(function(index) {
                    let sku = $(this).val();

                    if (productSKU == sku) {
                        is_find += 1;
                    }
                })

                if (is_find > 0) {

                    $('.product-sku').each(function(index) {
                        let sku = $(this).val();

                        if (productSKU == sku) {
                            $(this).closest('tr').find('.product-quantity').focus();

                            itemQuantity = Number($(this).closest('tr').find('.p-qty').val()) + 1;
                            let itemCurrentStock = Number($(this).closest('tr').find('.product-current-stock').val());

                            if (itemQuantity > itemCurrentStock) {
                                warning('toastr', 'Stock limit is over');
                                return;
                            }


                            let itemDiscountPrice = Number($(this).closest('tr').find('.product-discount-price').val());
                            let itemSalePrice = Number($(this).closest('tr').find('.product-sale-price').val());
                            let itemVatPercent = Number($(this).closest('tr').find('.product-vat-percent').val());

                            let prevLineTotal = Number($(this).closest('tr').find('.line-total').text());
                            let prevLineTotalVatAmount = Number($(this).closest('tr').find('.line-total-vat-amount').val());
                            let prevLineTotalDiscountAmount = Number($(this).closest('tr').find('.line-total-discount-amount').val());

                            let lineTotal = Number((itemDiscountPrice > 0 ? itemDiscountPrice * 1 : itemSalePrice * 1) + prevLineTotal);
                            let lineTotalVatAmount = Number((prevLineTotal - (prevLineTotal - ( prevLineTotal * itemVatPercent / 100 ))) + prevLineTotalVatAmount) ;
                            let lineTotalDiscountAmount = itemDiscountPrice > 0 ? Number(((itemSalePrice - itemDiscountPrice) * 1) + prevLineTotalDiscountAmount) : 0;


                            $(this).closest('tr').find('.product-quantity').val(itemQuantity);
                            $(this).closest('tr').find('.line-total').text(lineTotal);
                            $(this).closest('tr').find('.line-total-vat-amount').val(lineTotalVatAmount);
                            $(this).closest('tr').find('.line-total-discount-amount').val(lineTotalDiscountAmount);

                            info('toastr', 'Update Quantity');

                            calculateAllAmounts()

                            $(obj).val('');
                        }
                    })

                    return;
                }

                appendItem(product.id, product.name, variationId, variationName, measurementTitle, measurementSKU, measurementValue, productSKU, purchasePrice, salePrice, discountPrice, vatPercent, discountPercent, 1, productUnitMeasure, currentStock)

                if (is_find == 0) {
                    success('toastr', 'Item Added');
                }

                calculateAllAmounts()

                $(obj).val('');
            }


            $('.product-row').html(response.data.html);
        })
        .catch(function (error) { });
    }

</script>




<script>
    function getDiscountPrice(salePrice, discountPercent)
    {
        return Math.round(salePrice - (salePrice * discountPercent / 100 ) - 0.12);
    }
</script>





<script>
    function addItem(obj)
    {
        let itemId                  = $(obj).closest('.product').find('.item-id').val();
        let itemName                = $(obj).closest('.product').find('.item-name').val();
        let itemSKU                 = $(obj).closest('.product').find('.item-sku').val();
        let itemPurchasePrice       = $(obj).closest('.product').find('.item-purchase-price').val();
        let itemSalePrice           = $(obj).closest('.product').find('.item-sale-price').val();
        let itemDiscountPrice       = $(obj).closest('.product').find('.item-discount-price').val();
        let itemVatPercent          = $(obj).closest('.product').find('.item-vat-percent').val();
        let itemDiscountPercent     = $(obj).closest('.product').find('.item-discount-percent').val();
        let itemUnit                = $(obj).closest('.product').find('.item-unit').val();
        let itemSubText             = $(obj).closest('.product').find('.item-sub-text').val();
        let itemIsVariation         = $(obj).closest('.product').find('.item-is-variation').val();
        let itemCurrentStock        = $(obj).closest('.product').find('.item-current-stock').val();
        let itemVariationName       = '';
        let itemIsMeasurement       = $(obj).closest('.product').find('.item-is-measurement').val();
        let itemMeasurementTitle    = '';
        let itemMeasurementSKU      = '';
        let itemMeasurementValue    = '';
        let itemQuantity            = 1;


        let productUnitMeasure;

        if (itemIsMeasurement == 'Yes') {
            productUnitMeasure = itemMeasurementTitle
        } else {
            productUnitMeasure = itemSubText != '' ? itemSubText + '  ' + itemUnit : itemUnit
        }

        let is_find = 0;

        $('.product-sku').each(function(index) {
            let sku = $(this).val();

            if (itemSKU == sku) {
                is_find += 1;
            }
        })


        if (is_find > 0) {

            $('.product-sku').each(function(index) {
                let sku = $(this).val();

                if (itemSKU == sku) {
                    $(this).closest('tr').find('.product-quantity').focus();

                    itemQuantity = Number($(this).closest('tr').find('.p-qty').val()) + 1;
                    let itemCurrentStock = Number($(this).closest('tr').find('.product-current-stock').val());

                    if (itemQuantity > itemCurrentStock) {
                        warning('toastr', 'Stock limit is over');
                        return;
                    }

                    let itemDiscountPrice = Number($(this).closest('tr').find('.product-discount-price').val());
                    let itemSalePrice = Number($(this).closest('tr').find('.product-sale-price').val());
                    let itemVatPercent = Number($(this).closest('tr').find('.product-vat-percent').val());

                    let prevLineTotal = Number($(this).closest('tr').find('.line-total').text());
                    let prevLineTotalVatAmount = Number($(this).closest('tr').find('.line-total-vat-amount').val());
                    let prevLineTotalDiscountAmount = Number($(this).closest('tr').find('.line-total-discount-amount').val());

                    let lineTotal = Number((itemDiscountPrice > 0 ? itemDiscountPrice * itemQuantity : itemSalePrice * itemQuantity) + prevLineTotal);
                    let lineTotalVatAmount = Number((prevLineTotal - (prevLineTotal - ( prevLineTotal * itemVatPercent / 100 ))) + prevLineTotalVatAmount) ;
                    let lineTotalDiscountAmount = itemDiscountPrice > 0 ? Number(((itemSalePrice - itemDiscountPrice) * itemQuantity) + prevLineTotalDiscountAmount) : 0;


                    $(this).closest('tr').find('.product-quantity').val(itemQuantity);
                    $(this).closest('tr').find('.line-total').text(lineTotal);
                    $(this).closest('tr').find('.line-total-vat-amount').val(lineTotalVatAmount);
                    $(this).closest('tr').find('.line-total-discount-amount').val(lineTotalDiscountAmount);

                    info('toastr', 'Update Quantity');

                    calculateAllAmounts()

                    $(obj).val('');
                }
            })

            return;
        }

        appendItem(itemId, itemName, '', '', '', '', '', itemSKU, itemPurchasePrice, itemSalePrice, itemDiscountPrice, itemVatPercent, itemDiscountPercent, itemQuantity, productUnitMeasure, itemCurrentStock);

        calculateAllAmounts();

        success('toastr', 'Item Added');
    }


</script>





<script>
    function appendItem(itemId, itemName, itemVariationId, itemVariationName, itemMeasurementTitle, itemMeasurementSKU, itemMeasurementValue, itemSKU, itemPurchasePrice, itemSalePrice, itemDiscountPrice, itemVatPercent, itemDiscountPercent, itemQuantity, itemUnitMeasure, itemCurrentStock)
    {

        itemDiscountPrice    = Number(itemDiscountPrice);
        itemDiscountPrice    = Number(itemDiscountPrice);

        let lineTotal               = itemDiscountPrice > 0 ? itemDiscountPrice * itemQuantity : itemSalePrice * itemQuantity;
        let lineTotalVatAmount      = Number(lineTotal - (lineTotal - ( lineTotal * itemVatPercent / 100 ))) ?? 0;
        let lineTotalDiscountAmount = itemDiscountPrice > 0 ? Number((itemSalePrice - itemDiscountPrice) * itemQuantity) : 0;

        $('#t-body').append(`
            <tr class="align-middle">
                <td style="display: none">
                    <input type="text" name="product_id[]" class="product-id" value="${ itemId }">
                    <input type="text" name="product_name[]" class="product-name" value="${ itemName }">
                    <input type="text" name="product_variation_id[]" class="product-variation-id" value="${ itemVariationId }">
                    <input type="text" name="product_variation_name[]" class="product-variation-name" value="${ itemVariationName }">
                    <input type="text" name="measurement_title[]" class="measurement-title" value="${ itemMeasurementTitle }">
                    <input type="text" name="measurement_sku[]" class="measurement-sku" value="${ itemMeasurementSKU }">
                    <input type="text" name="measurement_value[]" class="measurement-value" value="${ itemMeasurementValue }">
                    <input type="text" name="lot[]" value="">
                    <input type="text" name="unit_measure[]" value="${ itemUnitMeasure }">
                    <input type="text" name="product_sku[]" class="product-sku" value="${ itemSKU }">
                    <input type="text" name="purchase_price[]" class="product-purchase-price" value="${ itemPurchasePrice }">
                    <input type="text" name="sale_price[]" class="product-sale-price" value="${ itemSalePrice }">
                    <input type="text" name="discount_price[]" class="product-discount-price" value="${ itemDiscountPrice }">
                    <input type="text" name="vat_percent[]" class="product-vat-percent" value="${ itemVatPercent }">
                    <input type="text" name="discount_percent[]" class="product-discount-percent" value="${ itemDiscountPercent }">
                    <input type="text" name="quantity[]" class="product-quantity p-qty" value="${ itemQuantity }">
                    <input type="text" name="product_current_stock[]" class="product-current-stock" value="${ itemCurrentStock }">
                    <input type="text" name="line_total[]" class="product-line-total">
                </td>
                <td>${ itemName } ${ itemVariationName != '' ? '(' + itemVariationName + ')' : '' }</td>
                <td>${ itemUnitMeasure }</td>
                <td class="text-end">${ itemDiscountPrice > 0 ? itemDiscountPrice : itemSalePrice }</td>
                <td>
                    <div class="input-group input-group-sm">
                        <span class="decrement input-group-text bg-light" onclick="quantityDecrement(this)"><i class="fas fa-minus"></i></span>
                        <input type="text" class="form-control form-control-sm text-center fw-bold product-quantity bg-light" readonly value="${ itemQuantity }">
                        <span class="increment input-group-text bg-light" onclick="quantityIncrement(this)"><i class="fas fa-plus"></i></span>
                    </div>
                </td>
                <td class="text-end">
                    <input type="hidden" name="vat_amount[]" class="line-total-vat-amount form-control" value="${ lineTotalVatAmount }">
                    <input type="hidden" name="discount_amount[]" class="line-total-discount-amount form-control" value="${ lineTotalDiscountAmount }">
                    <span class="line-total">${ lineTotal }</span>
                </td>

                <td><a href="javascript:void(0)" class="text-danger" onclick="removeItem(this)"><i class="fas fa-times"></i></a></td>
            </tr>
        `);
        success('toastr', 'Item Added');
        calculateAllAmounts();
    }
</script>





<script>
    function removeItem(obj)
    {
        $(obj).closest("tr").remove();
        calculateAllAmounts()
    }
</script>





<script>
    function quantityIncrement(obj)
    {
        let checkMeasurementValue = Number($(obj).closest('tr').find('.measurement-value').val());
        let currentStock     = Number($(obj).closest('tr').find('.product-current-stock').val());
        let itemId           = $(obj).closest('tr').find('.product-id').val();
        let totalQuantity    = 0;
        if(checkMeasurementValue != ''){
            $('.product-id').each(function () {
                if($(this).val() == itemId){

                    let quantity         = Number($(this).closest('tr').find('.product-quantity').val());
                    let MeasurementValue = Number($(this).closest('tr').find('.measurement-value').val());

                    totalQuantity  += quantity * MeasurementValue;
                }

            })
            totalQuantity += checkMeasurementValue;

            if(totalQuantity <= currentStock){
                itemQuantity = Number($(obj).closest('tr').find('.product-quantity').val()) + 1;
                calculateLineTotal(obj, itemQuantity)
            }else{
                warning('toastr', 'Stock limit is over');
            }
        }else{
            itemQuantity = Number($(obj).closest('tr').find('.product-quantity').val()) + 1;
            calculateLineTotal(obj, itemQuantity)
        }




    }


    function quantityDecrement(obj)
    {
        itemQuantity = Number($(obj).closest('tr').find('.product-quantity').val()) - 1;
        calculateLineTotal(obj, itemQuantity)
    }


    function calculateLineTotal(obj, itemQuantity)
    {
        let itemCurrentStock  = Number($(obj).closest('tr').find('.product-current-stock').val());
        let itemSalePrice     = Number($(obj).closest('tr').find('.product-sale-price').val());
        let itemDiscountPrice = Number($(obj).closest('tr').find('.product-discount-price').val());
        let itemVatPercent    = Number($(obj).closest('tr').find('.product-vat-percent').val());

        if (itemQuantity > itemCurrentStock) {
            warning('toastr', 'Stock limit is over');
            return;
        } else if (itemQuantity == 0) {
            warning('toastr', 'Quantity must be at least 1 to be required');
            return;
        }

        let lineTotal = Number(itemDiscountPrice > 0 ? itemDiscountPrice * itemQuantity : itemSalePrice * itemQuantity);
        let lineTotalVatAmount = Number(lineTotal - (lineTotal - ( lineTotal * itemVatPercent / 100 ))) ;
        let lineTotalDiscountAmount = itemDiscountPrice > 0 ? Number(itemSalePrice - itemDiscountPrice) : 0;



        $(obj).closest('tr').find('.product-quantity').val(itemQuantity);
        $(obj).closest('tr').find('.line-total').text(lineTotal);
        $(obj).closest('tr').find('.product-line-total').val(lineTotal);
        $(obj).closest('tr').find('.line-total-vat-amount').val(lineTotalVatAmount);
        $(obj).closest('tr').find('.line-total-discount-amount').val(lineTotalDiscountAmount);

        calculateAllAmounts()
    }


    function calculateSubtotal()
    {
        let subtotal = 0;

        $('.line-total').each(function () {
            subtotal += Number($(this).text());
        })

        $('#showInvoiceSubtotal').text(subtotal.toFixed(2));
        $('#invoiceSubtotal').val(subtotal.toFixed(2));
    }


    function calculateTotalCost()
    {
        let totalCost = 0;

        $('.product-purchase-price').each(function () {
            totalCost += Number($(this).val()) * Number($(this).closest('tr').find('.p-qty').val());
        })

        $('#invoiceTotalCost').val(totalCost.toFixed(2));
    }


    function calculateTotalQuantity()
    {
        let totalQuantity = 0;

        $('.p-qty').each(function () {
            totalQuantity += Number($(this).val());
        })

        $('#invoiceTotalQuantity').val(totalQuantity.toFixed(2));
    }

    function calculateTotalVat()
    {
        let totalVatAmount = 0;

        $('.line-total-vat-amount').each(function () {
            totalVatAmount += Number($(this).val());
        })

        $('#showInvoiceTotalVatAmount').text(totalVatAmount.toFixed(2));
        $('#invoiceTotalVatAmount').val(totalVatAmount.toFixed(2));



        let totalVatPercent = 0;
        let subtotal        = $('#invoiceSubtotal').val();

        totalVatPercent     = (100 * totalVatAmount) / subtotal;

        // $('.product-vat-percent').each(function () {
        //     totalVatPercent += Number($(this).val());
        // })

        $('#invoiceTotalVatPercent').val(totalVatPercent.toFixed(2));
    }

    function calculateTotalDiscount()
    {
        let totalDiscountAmount = 0;
        $('.line-total-discount-amount').each(function () {
            totalDiscountAmount += Number($(this).val() * $(this).closest('tr').find('.product-quantity').val());
        })
        $('#showInvoiceTotalDiscountAmount').text(totalDiscountAmount.toFixed(2));
        $('#invoiceTotalDiscountAmount').val(totalDiscountAmount.toFixed(2));


        let totalDiscountPercent = 0;

        $('.product-discount-percent').each(function () {
            totalDiscountPercent += Number($(this).val());
        })
        $('#invoiceTotalDiscountPercent').val(totalDiscountPercent.toFixed(2));
    }


    function calculateRounding()
    {
        let subtotal = Number($('#showInvoiceSubtotal').text());
        let vatAmount = Number($('#showInvoiceTotalVatAmount').text());
        let discountAmount = Number($('#showInvoiceTotalDiscountAmount').text());
        let subtotalWithVat = subtotal + vatAmount - discountAmount;
        let rounding = Math.ceil(subtotalWithVat) - subtotalWithVat;

        $('#showInvoiceRounding').text(rounding.toFixed(2));
        $('#invoiceRounding').val(rounding.toFixed(2));
    }


    function calculatePayable()
    {
        let subtotal = Number($('#showInvoiceSubtotal').text());
        let vatAmount = Number($('#showInvoiceTotalVatAmount').text());
        let discountAmount = Number($('#showInvoiceTotalDiscountAmount').text());
        let payable = subtotal + vatAmount;

        $('#showInvoiceSubtotal').text(subtotal + discountAmount);
        $('#invoiceSubtotal').val(subtotal + discountAmount);


        $('#showInvoicePayable').text(payable.toFixed(2));
        $('#invoicePayable').val(payable.toFixed(2));

        $('#invoicePayableModal').text(payable.toFixed(2));
    }


    function calculatePaid(obj)
    {
        let type = $(obj).data('type');

        let pay = Number($(obj).closest('.modal').find('#pay').text());

        if (type == 'cancel') {
            $(obj).closest('.modal').find('#pay').text(0)
            pay = 0;
        }

        $('#showInvoicePaidAmount').text(pay.toFixed(2));
        $('#invoicePaidAmount').val(pay.toFixed(2));

        calculateDueAndChangeAmount()
    }


    function calculateDueAndChangeAmount()
    {
        let payableAmount = Number($('#showInvoicePayable').text());
        let paidAmount = Number($('#showInvoicePaidAmount').text());
        let dueAmount = payableAmount - paidAmount;
        let changeAmount = paidAmount - payableAmount;

        if (payableAmount > paidAmount) {
            changeAmount = 0
        }

        if (changeAmount > 0) {
            dueAmount = 0;
        }

        $('#showInvoiceDueAmount').text(dueAmount.toFixed(2));
        $('#invoiceDueAmount').val(dueAmount.toFixed(2));

        $('#showInvoiceChangeAmount').text(changeAmount.toFixed(2));
        $('#invoiceChangeAmount').val(changeAmount.toFixed(2));
    }
</script>






<script>
    $(document).ready(function () {

        $('.datepicker').datepicker({ format: 'yyyy-mm-dd' });

        $('.select2').each(function () {
            $(this).select2({
                theme: 'bootstrap-5',
                dropdownParent: $(this).parent(),
            });
        });
    });
</script>





<script>
    function confirmSale() {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Sale!'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Success!',
                    'Sale Successfully.',
                    'success'
                )
            }
        })
    }
</script>





<script>
    $(document).on('click', '#addCustomer', function () {
        $('.payment-info').hide();
        $('.customer-info').hide();
        $('#customerAddForm').show();
    })


    $(document).on('click', '.back-btn', function () {
        $('.payment-info').show();
        $('.customer-info').show();
        $('#customerAddForm').hide();
        $('#paymentAddDiv').hide();
    })


    $(document).on('click', '#invPaid', function () {
        $('.payment-info').hide();
        $('.customer-info').hide();
        $('#paymentAddDiv').show();
    })
</script>





<script>

    function getEcomAccountsByWarehouse()
    {
        let getEcomAccounts = $('#warehouse_id').find('option:selected').data('ecom-accounts');


        $('.ecom-accounts').empty();
        $('.ecom-accounts').append(`<option value="" selected>- Select -</option>`);

        $.each(getEcomAccounts, function (key, item) {
            $('.ecom-accounts').append(`<option value="${ item.id }">${ item.name } &mdash; ${ item.account_no }</option>`);
        })
    }

    getEcomAccountsByWarehouse()


    let account_row  = `<tr>
                            <td style="width: 54%">
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-credit-card"></i></span>
                                    <select class="form-control ecom-accounts" name="ecom_account_id[]">
                                        <option value="" selected>All Account</option>
                                    </select>
                                </div>
                            </td>

                            <td style="width: 40%">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-money-bill"></i>
                                    </span>
                                    <input type="text" name="payment_amount[]" class="form-control only-number text-center payment-amount" onkeyup="calculatePaymentAmount()" placeholder="Type amount" autocomplete="off">
                                </div>
                            </td>

                            <td class="text-center" style="width: 6%">
                                <a href="javascript:void(0)" class="btn btn-info rounded-0" onclick="addAccount()" type="button">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </td>
                        </tr>`;


    function addAccount()
    {
        $('#payment-table').append(account_row)

        getEcomAccountsByWarehouse()
    }


    function calculatePaymentAmount()
    {
        let totalPaymentAmount = 0;
        $('.payment-amount').each(function () {
            totalPaymentAmount += Number($(this).val());
        })

        $('#totalPay').text(totalPaymentAmount.toFixed(2))
        $('#invPaid').val(totalPaymentAmount.toFixed(2))

        calculateDueAndChangeAmount()
    }




    function calculateAllAmounts()
    {
        calculateSubtotal()
        calculateTotalCost()
        calculateTotalQuantity()
        calculateTotalVat()
        calculateTotalDiscount()
        calculateRounding()
        calculatePayable()
        calculateDueAndChangeAmount()

        let count = 0;
        $('.product-id').each(function () {
            count = count + 1;
        })

        if (count > 0) {
            $('#emptycart').hide();
        } else {
            $('#emptycart').show();
        }
    }




    $(document).on('click', '#submitPOSSaleForm', function (e) {
        e.preventDefault();

        let customer_id = $('#customer_id').find('option:selected').val();


        if (customer_id == '') {
            warning('toastr', 'Please Select a Customer First!');

            return;
        }

        if (Number($('#showInvoiceTotalDiscountAmount').text()) > Number($('#showInvoicePayable').text())) {
            warning('toastr', 'Discount is greater than Payable Amount!');

            return;
        }

        if (Number($('#showInvoiceTotalVatAmount').text()) > Number($('#showInvoiceSubtotal').text())) {
            warning('toastr', 'VAT is greater than Subtotal!');

            return;
        }

        if ($('.product-id').length == 0) {
            warning('toastr', 'Cart is empty! Please add product first.');

            return;
        }

        $('#posSaleForm').submit();
    })








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


        if (phone == '') {
            warning('toastr', 'Customer Phone is required!');
            return;
        }

        if (phone.length != 11) {
            warning('toastr', 'Phone Number must be 11 digits!');
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

            $('#posCustomerAddModal').modal('hide');

            appendAndSelectCustomer(response.data);

            _this.find('#name').val('');
            _this.find('#phone').val('');
            _this.find('#email').val('');
            _this.find('#gender').find('option:selected').val('');
            _this.find('#address').val('');
        })
        .catch(function (error) {
            warning('Customer not add')
        });
    }





    function appendAndSelectCustomer(response)
    {
        let is_new = response.is_new;
        let data = response.data;
        let status = response.status;

        if (is_new == 'Yes') {

            $('#customer_id').append(`<option value='${ data.id }' selected>${ data.name + ' - ' + data.mobile }</option>`);
            $('#customerId').append(`<option value='${ data.id }' data-phone='${ data.mobile }' data-email='${ data.email }' selected>${ data.name }</option>`);

            Swal.fire(
                'Success',
                'Customer create successfully',
                'success'
            );

            success('toastr', 'Customer create successfully');

        } else if (status == 0) {

            warning('toastr', 'Phone or Email already exists in user');

        } else {

            $("#customer_id option").each(function() {

                if ($(this).val() == data.id) {
                    $("#customer_id option[value='" + data.id + "']").attr('selected', 'selected');
                }
            });

            Swal.fire(
                'Success',
                'Customer already exists',
                'info'
            );

            info('toastr', 'Customer already exists');
        }

        setCustomerInfo(data.name, data.phone, data.email, data.address);

        $('.select2').select2({ theme: "bootstrap-5" });
    }

    $(document).on('click', '.page-link', function(event){
        event.preventDefault();
        let page = $(this).attr('href').split('page=')[1];
        searchItem('', '', page)
    });




</script>





<script>
    function appendMeaurementToModal1(product){
        let tr = "";

        $.each(product.product_measurements, function(key, value) {
            console.log(value.title);
        });
    }



    /*--------- VARIATION MODAL ---------*/

    function appendVariationToModal(product){
        let totalMeasurementCount   = Object.keys(product.product_variations).length;

        let itemDiscountPrice       = '';
        let itemDiscountPercent     = 0;
        let itemQuantity            = 1;
        let itemIsMeasurement       = 'No';
        let productUnitMeasure      = '';

        if(product.product_measurements != ''){
            productUnitMeasure      = product.product_measurements[0].title;
        }else{
            productUnitMeasure = product.sub_text != '' ? product.sub_text + '  ' + product.unit_measure.name : product.unit_measure.name;
        }




        let tr = "";

        $('#variationTableBody').html("");

        if(totalMeasurementCount > 1){
            $('#variationModal').show();

            $.each(product.product_variations, function(key,product_variation) {

                let buttonStyle   = '';
                let quantityStyle = 'display:none';
                let baseQuantity  = 1;


                $('.product-variation-id').each(function(index) {
                        let variation_id = $(this).val();

                        if (product_variation.id == variation_id) {
                            let quantity  = $(this).closest('tr').find('.product-quantity').val();
                            quantityStyle = '';
                            buttonStyle   = 'display:none';
                            baseQuantity  = quantity;
                        }
                });

                itemDiscountPrice = '';
                if(product.discount != null){
                    itemDiscountPercent = product.discount.discount_percentage;

                    itemDiscountPrice =  product_variation.sale_price - ((product_variation.sale_price * product.discount.discount_percentage) / 100);
                } else if(product.discount_percentage > 0) {

                    itemDiscountPercent = product.discount_percentage;

                    itemDiscountPrice =  product_variation.sale_price - ((product_variation.sale_price * product.discount_percentage) / 100);
                }
                let salePrice          = product_variation.sale_price;
                tr += `<tr>
                            <td class="text-center">${ product_variation.name }</td>
                            <td class="text-center">${ product_variation.sale_price }</td>
                            <td>
                                <input type="hidden" class="form-control form-control-sm text-center fw-bold product-modal-current-stock bg-light" readonly value="${ product_variation.current_stock }">

                                <div class="input-group input-group-sm item-measurement-quantity" style="${ quantityStyle }">
                                    <span class="decrement input-group-text bg-light" onclick="quantityDecrementToItemMeasurement('${ product.id }', '${ product.name }', '${ product_variation.id }', '${ product_variation.name }', '', '', '', '${ product.sku }', '${ product_variation.purchase_price }', '${ salePrice }', '${ itemDiscountPrice }', '${ product.vat }', '${ itemDiscountPercent }', '${ itemQuantity }', '${ productUnitMeasure }', '${ product_variation.current_stock }', this)"><i class="fas fa-minus"></i></span>
                                    <input type="text" class="form-control form-control-sm text-center fw-bold product-quantity bg-light" readonly value="${ baseQuantity }">
                                    <span class="increment input-group-text bg-light" onclick="quantityIncrementToItemVariation('${ product.id }', '${ product.name }', '${ product_variation.id }', '${ product_variation.name }', '', '', '', '${ product.sku }', '${ product_variation.purchase_price }', '${ salePrice }', '${ itemDiscountPrice }', '${ product.vat }', '${ itemDiscountPercent }', '${ itemQuantity }', '${ productUnitMeasure }', '${ product_variation.current_stock }', this)"><i class="fas fa-plus"></i></span>
                                </div>
                                <button type="button" style="${ buttonStyle }"  class="btn btn-success add-item-measurement" onclick="addItemMeasurement('${ product.id }', '${ product.name }', '${ product_variation.id }', '${ product_variation.name }', '', '', '', '${ product.sku }', '${ product_variation.purchase_price }', '${ salePrice }', '${ itemDiscountPrice }', '${ product.vat }', '${ itemDiscountPercent }', '${ itemQuantity }', '${ productUnitMeasure }', '${ product_variation.current_stock }', this)">Add Now</button>

                            </td>
                        </tr>`;
            });

            $('#variationTableBody').append(tr);
        }else{

            let product_variation = product.product_variations[0];

            itemDiscountPrice = '';
            if(product.discount != null){
                itemDiscountPercent = product.discount.discount_percentage;

                itemDiscountPrice =  product_variation.sale_price - ((product_variation.sale_price * product.discount.discount_percentage) / 100);
            } else if(product.discount_percentage > 0) {

                itemDiscountPercent = product.discount_percentage;

                itemDiscountPrice =  product_variation.sale_price - ((product_variation.sale_price * product.discount_percentage) / 100);
            }
            let salePrice          = product_variation.sale_price;

            addItemMeasurementByCheck(product.id, product.name, product_variation.id, product_variation.name, '', '' , '' , product.sku , product.purchase_price ,salePrice , itemDiscountPrice, product.vat, itemDiscountPercent, itemQuantity, productUnitMeasure , product.current_stock , 0)


        }
    }



    /*--------- MEASUREMENT MODAL ---------*/
    function appendMeaurementToModal(product){

        let totalMeasurementCount   = Object.keys(product.product_measurements).length;

        let itemDiscountPrice       = '';
        let itemDiscountPercent     = 0;
        let itemQuantity            = 1;
        let itemIsMeasurement       = 'Yes';

        let tr = "";

        if(totalMeasurementCount >1){
            $('#measurementTableBody').html("");
            $('#measurementModal').show();
            $.each(product.product_measurements, function(key, product_measurement) {
                let buttonStyle   = '';
                let quantityStyle = 'display:none';
                let baseQuantity  = 1;

                $('.measurement-sku').each(function(index) {

                        let sku = $(this).val();

                        if (product_measurement.sku == sku) {
                            let quantity  = $(this).closest('tr').find('.product-quantity').val();
                            quantityStyle = '';
                            buttonStyle   = 'display:none';
                            baseQuantity  = quantity;
                        }
                });


                itemDiscountPrice = '';
                if(product.discount != null){
                    itemDiscountPercent = product.discount.discount_percentage;

                    itemDiscountPrice =  (product.sale_price * product_measurement.value) - (((product.sale_price * product_measurement.value) * product.discount.discount_percentage) / 100);
                } else if(product.discount_percentage > 0) {

                    itemDiscountPercent = product.discount_percentage;

                    itemDiscountPrice =  (product.sale_price * product_measurement.value) - (((product.sale_price * product_measurement.value) * product.discount_percentage) / 100);
                }
                let productUnitMeasure = product_measurement.title;
                let salePrice          = product.sale_price * product_measurement.value;
                tr += `<tr>
                            <td class="text-center">${ product_measurement.title }</td>
                            <td class="text-center">${ product.sale_price * product_measurement.value }</td>
                            <td>
                                <div class="input-group input-group-sm item-measurement-quantity" style="${ quantityStyle }">
                                    <span class="decrement input-group-text bg-light" onclick="quantityDecrementToItemMeasurement('${ product.id }', '${ product.name }', '', '', '${ product_measurement.title }', '${ product_measurement.sku }', '${ product_measurement.value }', '${ product.sku }', '${ product.purchase_price }', '${ salePrice }', '${ itemDiscountPrice }', '${ product.vat }', '${ itemDiscountPercent }', '${ itemQuantity }', '${ productUnitMeasure }', '${ product.current_stock }', this)"><i class="fas fa-minus"></i></span>
                                    <input type="text" class="form-control form-control-sm text-center fw-bold product-quantity bg-light" readonly value="${ baseQuantity }">
                                    <span class="increment input-group-text bg-light" onclick="quantityIncrementToItemMeasurement('${ product.id }', '${ product.name }', '', '', '${ product_measurement.title }', '${ product_measurement.sku }', '${ product_measurement.value }', '${ product.sku }', '${ product.purchase_price }', '${ salePrice }', '${ itemDiscountPrice }', '${ product.vat }', '${ itemDiscountPercent }', '${ itemQuantity }', '${ productUnitMeasure }', '${ product.current_stock }', this)"><i class="fas fa-plus"></i></span>
                                </div>
                                <button type="button" style="${ buttonStyle }"  class="btn btn-success add-item-measurement" onclick="addItemMeasurementByCheck('${ product.id }', '${ product.name }', '', '', '${ product_measurement.title }', '${ product_measurement.sku }', '${ product_measurement.value }', '${ product.sku }', '${ product.purchase_price }', '${ salePrice }', '${ itemDiscountPrice }', '${ product.vat }', '${ itemDiscountPercent }', '${ itemQuantity }', '${ productUnitMeasure }', '${ product.current_stock }', this)">Add Now</button>

                            </td>
                        </tr>`;
            });


            $('#measurementTableBody').append(tr);


        }else{

            let product_measurement = product.product_measurements[0];

            itemDiscountPrice = '';
                if(product.discount != null){
                    itemDiscountPercent = product.discount.discount_percentage;

                    itemDiscountPrice =  (product.sale_price * product_measurement.value) - (((product.sale_price * product_measurement.value) * product.discount.discount_percentage) / 100);
                } else if(product.discount_percentage > 0) {

                    itemDiscountPercent = product.discount_percentage;

                    itemDiscountPrice =  (product.sale_price * product_measurement.value) - (((product.sale_price * product_measurement.value) * product.discount_percentage) / 100);
                }
                let productUnitMeasure = product_measurement.title;
                let salePrice          = product.sale_price * product_measurement.value;


            addItemMeasurementByCheck(product.id, product.name, '', '', product_measurement.title, product_measurement.sku , product_measurement.value , product.sku , product.purchase_price ,salePrice , itemDiscountPrice, product.vat, itemDiscountPercent, itemQuantity, productUnitMeasure , product.current_stock , 0)
        }


    }



    function addItemMeasurementByCheck(itemId, itemName, itemVariationId, itemVariationName, itemMeasurementTitle, itemMeasurementSKU, itemMeasurementValue, itemSKU, itemPurchasePrice, itemSalePrice, itemDiscountPrice, itemVatPercent, itemDiscountPercent, itemQuantity, itemUnitMeasure, itemCurrentStock, obj){
        let totalQuantity = 0;
        $('.product-id').each(function () {
            if($(this).val() == itemId){
                let quantity         = Number($(this).closest('tr').find('.product-quantity').val());
                let MeasurementValue = Number($(this).closest('tr').find('.measurement-value').val());
                totalQuantity  += quantity * MeasurementValue;
            }

        })
        totalQuantity += Number(itemMeasurementValue);


        if(totalQuantity < itemCurrentStock){
            addItemMeasurement(itemId, itemName, itemVariationId, itemVariationName, itemMeasurementTitle, itemMeasurementSKU, itemMeasurementValue, itemSKU, itemPurchasePrice, itemSalePrice, itemDiscountPrice, itemVatPercent, itemDiscountPercent, itemQuantity, itemUnitMeasure, itemCurrentStock, obj)
        }else{
            warning('toastr', 'Stock limit is over');
        }
    }

    $(".add-item-measurement").click(function(){
        $(this).closest('td').find('.item-measurement-quantity').show();

    });

    function quantityIncrementToItemVariation(itemId, itemName, itemVariationId, itemVariationName, itemMeasurementTitle, itemMeasurementSKU, itemMeasurementValue, itemSKU, itemPurchasePrice, itemSalePrice, itemDiscountPrice, itemVatPercent, itemDiscountPercent, itemQuantity, itemUnitMeasure, itemCurrentStock, obj){

            let stock = Number($(obj).closest('tr').find('.product-modal-current-stock').val());

            let quantity = Number($(obj).closest('tr').find('.product-quantity').val()) + 1;
            if(stock >= quantity){
                $(obj).closest('tr').find('.product-quantity').val(quantity);
            }
            // quantityIncrement(obj);

            addItemMeasurement(itemId, itemName, itemVariationId, itemVariationName, itemMeasurementTitle,
            itemMeasurementSKU, itemMeasurementValue, itemSKU, itemPurchasePrice, itemSalePrice, itemDiscountPrice,
            itemVatPercent, itemDiscountPercent, itemQuantity, itemUnitMeasure, itemCurrentStock, obj);


    }

    function quantityIncrementToItemMeasurement(itemId, itemName, itemVariationId, itemVariationName, itemMeasurementTitle, itemMeasurementSKU, itemMeasurementValue, itemSKU, itemPurchasePrice, itemSalePrice, itemDiscountPrice, itemVatPercent, itemDiscountPercent, itemQuantity, itemUnitMeasure, itemCurrentStock, obj){
        let totalQuantity = 0;
        $('.product-id').each(function () {
            if($(this).val() == itemId){
                let quantity         = Number($(this).closest('tr').find('.product-quantity').val());
                let MeasurementValue = Number($(this).closest('tr').find('.measurement-value').val());

                totalQuantity  += quantity * MeasurementValue;
            }

        })
        totalQuantity += Number(itemMeasurementValue);



        if(totalQuantity < itemCurrentStock){
            let newQuantity = Number($(obj).closest('tr').find('.product-quantity').val()) + 1;
            $(obj).closest('tr').find('.product-quantity').val(newQuantity);
            addItemMeasurement(itemId, itemName, itemVariationId, itemVariationName, itemMeasurementTitle,
            itemMeasurementSKU, itemMeasurementValue, itemSKU, itemPurchasePrice, itemSalePrice, itemDiscountPrice,
            itemVatPercent, itemDiscountPercent, itemQuantity, itemUnitMeasure, itemCurrentStock, obj);
        }else{
            warning('toastr', 'Stock limit is over');
        }



    }

    function clearTable(tableBoadyId){
        $('#tableBoadyId').html('');

    }

    function quantityDecrementToItemMeasurement(itemId, itemName, itemVariationId, itemVariationName, itemMeasurementTitle, itemMeasurementSKU, itemMeasurementValue, itemSKU, itemPurchasePrice, itemSalePrice, itemDiscountPrice, itemVatPercent, itemDiscountPercent, itemQuantity, itemUnitMeasure, itemCurrentStock, obj){

        let itemCurrentQuantity = Number($(obj).closest('tr').find('.product-quantity').val());

        let is_find = 0;
        if(itemVariationId == ''){
            $('.measurement-sku').each(function(index) {
                let sku = $(this).val();

                if (itemMeasurementSKU == sku) {
                    is_find += 1;
                    if(itemCurrentQuantity < 2){
                        $(this).closest('tr').remove();
                        calculateAllAmounts();
                    }
                }
            })
        }else{
            $('.product-variation-id').each(function(index) {
                let variationId = $(this).val();

                if (itemVariationId == variationId) {
                    is_find += 1;
                    if(itemCurrentQuantity < 2){
                        $(this).closest('tr').remove();
                        calculateAllAmounts();
                    }
                }
            })
        }


        if(itemCurrentQuantity < 2){

                $(obj).closest('tr').find('.item-measurement-quantity').hide();
                $(obj).closest('tr').find('.add-item-measurement').show();

        }

        if (is_find > 0 && itemCurrentQuantity >= 2) {
            if(itemVariationId == ''){

                $('.measurement-sku').each(function(index) {
                        let sku = $(this).val();

                        if (itemMeasurementSKU == sku) {
                            $(this).closest('tr').find('.product-quantity').focus();

                            itemQuantity = Number($(this).closest('tr').find('.p-qty').val()) - 1;
                            let itemCurrentStock = Number($(this).closest('tr').find('.product-current-stock').val());


                            let itemDiscountPrice = Number($(this).closest('tr').find('.product-discount-price').val());
                            let itemSalePrice     = Number($(this).closest('tr').find('.product-sale-price').val());
                            let itemVatPercent    = Number($(this).closest('tr').find('.product-vat-percent').val());

                            let prevLineTotal               = Number($(this).closest('tr').find('.line-total').text());
                            let prevLineTotalVatAmount      = Number($(this).closest('tr').find('.line-total-vat-amount').val());
                            let prevLineTotalDiscountAmount = Number($(this).closest('tr').find('.line-total-discount-amount').val());

                            let lineTotal                = Number(prevLineTotal - (itemDiscountPrice > 0 ? itemDiscountPrice * 1 : itemSalePrice * 1));
                            let lineTotalVatAmount       = Number(prevLineTotalVatAmount - (itemSalePrice * itemVatPercent / 100)) ;
                            let lineTotalDiscountAmount  = itemDiscountPrice > 0 ? Number(((itemSalePrice - itemDiscountPrice) * 1) + prevLineTotalDiscountAmount) : 0;

                            $(this).closest('tr').find('.product-quantity').val(itemQuantity);
                            $(this).closest('tr').find('.line-total').text(lineTotal);
                            $(this).closest('tr').find('.line-total-vat-amount').val(lineTotalVatAmount);
                            $(this).closest('tr').find('.line-total-discount-amount').val(lineTotalDiscountAmount);

                            info('toastr', 'Update Quantity');

                            calculateAllAmounts()

                            $(obj).val('');
                        }
                })
            }else{
                $('.product-variation-id').each(function(index) {
                    let variationId = $(this).val();

                    if (itemVariationId == variationId) {
                            $(this).closest('tr').find('.product-quantity').focus();

                            itemQuantity = Number($(this).closest('tr').find('.p-qty').val()) - 1;
                            let itemCurrentStock = Number($(this).closest('tr').find('.product-current-stock').val());


                            let itemDiscountPrice = Number($(this).closest('tr').find('.product-discount-price').val());
                            let itemSalePrice     = Number($(this).closest('tr').find('.product-sale-price').val());
                            let itemVatPercent    = Number($(this).closest('tr').find('.product-vat-percent').val());

                            let prevLineTotal               = Number($(this).closest('tr').find('.line-total').text());
                            let prevLineTotalVatAmount      = Number($(this).closest('tr').find('.line-total-vat-amount').val());
                            let prevLineTotalDiscountAmount = Number($(this).closest('tr').find('.line-total-discount-amount').val());

                            let lineTotal                = Number(prevLineTotal - (itemDiscountPrice > 0 ? itemDiscountPrice * 1 : itemSalePrice * 1));
                            let lineTotalVatAmount       = Number(prevLineTotalVatAmount - (itemSalePrice * itemVatPercent / 100)) ;
                            let lineTotalDiscountAmount  = itemDiscountPrice > 0 ? Number(((itemSalePrice - itemDiscountPrice) * 1) + prevLineTotalDiscountAmount) : 0;

                            $(this).closest('tr').find('.product-quantity').val(itemQuantity);
                            $(this).closest('tr').find('.line-total').text(lineTotal);
                            $(this).closest('tr').find('.line-total-vat-amount').val(lineTotalVatAmount);
                            $(this).closest('tr').find('.line-total-discount-amount').val(lineTotalDiscountAmount);

                            info('toastr', 'Update Quantity');

                            calculateAllAmounts()

                            $(obj).val('');
                        }
                })
            }
         calculateAllAmounts();
         quantityDecrement(obj);

        }

    }

    function addItemMeasurement(itemId, itemName, itemVariationId, itemVariationName, itemMeasurementTitle, itemMeasurementSKU, itemMeasurementValue, itemSKU, itemPurchasePrice, itemSalePrice, itemDiscountPrice, itemVatPercent, itemDiscountPercent, itemQuantity, itemUnitMeasure, itemCurrentStock, obj){
        if(obj != 0){
            let _this = $(obj).closest('td');
            _this.find('.item-measurement-quantity').show();
            _this.find('.add-item-measurement').hide();
        }
        let is_find = 0;


        if(itemVariationId == ''){
            $('.measurement-sku').each(function(index) {
                let sku = $(this).val();
                if (itemMeasurementSKU == sku) {
                    is_find += 1;
                }
            })
        }else{
            $('.product-variation-id').each(function(index) {
                let variationId = $(this).val();
                if (itemVariationId == variationId) {
                    is_find += 1;
                }
            })
        }



        if (is_find > 0) {
            if(itemVariationId == ''){
                $('.measurement-sku').each(function(index) {
                        let sku = $(this).val();

                        if (itemMeasurementSKU == sku) {
                            $(this).closest('tr').find('.product-quantity').focus();

                            itemQuantity = Number($(this).closest('tr').find('.p-qty').val()) + 1;
                            let itemCurrentStock = Number($(this).closest('tr').find('.product-current-stock').val());

                            if (itemQuantity > itemCurrentStock) {
                                warning('toastr', 'Stock limit is over');
                                return;
                            }

                            let itemDiscountPrice = Number($(this).closest('tr').find('.product-discount-price').val());
                            let itemSalePrice = Number($(this).closest('tr').find('.product-sale-price').val());
                            let itemVatPercent = Number($(this).closest('tr').find('.product-vat-percent').val());

                            let prevLineTotal = Number($(this).closest('tr').find('.line-total').text());
                            let prevLineTotalVatAmount = Number($(this).closest('tr').find('.line-total-vat-amount').val());
                            let prevLineTotalDiscountAmount = Number($(this).closest('tr').find('.line-total-discount-amount').val());

                            let lineTotal = Number((itemDiscountPrice > 0 ? itemDiscountPrice * 1 : itemSalePrice * 1) + prevLineTotal);
                            let lineTotalVatAmount = Number((itemSalePrice * itemVatPercent / 100) + prevLineTotalVatAmount) ;
                            let lineTotalDiscountAmount = itemDiscountPrice > 0 ? Number(((itemSalePrice - itemDiscountPrice) * 1) + prevLineTotalDiscountAmount) : 0;
                            $(this).closest('tr').find('.product-quantity').val(itemQuantity);
                            $(this).closest('tr').find('.line-total').text(lineTotal);
                            $(this).closest('tr').find('.line-total-vat-amount').val(lineTotalVatAmount);
                            $(this).closest('tr').find('.line-total-discount-amount').val(lineTotalDiscountAmount);

                            info('toastr', 'Update Quantity');

                            calculateAllAmounts()

                            $(obj).val('');
                        }
                })
            }else{
                $('.product-variation-id').each(function(index) {
                        let variationId = $(this).val();

                        if (itemVariationId == variationId) {
                            $(this).closest('tr').find('.product-quantity').focus();

                            itemQuantity = Number($(this).closest('tr').find('.p-qty').val()) + 1;
                            let itemCurrentStock = Number($(this).closest('tr').find('.product-current-stock').val());

                            if (itemQuantity > itemCurrentStock) {
                                warning('toastr', 'Stock limit is over');
                                return;
                            }

                            let itemDiscountPrice = Number($(this).closest('tr').find('.product-discount-price').val());
                            let itemSalePrice = Number($(this).closest('tr').find('.product-sale-price').val());
                            let itemVatPercent = Number($(this).closest('tr').find('.product-vat-percent').val());

                            let prevLineTotal = Number($(this).closest('tr').find('.line-total').text());
                            let prevLineTotalVatAmount = Number($(this).closest('tr').find('.line-total-vat-amount').val());
                            let prevLineTotalDiscountAmount = Number($(this).closest('tr').find('.line-total-discount-amount').val());

                            let lineTotal = Number((itemDiscountPrice > 0 ? itemDiscountPrice * 1 : itemSalePrice * 1) + prevLineTotal);
                            let lineTotalVatAmount = Number((itemSalePrice * itemVatPercent / 100) + prevLineTotalVatAmount) ;
                            let lineTotalDiscountAmount = itemDiscountPrice > 0 ? Number(((itemSalePrice - itemDiscountPrice) * 1) + prevLineTotalDiscountAmount) : 0;
                            $(this).closest('tr').find('.product-quantity').val(itemQuantity);
                            $(this).closest('tr').find('.line-total').text(lineTotal);
                            $(this).closest('tr').find('.line-total-vat-amount').val(lineTotalVatAmount);
                            $(this).closest('tr').find('.line-total-discount-amount').val(lineTotalDiscountAmount);

                            info('toastr', 'Update Quantity');

                            calculateAllAmounts()

                            $(obj).val('');
                        }
                })
            }
        }



        if (is_find == 0) {
            appendItem(itemId, itemName, itemVariationId, itemVariationName, itemMeasurementTitle, itemMeasurementSKU, itemMeasurementValue, itemSKU, itemPurchasePrice, itemSalePrice, itemDiscountPrice, itemVatPercent, itemDiscountPercent, itemQuantity, itemUnitMeasure, itemCurrentStock)

        }


    }


    function hideModal(modalid){
        $('#'+modalid).hide();
    }
</script>




<!------- START ------- FOR SEARCH ANY PRODUCT ------>

<script>
    let product_si = 0;

    let selectedLiIndex = -1;

    function autoSearch(obj, event){

        let value = $(obj).val();
        if (event.which != 38 && event.which != 40) {
            if(value){
                let route  = `{{ route('pdt.auto-suggest-product') }}`;
                axios.get(route, {
                    params: {
                        search : value
                    }
                })
                .then(function (response) {
                        if(response.data.length > 0){
                            selectedLiIndex = -1;

                        let result = '';
                        $.each( response.data, function( key, product ) {

                            result += `<a onclick="getProductVariations(this)"
                            data-id                    = "${ product.id }"
                            data-name                  = "${ product.name }"
                            data-category              = "${ product.category.name }"
                            data-is-variation          = "${ product.is_variation }"
                            data-unit-measure          = "${ product.unit_measure.name }"
                            data-purchase-price        = "${ Number(product.purchase_price).toFixed(2) }"
                            data-sale-price            = "${ Number(product.sale_price).toFixed(2) }"
                            data-sale-discount-percent = "${ $(this).select2('data')[0].discount != null ? $(this).select2('data')[0].discount.discount_percentage : 0 }"
                            data-vat-percent           = "${ getVatPercent(product.vat, product.vat_type, product.sale_price, 0)}"
                            >${ product.name }</a>`;

                        });

                        $(obj).closest('tr').find('.live-load-content').html(result);
                        $(obj).closest('tr').find('.dropdown-content').show();
                    }else{
                        $('.dropdown-content').hide();
                    }

                }).catch(function (error) {

                });
            }else{
                $('.dropdown-content').hide();
            }
        }

        $(obj).blur(function(){
            setTimeout(function(){
                // $('.live-load-content').hide();
            }, 500);
        })

        arrowUpDownInit(event, obj);

    }




    function getVatPercent(vat, vatType,salePrice, discount){
        let vatPercent = 0;
        let saleP     = salePrice - discount;

        if(vatType == 'Percentage'){
            vatPercent = vat;
        }else{
            vatPercent = (vat * 100) / salePrice;
        }
        return vatPercent;

    }



    function arrowUpDownInit(e, obj) {
        if (e.which === 13) {
            // alert("ok");
        }


        let _this = $(obj).closest('.search-any-product');

        e.preventDefault()

        _this.find('.live-load-content').find('a').removeClass('search-result')

        var a = _this.find('.live-load-content').find('a')

        var selectedItem


        if (e.which === 40) {
            console.log('down')

            selectedLiIndex += 1


        } else if (e.which === 38) {

            $("#searchProduct").focusout();
            console.log('down')

            selectedLiIndex -= 1

            if (selectedLiIndex < 0) {
                selectedLiIndex = 0
            }

        }



        if (a.length <= selectedLiIndex) {
            selectedLiIndex = 0
        }


        if (e.which == 40 || e.which == 38) {

            selectedItem = _this.find('.live-load-content').find(`a:eq(${selectedLiIndex})`).addClass('background').focus();
            select(selectedItem)

        }
        // addItemOnEnter(tr.find('.live-load-content').closest(`a:eq(${selectedLiIndex})`), e)
        addItemOnEnter(_this.find('.live-load-content').find('.search-result'))
    }


    // function addItemOnEnter(object, e) {
    function addItemOnEnter(object) {

        // console.log(object);

        $(object).on('keydown', function () {
        })

        // if (e.which == 13) {
        //     // alert("ok");

        //     getProductVariations(object);
        // }
    }



    function select(el) {

        var ul = $('.live-load-content')

        var elHeight = $(el).height()
        var scrollTop = ul.scrollTop()
        var viewport = scrollTop + ul.height()
        var elOffset = (elHeight + 10) * selectedLiIndex

        if (elOffset < scrollTop || (elOffset + elHeight) > viewport)
            $(ul).scrollTop(elOffset)
        selectedItem = $('.live-load-content').find(`a:eq(${selectedLiIndex})`);

        // selectedItem.attr("style", "color: green;");
        selectedItem.addClass('search-result');
    }

</script>





<script>

    function searchAnyProduct(obj, event){

        let hideSearchContent = 0;
        let searchString      = $(obj).val();
        let stringLength      = searchString.length;

        if(stringLength > 3){

            if (event.which != 38 && event.which != 40) {

                let route  = `{{ route('pdt.search-any-product') }}`;
                let value = $(obj).val();

                if(value != ''){
                    axios.get(route, {
                        params: {
                            search : value
                        }
                    })
                    .then(function (response) {
                        if(response.data.length > 0){


                            selectedLiIndex = -1;
                            let result = '';
                            result = `<ul class="search-product" role="menu" style="z-index:99999">`
                            $.each( response.data, function( key, product ) {
                                let itemQuantity            = 1;
                                let itemIsMeasurement       = 'No';
                                let productUnitMeasure      = product.unit_measure.name;


                                let myProduct = `${ JSON.stringify(product) }`;
                                let image = product.thumbnail_image;
                                if(image != null){
                                    image = image.replace("./", "/");
                                }
                                let sku   = product.sku != null ? product.sku : '';
                                if(product.product_variations != ''){
                                    $.each( product.product_variations, function( key, variation ) {
                                        let itemDiscountPrice = '';
                                        let itemDiscountPercent = '';
                                        if(product.discount != null){
                                            itemDiscountPercent = product.discount.discount_percentage;

                                            itemDiscountPrice =  variation.sale_price - ((variation.sale_price * product.discount.discount_percentage) / 100);
                                        } else if(product.discount_percentage > 0) {

                                            itemDiscountPercent = product.discount_percentage;

                                            itemDiscountPrice =  variation.sale_price - ((variation.sale_price * product.discount_percentage) / 100);
                                        }
                                        let salePrice          = variation.sale_price;
                                        result += `<a onclick="addItemMeasurement('${ product.id }', '${ product.name }', '${ variation.id }', '${ variation.name }', '', '', '', '${ product.sku }', '${ variation.purchase_price }', '${ salePrice }', '${ itemDiscountPrice }', '${ product.vat }', '${ itemDiscountPercent }', '${ itemQuantity }', '${ productUnitMeasure }', '${ variation.variation_stock }', this)"
                                                    data-id                    = "${ product.id }"
                                                    data-name                  = "${ product.name }"
                                                    data-category              = "${ product.category.name }"
                                                    data-is-variation          = "${ product.is_variation }"
                                                    data-unit-measure          = "${ product.unit_measure.name }"
                                                    data-purchase-price        = "${ Number(product.purchase_price).toFixed(2) }"
                                                    data-sale-price            = "${ Number(product.sale_price).toFixed(2) }"
                                                    data-sale-discount-percent = "0"
                                                    data-vat-percent           = "${ getVatPercent(product.vat, product.vat_type, product.sale_price, 0)}"
                                                    >
                                                    <div style=" margin-right: 5px;">
                                                        <img src="${image != 'http://127.0.0.1:8000/' ? image : '/default-image.jpg'}" alt="" height="45" width="50">
                                                    </div>
                                                    ${ product.name +' - '+ variation.name + ' - SKU : ' + variation.sku }
                                                    </a>`;
                                        if(response.data.length == 1 && product.product_variations.length == 1){

                                            addItemMeasurement(product.id, product.name , variation.id, variation.name , '', '', '', product.sku, variation.purchase_price , salePrice,
                                                        itemDiscountPrice , product.vat, itemDiscountPercent, '1', productUnitMeasure, variation.variation_stock, 0);
                                            hideSearchContent = 1;
                                        }
                                    })
                                }else if(product.product_measurements != ''){

                                    $.each( product.product_measurements, function( key, measurement ) {

                                        let itemDiscountPrice = '';
                                        let itemDiscountPercent   = 0;
                                        if(product.discount != null){
                                            itemDiscountPercent = product.discount.discount_percentage;

                                            itemDiscountPrice =  (product.sale_price * measurement.value) - (((product.sale_price * measurement.value) * product.discount.discount_percentage) / 100);
                                        } else if(product.discount_percentage > 0) {

                                            itemDiscountPercent = product.discount_percentage;

                                            itemDiscountPrice =  (product.sale_price * measurement.value) - (((product.sale_price * measurement.value) * product.discount_percentage) / 100);
                                        }
                                        let productUnitMeasure = measurement.title;
                                        let salePrice          = product.sale_price * measurement.value;

                                        itemDiscountPrice = Math.round(itemDiscountPrice)

                                        result += `<a onclick="addItemMeasurementByCheck('${ product.id }', '${ product.name }', '', '', '${ measurement.title }', '${ measurement.sku }', '${ measurement.value }',
                                         '${ product.sku }', '${ product.purchase_price }', '${ salePrice }', '${ itemDiscountPrice }', '${ product.vat }', '${ itemDiscountPercent }', '1', '${ productUnitMeasure }', '${ product.stock }', this)"
                                                    data-id                    = "${ product.id }"
                                                    data-name                  = "${ product.name }"
                                                    data-category              = "${ product.category.name }"
                                                    data-is-variation          = "${ product.is_variation }"
                                                    data-unit-measure          = "${ product.unit_measure.name }"
                                                    data-purchase-price        = "${ Number(product.purchase_price).toFixed(2) }"
                                                    data-sale-price            = "${ Number(product.sale_price).toFixed(2) }"
                                                    data-sale-discount-percent = "0"
                                                    data-vat-percent           = "${ getVatPercent(product.vat, product.vat_type, product.sale_price, 0)}"
                                                    >
                                                    <div style=" margin-right: 5px;">
                                                        <img src="${image != 'http://127.0.0.1:8000/' ? image : '/default-image.jpg'}" alt="" height="45" width="50">
                                                    </div>
                                                    ${ product.name +' - '+ measurement.title + ' - SKU : ' + measurement.sku }
                                                    </a>`;

                                        if(response.data.length == 1 && product.product_measurements.length == 1){

                                            addItemMeasurementByCheck(product.id, product.name , '', '' , measurement.title, measurement.sku, measurement.value, product.sku, product.purchase_price , salePrice,
                                                        itemDiscountPrice , product.vat, itemDiscountPercent, '1', productUnitMeasure, product.stock , 0);
                                            hideSearchContent = 1;
                                        }
                                    })
                                }

                                else{

                                    let itemDiscountPrice = '';
                                    let itemDiscountPercent   = 0;
                                    if(product.discount != null){
                                        itemDiscountPercent = product.discount.discount_percentage;

                                        itemDiscountPrice   = product.sale_price - ((product.sale_price * product.discount.discount_percentage) / 100);
                                    } else if(product.discount_percentage > 0) {

                                        itemDiscountPercent = product.discount_percentage;

                                        itemDiscountPrice   = product.sale_price - ((product.sale_price * product.discount_percentage) / 100);
                                    }

                                    itemDiscountPrice = Math.round(itemDiscountPrice)

                                    result += `<a onclick="addNormalProduct('${ product.id }', '${ product.name }', '', '', '', '', '', '${ product.sku }', '${ product.purchase_price }', '${ product.sale_price }',
                                    '${ itemDiscountPrice }', '${ product.vat }', '${ itemDiscountPercent }', '1', '${ productUnitMeasure }', '${ product.stock }')"
                                                data-id                    = "${ product.id }"
                                                data-name                  = "${ product.name }"
                                                data-category              = "${ product.category.name }"
                                                data-is-variation          = "${ product.is_variation }"
                                                data-unit-measure          = "${ product.unit_measure.name }"
                                                data-purchase-price        = "${ Number(product.purchase_price).toFixed(2) }"
                                                data-sale-price            = "${ Number(product.sale_price).toFixed(2) }"
                                                data-sale-discount-percent = "0"
                                                data-vat-percent           = "${ getVatPercent(product.vat, product.vat_type, product.sale_price, 0)}"
                                                >
                                                <div style=" margin-right: 5px;">
                                                    <img src="${image != 'http://127.0.0.1:8000/' ? image : '/default-image.jpg'}" alt="" height="45" width="50">
                                                </div>
                                                ${ product.name +' - '+ sku }
                                                </a>`;
                                    if(response.data.length == 1){

                                        addNormalProduct(product.id, product.name , '', '', '', '', '', product.sku, product.purchase_price, product.sale_price,
                                        itemDiscountPrice , product.vat, itemDiscountPercent, '1', productUnitMeasure, product.stock);

                                        $('#searchProductField').val('');
                                        hideSearchContent = 1;
                                    }
                                }
                            });
                            result += '</ul>'
                            if(hideSearchContent == 0){
                                $('.live-load-content').html(result);
                                $('.dropdown-content').show();
                            }else{
                                $('.dropdown-content').hide()
                            }
                        }else{
                            $('.dropdown-content').hide();
                        }
                        // appendData(response.data, value);
                    }).catch(function (error) {
                    });
                }
        }else{
            $('.dropdown-content').hide();
        }
            $(obj).blur(function(){
            setTimeout(function(){
                $('.live-load-content').hide();
            }, 500);
        })
        arrowUpDownInit(event, obj);
        }

    }

    let newKey = 0;

    function appendData(product, searchedValue, isReadonly){

        let discount_percent = 0

        if(product.discount != null) {
            discount_percent = product.discount.discount_percentage

        } else if (product.discount_percentage > 0) {

            discount_percent = product.discount_percentage
        }

        let tr = `<tr class="new-tr">
                <input type="hidden" name="sale_detail_id[]" class="purchase-detail-id" value="">
                <th width="25%" style="position: relative;">
                    <input type="hidden" class="product-is-variation" value="${ product.product_variations != '' ? "true" : "false" }">
                    <input type="hidden" class="product-is-measurement" value="${ product.product_measurements != '' ? "true" : "false" }">
                    <select name="product_id[]" id="product_id" class="form-control products product_id-${newKey}" onchange="getProductVariations(this)" required>
                        <option value="${ product.id }"
                            data-category               = "${ product.category.name }"
                            data-is-variation           = "${ product.is_variation }"
                            data-unit-measure           = "${ product.unit_measure.name }"
                            data-purchase-price         = "${ product.purchase_price }"
                            data-sale-price             = "${ product.sale_price }"
                            data-sale-discount-percent  = "${ discount_percent }"
                            data-vat-percent            = "${ product.vat, product.vat_type, product.sale_price}"
                            selected
                        >${ product.name } &mdash; ${ product.code }</option>
                    </select>
                </th>

                <th width="15%">
                    <select name="" id="product_variation_id" class="form-control product-variations abcd select2" onchange="checkItemExistOrNot(this)" ${ isReadonly == 1 ? 'disabled' : '' }>
                        <option value="" selected>- Select -</option>
                    </select>
                </th>
                <th width="7%">
                    <input type="text" name="" id="sku" value="${ product.sku}" class="form-control sku-code" readonly>
                </th>
                <th width="10%" style="display: none;">
                    <select name="lot[]" id="lot" class="form-control lots select2" onchange="checkItemExistOrNot(this), getItemStock(this)">
                        <option value="" selected>- Select -</option>
                    </select>
                </th>
                <th width="10%">
                    <input type="text" name="stock[]" id="stock" class="form-control text-center only-number stock" readonly>
                </th>
                <th width="7%">
                    <input type="text" name="unit_measure_id[]" id="unit_measure_id" value="${ product.unit_measure.name }" class="form-control unit-measure" readonly>
                </th>
                <th width="10%">
                    <input type="hidden" name="purchase_price[]" id="purchase_price" class="form-control text-right only-number purchase-price" autocomplete="off" value="${ product.purchase_price }" required>
                    <input type="number" name="sale_price[]" id="sale_price" class="form-control text-right only-number sale-price" autocomplete="off" onkeyup="calculateRowTotal(this)" value="${ product.sale_price }" required>
                </th>
                <th width="8%">
                    <input type="number" name="quantity[]" id="quantity" class="form-control text-center quantity pdt-quantity" autocomplete="off" onkeyup="calculateRowTotal(this)" required>
                </th>
                <th width="10%">
                    <input type="hidden" name="product_variation_id[]" class="product-variation-id" value="">
                    <input type="hidden" name="measurement_title[]" class="measurement-title" value="{{ old('measurement_title') }}">
                    <input type="hidden" name="measurement_sku[]" class="measurement-sku" value="{{ old('measurement_sku') }}">
                    <input type="hidden" name="measurement_value[]" class="measurement-value" value="{{ old('measurement_value') }}">
                    <input type="hidden" name="vat_amount[]" class="pdt-vat-amount">
                    <input type="hidden" name="vat_percent[]" class="pdt-vat-percent" value="${ product.vat }">
                    <input type="hidden" name="purchase_total[]" id="purchase_total" class="form-control purchase-total text-right" readonly>
                    <input type="text"   name="total[]" id="total" class="form-control total text-right" readonly>
                    <input type="hidden" name="discount_percent[]" class="form-control pdt-discount-percent text-right" value="${ discount_percent }" readonly>
                    <input type="text" name="total_discount_amount[]" class="form-control pdt-total-discount-amount text-right" readonly>
                </th>
                <th width="5%" class="text-center">
                    <button type="submit" class="btn btn-sm btn-danger remove-row" title="Remove"><i class="fa fa-times"></i></button>
                </th>
            </tr>`
        $("#invoiceSaleTable").append( tr );
        let row = $("#invoiceSaleTable tbody tr:last");

        if(product.is_variation == "Yes"){
            let variation = product.product_variations;
            let variationSku = 0;
            let variationSkuCode = '';

            variation.map(function(productVariation, index) {
                row.find('.product-variations').append(`<option value="${ productVariation.id }" data-variation-purchase-price="${ productVariation.purchase_price }" data-variation-sale-price="${ productVariation.sale_price }" data-variation-current-stock="0" data-is-variation="Yes" ${ productVariation.sku == searchedValue ? 'selected' : ''}>${ productVariation.name }</option>`);

                if(productVariation.sku == searchedValue)
                {
                    variationSku = 1;
                    variationSkuCode = productVariation.sku;
                }

            });
            row.find('.sku-code').val(variationSkuCode);

            if(variationSku == 1){

                checkItemExistOrNot(row.find('.product-variations'));
            }
        }else{
            if(product.product_measurements != ''){

                // let keepSelected = 0;
                // if(product.product_measurements.length == 1){
                //     alert("ol");
                //     keepSelected = 1;
                // }

                let measurement  = product.product_measurements;
                let measurementSku = 0;
                let measurementSkuCode = '';

                measurement.map(function(productMeasurement, index) {

                    if(product.product_measurements.length != 1){
                        if(productMeasurement.sku == searchedValue){
                            keepSelected        = 1;
                            measurementSkuCode  = productMeasurement.sku;
                        }
                    }

                    row.find('.product-variations').append(`<option value="${ productMeasurement.id }" data-measurement-value="${ productMeasurement.value }" data-measurement-title="${ productMeasurement.title }" data-measurement-sku="${ productMeasurement.sku }" data-is-variation="Yes" ${ productMeasurement.sku == searchedValue ? 'selected' : ''} >${ productMeasurement.title }</option>`);
                    if(productMeasurement.sku == searchedValue)
                    {
                        measurementSku = 1;
                    }
                });
                row.find('.sku-code').val(measurementSkuCode);

                if(measurementSku == 1)
                {
                    checkItemExistOrNot(row.find('.product-variations'));
                }

            }

            getLots(row.find('.product-variations'), product.id);

            // checkItemExistOrNot();

        }
        $('#searchProductField').val('');





        $('.product-variations').select2()


        // $(".product_id-"+newKey).select2({
        //     ajax: {
        //         url: `{{ route('get-sale-products') }}`,
        //         type: 'GET',
        //         dataType: 'json',
        //         delay: 250,
        //         data: function(params) {
        //             return {
        //                 q: params.term, // search term
        //                 page: params.current_page
        //             };
        //         },
        //         processResults: function(data, params) {
        //             params.current_page = params.current_page || 1;

        //             return {
        //                 results: data.data,
        //                 pagination: {
        //                     more: (params.current_page * 30) < data.total
        //                 }
        //             };
        //         },
        //         autoWidth: true,
        //         cache: true
        //     },
        //     placeholder: 'Search Product(s)',
        //     minimumInputLength: 1,
        //     templateResult: formatProduct,
        //     templateSelection: formatProductSelection
        // }).on('change', function(e) {
        //     console.log($(this).select2('data')[0]);

        //     $(this).append(`
        //     <option value="${ product.id }"
        //         data-category              = "${ product.category.name }"
        //         data-is-variation          = "${ product.is_variation }"
        //         data-unit-measure          = "${ product.unit_measure.name }"
        //         data-purchase-price        = "${ product.purchase_price }"
        //         data-sale-price            = "${ product.sale_price }"
        //         data-sale-discount-percent = "${ product.discount != null ? product.discount.discount_percentage : 0 }"
        //         data-vat-percent            = "${ product.vat, product.vat_type, product.sale_price}"
        //     >${ product.name } &mdash; ${ product.code }</option>
        //     `);
        // });

        // // $('.product_id').select2({
        // //     placeholder: "Select Product"
        // // });

        // function formatProduct(product) {
        //     if (product.loading) {
        //         return product.text;
        //     }

        //     var $container = $(`
        //         <div class='select2-result-product clearfix'>
        //             <div class='select2-result-product__title'>
        //                 ${ product.name + ' -> ' + product.sku }
        //             </div>
        //         </div>
        //     `);

        //     return $container;
        // }

        // function formatProductSelection(product) {
        //     return product.name;
        // }

        // newKey++
    }


    $(document).on('change', '.abcd', function () {
        $(this).closest('tr').find('.lots').prop('required', false);
        $(this).closest('tr').find('.lots').empty().select2();
        $(this).closest('tr').find('.lots').append(`<option value="" selected>- Select -</option>`).select2();

        checkItemExistOrNot($(this));
    })

</script>






<!------- START ------- FOR TABLE ROW ADD/REMOVE ------>
<script>


    const accountRow =  `
        <tr class="new-tr">
            <td style="width: 4%"><span class="sn-no">1</span></td>
            <td style="width: 50%">
                <div class="input-group">
                    <div class="input-group-addon">
                        <label class="input-group-text">
                            Account
                        </label>
                    </div>
                    <select name="ecom_account_id[]" class="form-control ecom-account select2" onchange="checkAccountExistOrNot(this)">
                        <option value="" selected>- Select -</option>
                        @foreach ($accounts as $account)
                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                        @endforeach
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
                    <input type="text" name="payment_amount[]" class="form-control only-number text-right payment-modal-paid-amount" placeholder="Type amount" autocomplete="off" onkeyup="calculatePaymentModalPaidAmount()">
                </div>
            </td>

            <td class="text-center" style="width: 6%">
                <div class="btn-group">
                    <a href="javascript:void(0)" class="btn btn-sm btn-danger remove-button" onclick="removeAccount(this)" type="button">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </td>
        </tr>`;

        $(document).ready(function () {

            $('.ecom-account').select2({theme: 'bootstrap-5'})
        })

    function addPaymentAccount()
    {
        $('#payment-table').append(accountRow)

        serial()

        // getEcomAccountsByWarehouse()


        $('.ecom-account').select2({theme: 'bootstrap-5'})

        // calculatePaymentAmount();
    }


    function removeAccount(obj)
    {
        $(obj).closest("tr").remove();
        serial();
        // calculatePaymentAmount();
    }




    function serial()
    {
        $('.sn-no').each(function(index) {
            $(this).text(index + 1)
        })
    }



</script>
<!----------------------- END ------------------------->

<script>
    $(document).ready(function () {

        function searchCustomerSelect()
        {
            $("#customer_id").select2({
                theme: 'bootstrap-5',
                ajax: {
                    url: `{{ route('get-customers') }}`,
                    type: 'GET',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
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
                placeholder: 'Search Customer(s)',
                minimumInputLength: 1,
                templateResult: formatCustomer,
                templateSelection: formatCustomerSelection
            })
        }

        let customerSelect = searchCustomerSelect();
        customerSelect.on('change', function(e) {
            console.log("okk");
            // console.log($(this).select2('data')[0]);

            // setCustomer($(this).select2('data')[0].id, $(this).select2('data')[0].name, $(this).select2('data')[0].mobile, $(this).select2('data')[0].address);

            $(this).html(`
                <option value='${ $(this).select2('data')[0].id }'
                        data-name                     = '${$(this).select2('data')[0].name}'
                        data-mobile                   = '${$(this).select2('data')[0].mobile}'
                        data-email                    = '${$(this).select2('data')[0].email}'
                        data-address                  = '${$(this).select2('data')[0].address}'
                        data-zip_code                 = '${$(this).select2('data')[0].zip_code}'
                        data-district_id              = '${$(this).select2('data')[0].district_id}'
                        data-area_id                  = '${$(this).select2('data')[0].area_id}'
                        data-customer_type_id         = '${$(this).select2('data')[0].customer_type_id}'
                        data-is_default               = '${$(this).select2('data')[0].is_default}'
                        data-gender                   = '${$(this).select2('data')[0].gender}'
                        data-user_id                  = '${$(this).select2('data')[0].user_id}'
                        selected
                > ${ $(this).select2('data')[0].name + ' - ' + $(this).select2('data')[0].mobile }
                </option>
            `);
            searchCustomerSelect();
        });
        function formatCustomer(customer) {
            if (customer.loading) {
                return customer.text;
            }
            var $container = $(`
                <div class='select2-result-customer clearfix'>
                    <div class='select2-result-customer__title'>
                        ${ customer.name + ' -> ' + customer.mobile }
                    </div>
                </div>
            `);
            return $container;
        }
        function formatCustomerSelection(customer) {
            return customer.name;
        }
    });


    function addDataToPaymentModal(){
        $('#invoicePayableAmount').text($('#invoicePayable').val());

    }

    function calculatePaymentModalPaidAmount(){
        let totalPaidAmount = 0;
        $('.payment-modal-paid-amount').each(function(index) {
            totalPaidAmount += Number($(this).val());

        });

        $('#pay').text(totalPaidAmount);
    }


    function checkAccountExistOrNot(obj)
    {
        let accountId = $(obj).closest('tr').find('.ecom-account').find('option:selected').val();

        let is_find = 0;

        $('.ecom-account').each(function(index) {
            let account_id = $(this).val()

            if (accountId == account_id) {

               is_find += 1;
            }
        })


        if (is_find > 1) {
            warning('toastr', 'Account already exists!');

            $(obj).closest('tr').find('.ecom-account').val('');
            $(obj).closest('tr').find('.ecom-account').select2();
            $(obj).closest('tr').find('.payment-amount').val('');

            calculatePaymentAmount()

            return;
        }
    }


    function addNormalProduct(itemId, itemName, itemVariationId, itemVariationName, itemMeasurementTitle, itemMeasurementSKU, itemMeasurementValue, itemSKU, itemPurchasePrice, itemSalePrice, itemDiscountPrice, itemVatPercent, itemDiscountPercent, itemQuantity, itemUnitMeasure, itemCurrentStock){


         let is_find = 0;

        $('.product-sku').each(function(index) {
            let sku = $(this).val();

            if (itemSKU == sku) {
                is_find += 1;
            }
        })


        if (is_find > 0) {

            $('.product-sku').each(function(index) {
                let sku = $(this).val();

                if (itemSKU == sku) {
                    $(this).closest('tr').find('.product-quantity').focus();

                    itemQuantity = Number($(this).closest('tr').find('.p-qty').val()) + 1;
                    let itemCurrentStock = Number($(this).closest('tr').find('.product-current-stock').val());

                    if (itemQuantity > itemCurrentStock) {
                        warning('toastr', 'Stock limit is over');
                        return;
                    }

                    let itemDiscountPrice = Number($(this).closest('tr').find('.product-discount-price').val());
                    let itemSalePrice = Number($(this).closest('tr').find('.product-sale-price').val());
                    let itemVatPercent = Number($(this).closest('tr').find('.product-vat-percent').val());

                    let prevLineTotal = Number($(this).closest('tr').find('.line-total').text());
                    let prevLineTotalVatAmount = Number($(this).closest('tr').find('.line-total-vat-amount').val());
                    let prevLineTotalDiscountAmount = Number($(this).closest('tr').find('.line-total-discount-amount').val());

                    let lineTotal = Number((itemDiscountPrice > 0 ? itemDiscountPrice * itemQuantity : itemSalePrice * itemQuantity) + prevLineTotal);
                    let lineTotalVatAmount = Number((prevLineTotal - (prevLineTotal - ( prevLineTotal * itemVatPercent / 100 ))) + prevLineTotalVatAmount) ;
                    let lineTotalDiscountAmount = itemDiscountPrice > 0 ? Number(((itemSalePrice - itemDiscountPrice) * itemQuantity) + prevLineTotalDiscountAmount) : 0;


                    lineTotalDiscountAmount = Math.round(lineTotalDiscountAmount)

                    $(this).closest('tr').find('.product-quantity').val(itemQuantity);
                    $(this).closest('tr').find('.line-total').text(lineTotal);
                    $(this).closest('tr').find('.line-total-vat-amount').val(lineTotalVatAmount);
                    $(this).closest('tr').find('.line-total-discount-amount').val(lineTotalDiscountAmount);

                    info('toastr', 'Update Quantity');

                    calculateAllAmounts()

                    $(obj).val('');
                }
            })

            return;
        }

        appendItem(itemId, itemName, '', '', '', '', '', itemSKU, itemPurchasePrice, itemSalePrice, itemDiscountPrice, itemVatPercent, itemDiscountPercent, itemQuantity, itemUnitMeasure, itemCurrentStock);

        calculateAllAmounts();
    }




    function setCustomer(id, name, phone, address){
            $('#sellCustomerName').val(name);
            $('#sellCustomerId').val(id);
            $('#sellCustomerPhone').val(phone);
            $('#sellCustomerAddress').val(address);
            $('#sellCustomerId').val(id);

        }
</script>


