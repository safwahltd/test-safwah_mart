
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
        $('.first-tr').find('.sku-code').val('');
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
        $('.first-tr').find('.vat-percent').val('');
        $('.first-tr').find('.pdt-total-vat-percent').val('');
        $('.first-tr').find('.pdt-total-vat-amount').val('');


        $('#payment-table .first-tr').find('.ecom-accounts').val('');
        $('#payment-table .first-tr').find('.ecom-accounts').select2();
        $('#payment-table .first-tr').find('.payment-amount').val('');

        // $('.select2').select2()

        calculatePaymentAmount()
        calculateTotalCost()
        calculateTotalVatPercent()
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



    function calculateRowTotal(obj)
    {

        console.log('test calculation')
        let purchasePrice = Number($(obj).closest('tr').find('.purchase-price').val());
        let measurement_value = Number($(obj).closest('tr').find('.measurement-value').val() ?? 1);

        if(measurement_value == 0 || measurement_value == ''){
            measurement_value = 1;
        }

        let salePrice          = Number($(obj).closest('tr').find('.sale-price').val());
        let quantity           = Number($(obj).closest('tr').find('.quantity').val());
        let stock              = Number($(obj).closest('tr').find('.stock').val());
        let pdtDiscountPercent = Number($(obj).closest('tr').find('.pdt-discount-percent').val());
        let isVat              = $(obj).closest('tr').find('.is-vat').val();
        let vatPercent         = Number($(obj).closest('tr').find('.pdt-vat-percent').val());


        console.log('test calculation')
        let is_measurement = $(obj).closest('tr').find('.product-is-measurement').val();

        console.log('test calculation')
        if(is_measurement == 'true'){
            let product_id           = $(obj).closest('tr').find('.products').val();
            let measurement_value    = Number($(obj).closest('tr').find('.measurement-value').val());

            let measurement_sku      = $(obj).closest('tr').find('.measurement-sku').val();

            let measurement_quantity_total = 0;


            $('.products').each(function () {

                if(product_id == $(this).val()){
                    let _this_measurement_sku      = $(this).closest('tr').find('.measurement-sku').val();
                    let _this_measurement_value    = $(this).closest('tr').find('.measurement-value').val();

                    if(_this_measurement_sku != measurement_sku){
                        measurement_quantity_total += Number($(this).closest('tr').find('.quantity').val()) * _this_measurement_value;
                    }
                }

            })

            console.log('test calculation')
            stock = Math.floor((stock - measurement_quantity_total));
            quantity = quantity * measurement_value;

        }



        if (quantity > stock) {
            let stockAlert = measurement_value < 1 ? Math.floor(stock * measurement_value) : Math.floor(stock/measurement_value)
            warning('toastr', 'You cannot select more then ' + stockAlert + ' quantity');
            // quantity = stock/measurement_value;
            $(obj).closest('tr').find('.quantity').val(Math.floor(stock/measurement_value));

            quantity = stock
        }


        let purchaseTotal = purchasePrice * quantity;
        let total = salePrice * (quantity / measurement_value);
        // let pdtTotalDiscountAmount = parseFloat(total - (total - ( total * pdtDiscountPercent / 100 )));
        let pdtTotalDiscountAmount = parseFloat( salePrice * pdtDiscountPercent / 100 );

        let pdtTotalVatAmount =  ((total - pdtTotalDiscountAmount) * vatPercent)/100;


        $(obj).closest('tr').find('.pdt-vat-amount').val(pdtTotalVatAmount);


        Number($(obj).closest('tr').find('.purchase-total').val(purchaseTotal.toFixed(2)));
        Number($(obj).closest('tr').find('.total').val(total.toFixed(2)));
        Number($(obj).closest('tr').find('.pdt-total-discount-amount').val(pdtTotalDiscountAmount.toFixed(2)));

        calculateTotalVat();
        calculateTotalCost()
        calculateTotalVatPercent()
        calculateSubtotal()
        totalDiscountAmount()
    }



    function calculateTotalVat(){
        let vatAmount = 0;
        $('.pdt-vat-amount').each(function () {

            let _this       = $(this).closest('tr');

            vatAmount += Number($(this).val());
        })

        $('#total_vat_amount').val(vatAmount.toFixed(2));

        setTimeout(function(){
            calculateVatPercent($('#total_vat_amount'))
        }, 300);

    }



     /*
     |--------------------------------------------------------------------------
     | CALCULATE DISCOUNT PERCENT
     |--------------------------------------------------------------------------
    */
    function calculateVatPercent(obj)
    {
        let subtotal            = $('#subtotal').val();
        let totalDiscountAmount = $('#total_discount_amount').val();

        let vatAmount = parseFloat($(obj).val());

        let vatPercent = 0;
        if(vatAmount != 0){
            vatPercent = (vatAmount / (subtotal- totalDiscountAmount)) * 100;
        }

        if (isNaN(vatPercent)) {
            vatPercent = 0
        }

        $('#total_vat_percent').val(vatPercent.toFixed(2));

        calculateAllAmount()
    }




    function calculateTotalCost()
    {
        let totalCost = 0;
        $('.purchase-total').each(function () {
            totalCost += Number($(this).val());
        })

        $('#total_cost').val(totalCost.toFixed(2))
    }




    function calculateTotalVatPercent()
    {
        let totalVatPercent = 0;
        $('.pdt-total-vat-percent').each(function () {
            totalVatPercent += Number($(this).val());
        })

        $('#total_vat_percent').val(totalVatPercent.toFixed(2))
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
            totalDiscountAmount += Number($(this).val() * $(this).closest('tr').find('.pdt-quantity').val());
        })

        $('#total_discount_amount').val(Math.round(totalDiscountAmount))

        calculateDiscountPercent($('#total_discount_amount'))
    }




    //-----------------------------------------------------------------//
    //---------------- CALCULATING FREE DELIVERY CHARGE ---------------//
    //-----------------------------------------------------------------//


    //------------------ GET GLOBAL DISCOUNT METHOD -----------------//
    function getGlobalDiscount(subtotalWithVat){

        let discount            = 0;
        let minPurchaseAmount   = Number($('#globalMinPurchaseAmount').val());
        let freeDeliveryAmount  = Number($('#globalFreeDeliveryAmount').val());

        if (minPurchaseAmount > 0 && subtotalWithVat >= minPurchaseAmount) {
            discount = freeDeliveryAmount;
        }
        else if(freeDeliveryAmount > 0 && minPurchaseAmount == 0) {
            discount = freeDeliveryAmount;
        }

        console.log('Source => Global');
        console.log('SubtotalWithVat => '+subtotalWithVat);
        console.log('MinPurchaseAmount => '+minPurchaseAmount);
        console.log('Free_delivery_amount => '+freeDeliveryAmount);
        console.log('Discount => '+discount);

        return discount;

    }



    //------------------ GET DISTRICT DISCOUNT METHOD -----------------//
    function getDistrictDiscount(subtotalWithVat){

        let discount            = 0;
        let selectedDistrict    = $('.append-districts').val();

        if (selectedDistrict) {

            // let min_district_purchase_amount   = Number($('.append-districts option:selected').data('min_purchase_amount'));
            let min_district_purchase_amount   = Number($('.append-districts').find(':selected').data('min_purchase_amount'));
            // let free_district_delivery_amount  = Number($('.append-districts option:selected').data('free_delivery_amount'));
            let free_district_delivery_amount  = Number($('.append-districts').find(':selected').data('free_delivery_amount'));

            if (min_district_purchase_amount > 0 && subtotalWithVat >= min_district_purchase_amount) {

                discount = free_district_delivery_amount;

            } else if(free_district_delivery_amount > 0 && min_district_purchase_amount == 0) {
                discount = free_district_delivery_amount;
            }
            console.log('Source => District');
            console.log('SubtotalWithVat => '+subtotalWithVat);
            console.log('Min_district_purchase_amount => '+min_district_purchase_amount);
            console.log('Free_district_delivery_amount => '+free_district_delivery_amount);
            console.log('Discount => '+discount);
        }

        return discount;

    }




    //------------------ GET AREA DISCOUNT METHOD -----------------//
    function getAreaDiscount(subtotalWithVat){

        let discount        = 0;
        let selectedArea    = $('.append-areas').val();

        if (selectedArea) {

            let min_area_purchase_amount   = Number($('.append-areas').find(':selected').data('min_purchase_amount'));
            let free_area_delivery_amount  = Number($('.append-areas').find(':selected').data('free_delivery_amount'));

            if (min_area_purchase_amount > 0 && subtotalWithVat >= min_area_purchase_amount) {

                discount = free_area_delivery_amount;

            } else if(free_area_delivery_amount > 0 && min_area_purchase_amount == 0) {
                discount = free_area_delivery_amount;
            }
            console.log('Source => Area');
            console.log('SubtotalWithVat => '+subtotalWithVat);
            console.log('Min_area_purchase_amount => '+min_area_purchase_amount);
            console.log('Free_area_delivery_amount => '+free_area_delivery_amount);
            console.log('Discount => '+discount);
        }

        return discount;

    }





    //------------ GET FREE DELIVERY AMOUNT METHOD -----------//
    function getFreeDeliveryAmount(subtotalWithVat)
    {
        let discount            = 0;
        let freeDeliveryEnabled = $('#globalFreeDeliverySetting').val();

        console.log("freeDeliveryEnabled " + freeDeliveryEnabled)
        if (freeDeliveryEnabled) {

            let areaDiscount        = getAreaDiscount(subtotalWithVat);
            if (areaDiscount > 0) {
                return areaDiscount;
            }

            let districtDiscount    = getDistrictDiscount(subtotalWithVat);
            if (districtDiscount > 0) {
                return districtDiscount;
            }

            let globalDiscount      = getGlobalDiscount(subtotalWithVat);

            return globalDiscount;

        }

        return Number(discount);
    }




    //------------------ CHANGE AREA METHOD -----------------//
    function changeArea(obj){

        // let isDistrictSelected = $('.append-districts option:selected');

        // if (isDistrictSelected.length > 0) {

        //     let shippingCost                    = $('.append-districts option:selected').data('shipping_cost');
        //     let shipping_cost                   = Number(shippingCost)
        //     let shipping_cost_discount_amount   = $('.append-districts option:selected').data('shipping_cost_discount_amount');
        //     let shipping                        = Number(shippingCost) - Number(shipping_cost_discount_amount)

        //     $('#shipping_cost').val( shipping_cost )
        //     $('#total_shipping_cost').val( shipping_cost )

            calculateAllAmount();

        // }
    }


    //-----------------------------------------------------------------//
    //---------------- CALCULATING FREE DELIVERY CHARGE ---------------//
    //-----------------------------------------------------------------//





    function calculateAllAmount()
    {

        let freeDeliveryAmount = 0;
        let subtotal           = Number($('#subtotal').val());
        let totalVatPercent    = Number($('#total_vat_percent').val());
        let totalVatAmount     = Number($('#total_vat_amount').val());
        let discountAmount     = Number($('#total_discount_amount').val());
        let subtotalWithVat    = (subtotal + totalVatAmount);
        let totalShippingCost  = Number($('#total_shipping_cost').val());
        let cod_charge         = 0;
        let specilaDiscountAmount = Number($('#total_special_discount_amount').val());

        let isDistrictSelected  = $('.append-districts');

        if (isDistrictSelected.val()) {
            totalShippingCost       = Number(isDistrictSelected.find(':selected').data('shipping_cost'));
        }else{
            totalShippingCost = 0;
        }

        console.log('District wise shipping cost => '+totalShippingCost);

        //---------------- CALLING FREE DELIVERY CHARGE ---------------//
        freeDeliveryAmount         = getFreeDeliveryAmount(subtotalWithVat);

        if (freeDeliveryAmount > totalShippingCost) {
            totalShippingCost = 0;
        }else{
            totalShippingCost = totalShippingCost - freeDeliveryAmount;
        }
        console.log('TotalShippingCost => '+totalShippingCost);
        //---------------- CALLING FREE DELIVERY CHARGE ---------------//



        if(freeDeliveryAmount > 0) {
            cod_charge = 0
            $('#cod_charge').val(0)
        } else {
            cod_charge    = getCodCharge(subtotalWithVat + totalShippingCost - Math.round(discountAmount) - Math.round(specilaDiscountAmount) )
        }

        subtotalWithVat   +=  cod_charge
        let payableAmount = subtotalWithVat
        let paidAmount    = Number($('#paid_amount').val());
        let rounding      = payableAmount - subtotalWithVat;


        payableAmount         = payableAmount + totalShippingCost - discountAmount - specilaDiscountAmount;


        let dueAmount         = payableAmount - paidAmount;
        let changeAmount      = paidAmount - payableAmount;

        if (payableAmount > paidAmount) {
            changeAmount = 0
        }

        if (changeAmount > 0) {
            dueAmount = 0;
        }

        $('#shipping_cost').val( totalShippingCost );
        $('#total_shipping_cost').val( totalShippingCost );
        $('#payable_amount').val(Math.round(payableAmount));
        $('#rounding').val(rounding.toFixed(2));
        $('#due_amount').val(dueAmount.toFixed(2));
        $('#change_amount').val(changeAmount.toFixed(2));
    }




    function getCodCharge(payable_amount)
    {
        if($('.cod-charge-container').length > 0) {
            let cod_percent = Number($('#cod_percent').val())

            let cod_amount = ((payable_amount * cod_percent) / 100)
            cod_amount = cod_amount.toFixed(2)
            $('#cod_charge').val(cod_amount)

            return Number(cod_amount);
        }

        return 0;
    }



    /*
    |-------------------------------------------------------------------
    |            CLEAR ON SELECT A PRODUCT
    |--------------------------------------------------------------------
    */
    function clearTrData(obj){
        let tr = $(obj).closest('tr');

        tr.find('.pdt-discount-percent').val(0);
        tr.find('.pdt-total-discount-amount').val(0);
        tr.find('.pdt-vat-percent').val(0);
        tr.find('.pdt-vat-amount').val(0);
    }




    /*
    |-------------------------------------------------------------------
    |            GET PRODUCT VARIATION
    |--------------------------------------------------------------------
    */
    function getProductVariations(obj)
    {
        /*---------- Warehouse select validation----------*/
        if (warehouse_id == '') {
            warning('toastr', 'Please Select a Warehouse!');

            $(obj).closest('tr').find('.products').val('');
            $(obj).closest('tr').find('.products').select2();
            return;
        }

        clearTrData(obj);


        /*---------- Get seleceted product data----------*/

        let _this                   = $(obj).find('option:selected');

        // let _this                   = $(obj);
        let product_id              = _this.data('id');
        let product_name            = _this.data('name');
        let category                = _this.data('category');
        let unit_measure            = _this.data('unit-measure');
        let sku_code                = _this.data('sku');
        let purchase_price          = _this.data('purchase-price');
        let sale_price              = _this.data('sale-price');
        let pdt_discount_percent    = _this.data('sale-discount-percent');
        let vat_percent             = _this.data('vat-percent');
        let is_variation            = _this.data('is-variation');

        /*---------- Show seleceted product data----------*/
        let tr = $(obj).closest('tr');

        tr.find('.products').val(product_id);
        tr.find('.category').val(category);
        tr.find('.unit-measure').val(unit_measure);
        tr.find('.sku-code').val(sku_code);
        tr.find('.pdt-discount-percent').val(pdt_discount_percent);
        tr.find('.pdt-vat-percent').val(vat_percent);
        tr.find('.input-auto-search').val(product_name);



        /*---------- Get seleceted product variation----------*/
        let route = `{{ route('inv.sales.axios.get-product-variations') }}`;

        if(is_variation == 'No'){
            route = `{{ route('inv.sales.axios.get-product-measurements') }}`;
        }

        axios.get(route, {
            params: { product_id : product_id, warehouse_id : warehouse_id }
        })
        .then(function (response) {
            let data = response.data;
            emptyRow(obj);

            if (data != '' && is_variation == 'Yes') {

                $(obj).closest('tr').find('.product-is-variation').val('true');
                $(obj).closest('tr').find('.product-is-measurement').val('false');

                $(obj).closest('tr').find('.product-variations').prop('required', true);
                $(obj).closest('tr').find('.lots').prop('required', false);
                $(obj).closest('tr').find('.lots').empty().select2();
                $(obj).closest('tr').find('.lots').append(`<option value="" selected>- Select -</option>`).select2();

                data.map(function(productVariation, index) {
                    $(obj).closest('tr').find('.product-variations').append(`<option value="${ productVariation.id }" data-variation-purchase-price="${ productVariation.purchase_price }" data-variation-sale-price="${ productVariation.sale_price }" data-variation-current-stock="${ productVariation.current_stock }" data-is-variation="Yes">${ productVariation.name }</option>`).select2();
                })

                checkItemExistOrNot(obj)

            } else {

                if (data != ''){
                    $(obj).closest('tr').find('.product-is-variation').val('false');
                    $(obj).closest('tr').find('.product-is-measurement').val('true');
                    $(obj).closest('tr').find('.product-variations').prop('required', true);

                    data.map(function(productMeasurement, index) {
                        $(obj).closest('tr').find('.product-variations').append(`<option value="${ productMeasurement.id }" data-measurement-value="${ productMeasurement.value }" data-measurement-title="${ productMeasurement.title }" data-measurement-sku="${ productMeasurement.sku }" data-is-variation="No">${ productMeasurement.title }</option>`);
                    })
                    // $('.select2').select2()
                }


                getLots(obj, product_id)


                tr.find('.purchase-price').val(purchase_price);

                tr.find('.sale-price').val(sale_price);

                if (data == ''){
                    $(obj).closest('tr').find('.product-is-variation').val('false');
                    $(obj).closest('tr').find('.product-is-measurement').val('false');

                    tr.find('.product-variations').empty().select2();

                    tr.find('.product-variations').append(`<option value="" selected>- Select -</option>`).select2();
                    tr.find('.product-variations').prop('required', false);
                }



                calculateRowTotal()

                checkItemExistOrNot(obj)
            }
        })
        .catch(function (error) { });
        $('.live-load-content').hide();
    }




    function getProductVariations1(obj)
    {
        if (warehouse_id == '') {
            warning('toastr', 'Please Select a Warehouse!');

            $(obj).closest('tr').find('.products').val('');
            $(obj).closest('tr').find('.products').select2();
            return;
        }


        $(obj).closest('tr').find('.pdt-discount-percent').val('');
        $(obj).closest('tr').find('.pdt-total-discount-amount').val('');
        $(obj).closest('tr').find('.vat-percent').val('');
        $(obj).closest('tr').find('.pdt-total-vat-percent').val('');
        $(obj).closest('tr').find('.pdt-total-vat-amount').val('');

        const route = `{{ route('inv.sales.axios.get-product-variations') }}`;

        let _this                   = $(obj).find('option:selected');
        let product_id              = _this.val();
        let category                = _this.data('category');
        let unit_measure            = _this.data('unit-measure');
        let purchase_price          = _this.data('purchase-price');
        let sale_price              = _this.data('sale-price');
        let pdt_discount_percent    = _this.data('sale-discount-percent');
        let vat_percent             = _this.data('vat_percent');
        let vat_amount              = _this.data('vat-amount');
        let sku                     = _this.data('sku');



        $(obj).closest('tr').find('.category').val(category);
        $(obj).closest('tr').find('.unit-measure').val(unit_measure);
        $(obj).closest('tr').find('.sku-code').val(sku);
        $(obj).closest('tr').find('.pdt-discount-percent').val(pdt_discount_percent);

        $(obj).closest('tr').find('.vat_amount').val(vat_amount);

        $(obj).closest('tr').find('.vat-percent').val(vat_percent);



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

                calculateRowTotal()

                checkItemExistOrNot(obj)
            }
        })
        .catch(function (error) { });
    }

</script>




<script>
    /*
    |-------------------------------------------------------------------
    |            GET LOT
    |--------------------------------------------------------------------
    */
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
            $(obj).closest('tr').find('.stock').val(data);


            if (data != '') {
                $(obj).closest('tr').find('.lots').empty().select2();
                $(obj).closest('tr').find('.lots').append(`<option value="" selected>- Select -</option>`).select2();

                data.map(function(lot, index) {
                    $(obj).closest('tr').find('.lots').append(`<option value="${ lot }">${ lot }</option>`).select2();
                })

            }else{
                $(obj).closest('tr').find('.stock').val('');
                $(obj).closest('tr').find('.lots').empty().select2();
                $(obj).closest('tr').find('.lots').append(`<option value="" selected>- Select -</option>`).select2();


            }
        })
        .catch(function (error) { });
    }
</script>









<script>
    function getItemStock(obj)
    {
        const route = `{{ route('inv.sales.axios.get-item-stock') }}`;
        let product_id = $(obj).closest('tr').find('.products').val();
        let product_variation_id = $(obj).closest('tr').find('.product-variations').find('option:selected').val();
        let lot = $(obj).find('option:selected').val();

        if($(obj).closest('tr').find('.product-is-variation').val() == 'false'){
            product_variation_id = '';
        }
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
    function checkVariationItemExistOrNot(obj){

        let is_variation     = $(obj).find('option:selected').data('is-variation');

        if(is_variation == "Yes"){
            $(obj).closest('tr').find('.lots').val("");
            $(obj).closest('tr').find('.lots').select2();
            $(obj).closest('tr').find('.quantity').val('');
            $(obj).closest('tr').find('.total').val('');
            $(obj).closest('tr').find('.stock').val('');
            $(obj).closest('tr').find('.pdt-vat-amount').val(0);
        }


        calculateTotalCost();
        calculateTotalVatPercent();
        calculateSubtotal();
        totalDiscountAmount();
        calculateTotalVat();
        checkItemExistOrNot(obj);
        calculateAllAmount();
    }
    function checkItemExistOrNot(obj)
    {
        $(obj).closest('tr').find('.pdt-quantity').val('');
        $(obj).closest('tr').find('.total').val('');


        let product_option         = $(obj).closest('tr').find('.products').find('option:selected')
        let productId              = product_option.val();

        let lot                    = $(obj).closest('tr').find('.lots').find('option:selected').val();
        let variationId            = $(obj).closest('tr').find('.product-variations').find('option:selected').val();
        let variationPurchasePrice = Number($(obj).closest('tr').find('.product-variations').find('option:selected').data('variation-purchase-price')).toFixed(2);
        let variationSalePrice     = Number($(obj).closest('tr').find('.product-variations').find('option:selected').data('variation-sale-price')).toFixed(2);
        let variationStock         = Number($(obj).closest('tr').find('.product-variations').find('option:selected').data('variation-current-stock')).toFixed(2);
        let is_find = 0;
        let is_variation_obj       = $(obj).closest('tr').find('.product-is-variation').val();
        let is_measurement_obj     = $(obj).closest('tr').find('.product-is-measurement').val();


        let measurementTitle  = $(obj).closest('tr').find('.product-variations').find('option:selected').data('measurement-title');
        let measurementSku    = $(obj).closest('tr').find('.product-variations').find('option:selected').data('measurement-sku');
        let measurementValue  = $(obj).closest('tr').find('.product-variations').find('option:selected').data('measurement-value');

        if(is_variation_obj == "false"){
            $(obj).closest('tr').find('.product-variation-id').val('');
        }
        if(variationId != '' && is_variation_obj == 'false' && is_measurement_obj == 'true'){

            $(obj).closest('tr').find('.measurement-title').val(measurementTitle);
            $(obj).closest('tr').find('.measurement-sku').val(measurementSku);
            $(obj).closest('tr').find('.measurement-value').val(measurementValue);
            $(obj).closest('tr').find('.product-variation-id').val('');

            // let _this = $(obj).closest('tr').find('.products option:selected').data('sale-price');
            let salePrice     = product_option.data('sale-price') * measurementValue;
            let purchasePrice = product_option.data('purchase-price') * measurementValue;
            $(obj).closest('tr').find('.sale-price').val(salePrice);
            $(obj).closest('tr').find('.purchase-price').val(purchasePrice);


        }

        $('.products').each(function(index) {
            let product_id   = $(this).val();
            let lot_numbers  = $(this).closest('tr').find('.lots').val();
            let is_variation = $(this).closest('tr').find('.product-is-variation').val();
            let is_measurement = $(this).closest('tr').find('.product-is-measurement').val();
            let variation_id    = $(this).closest('tr').find('.product-variations').val();
            let measurement_sku = $(this).closest('tr').find('.measurement-sku').val();

            if (is_variation == 'true' && lot == '' & variation_id == variationId && variation_id != '') {

                getLots(obj, product_id, variationId)

                if (isNaN(variationPurchasePrice)) {
                    variationPurchasePrice = '';
                }

                if (isNaN(variationSalePrice)) {
                    variationSalePrice = '';
                }

                $(this).closest('tr').find('.purchase-price').val(variationPurchasePrice)
                $(this).closest('tr').find('.sale-price').val(variationSalePrice)
                $(obj).closest('tr').find('.product-variation-id').val(variationId);


                // $(obj).closest('tr').find('.purchase-price').val(variationPurchasePrice)
                // $(obj).closest('tr').find('.sale-price').val(variationSalePrice)
                // $(obj).closest('tr').find('.stock').val(variationStock)

            }

            if(is_variation_obj == 'true' && is_variation == "true"){
                if (product_id == productId && variationId == variation_id && lot == lot_numbers ) {
                    is_find += 1;
                }
           }else if(is_measurement_obj == 'true' && is_measurement == "true"){

                if ( measurementSku != '' && measurement_sku == measurementSku && is_variation_obj == 'false' && lot == lot_numbers ) {
                    is_find += 1;
                }
            }else{
                if (product_id == productId) {
                    is_find += 1;
                }
            }

        })


        if (is_find > 1) {
            warning('toastr', 'Item already exists!');
            $(obj).closest('tr').remove();


            // $(obj).closest('tr').find('.products').val('');
            // $(obj).closest('tr').find('.products').empty().select2();
            // $(obj).closest('tr').find('.products').select2({
            //     placeholder: "Select Product"
            // });

            $(obj).closest('tr').find('.input-auto-search').val('');
            // $(obj).closest('tr').find('.products').select2();
            $(obj).closest('tr').find('.category').val('');
            $(obj).closest('tr').find('.unit-measure').val('');
            $(obj).closest('tr').find('.sku-code').val('');
            $(obj).closest('tr').find('.lots').empty().select2();
            $(obj).closest('tr').find('.lots').append(`<option value="" selected>- Select -</option>`).select2();
            $(obj).closest('tr').find('.pdt-discount-percent').val('');

            emptyRow(obj)

            // $('.select2').select2()

            calculateTotalCost()
            calculateTotalVatPercent()
            calculateSubtotal()
            totalDiscountAmount()

            return;
        }
    }
</script>




<script>
    $(document).ready(function() {


        $('#sidebar').addClass('menu-min');
        // $('.products').select2({
        //         placeholder: "Select Product"
        // });

        let i = 0;
        let product_sn = 0;





        $("#addrow").on("click", function() {
            // rowItem.find('.product_id').addClass('product_id-'+i)

            $("#invoiceSaleTable").append(
                `<tr class="new-tr">
                    <input type="hidden" name="sale_detail_id[]" class="purchase-detail-id" value="">
                    <th width="25%" style="position: relative;">
                        <input type="hidden" class="product-is-variation" value="false">
                        <input type="hidden" class="product-is-measurement" value="false">
                        <select name="product_id[]" id="product_id" class="form-control products product_id product_id-${product_sn}" onchange="getProductVariations(this)" required>
                        </select>
                    </th>
                    <th width="15%">
                        <select name="" id="product_variation_id" class="form-control product-variations select2" onchange="checkItemExistOrNot(this)">
                            <option value="" selected>- Select -</option>
                        </select>
                    </th>
                    <th width="7%">
                        <input type="text" name="" id="sku" value="" class="form-control sku-code" readonly>
                    </th>
                    <th width="10%">
                        <input type="text" name="stock[]" id="stock" class="form-control text-center only-number stock" readonly>
                    </th>
                    <th width="7%">
                        <input type="text" name="unit_measure_id[]" id="unit_measure_id" class="form-control unit-measure" readonly>
                    </th>
                    <th width="10%">
                        <input type="hidden" name="purchase_price[]" id="purchase_price" class="form-control text-right only-number purchase-price" autocomplete="off" required>
                        <input type="number" name="sale_price[]" id="sale_price" class="form-control text-right only-number sale-price" autocomplete="off" onkeyup="calculateRowTotal(this)" required>
                    </th>
                    <th width="8%">
                        <input type="number" name="quantity[]" id="quantity" class="form-control text-center quantity pdt-quantity" autocomplete="off" onkeyup="calculateRowTotal(this)" required>
                    </th>
                    <th width="10%">
                        <input type="hidden"   name="product_variation_id[]" class="product-variation-id" value="">
                        <input type="hidden" name="measurement_title[]" class="measurement-title" value="{{ old('measurement_title') }}">
                        <input type="hidden" name="measurement_sku[]" class="measurement-sku" value="{{ old('measurement_sku') }}">
                        <input type="hidden" name="measurement_value[]" class="measurement-value" value="{{ old('measurement_value') }}">
                        <input type="hidden" name="vat_amount[]" class="pdt-vat-amount">
                        <input type="hidden" name="vat_percent[]" class="pdt-vat-percent">
                        <input type="hidden" name="purchase_total[]" id="purchase_total" class="form-control purchase-total text-right" readonly>
                        <input type="text" name="total[]" id="total" class="form-control total text-right" readonly>
                        <input type="hidden" name="discount_percent[]" class="form-control pdt-discount-percent text-right" readonly>
                        <input type="hidden" name="discount_amount[]" class="form-control pdt-total-discount-amount text-right" readonly>
                    </th>
                    <th width="5%" class="text-center">
                        <button type="submit" class="btn btn-sm btn-danger remove-row" title="Remove"><i class="fa fa-times"></i></button>
                    </th>
                </tr>`
            )

            $(".product_id-"+product_sn).select2({
                ajax: {
                    url: `{{ route('get-sale-products') }}`,
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
                placeholder: 'Search Product',
                minimumInputLength: 1,
                templateResult: formatProduct,
                templateSelection: formatProductSelection
            }).on('change', function(e) {

                let discount_percent = $(this).select2('data')[0].current_discount != null ? $(this).select2('data')[0].current_discount.discount_percentage : ($(this).select2('data')[0].discount_percentage > 0 ? $(this).select2('data')[0].discount_percentage : 0)

                $(this).html(`
                <option value='${ $(this).select2('data')[0].id }'
                    data-id                     = "${ $(this).select2('data')[0].id }"
                    data-name                   = "${ $(this).select2('data')[0].name }"
                    data-category               = "${ $(this).select2('data')[0].category.name }"
                    data-is-variation           = "${ $(this).select2('data')[0].is_variation }"
                    data-unit-measure           = "${ $(this).select2('data')[0].unit_measure.name }"
                    data-sku                    = "${ $(this).select2('data')[0].sku }"
                    data-purchase-price         = "${ Number($(this).select2('data')[0].purchase_price) }"
                    data-sale-price             = "${ Number($(this).select2('data')[0].sale_price) }"
                    data-sale-discount-percent  = "${ discount_percent }"
                    data-vat-percent            = "${ getVatPercent($(this).select2('data')[0].vat, $(this).select2('data')[0].vat_type, $(this).select2('data')[0].sale_price, 0)}"
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



            i++
            product_sn++
        });

        $("#invoiceSaleTable").on("click", ".remove-row", function(event) {
            $(this).closest("tr").remove();
            // $('.product_id').select2();

            calculateTotalCost()
            calculateTotalVatPercent()
            calculateSubtotal()
            totalDiscountAmount()
            calculateTotalVat()

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

        $('#total_discount_amount').val(Math.round(discountAmount));

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
     | CALCULATE DISCOUNT AMOUNT
     |--------------------------------------------------------------------------
    */
    function calculateSpecialDiscountAmount(obj)
    {
        let subtotal = $('#subtotal').val();

        let discountPercent = parseFloat($(obj).val());
        let discountAmount = parseFloat(subtotal - (subtotal - ( subtotal * discountPercent / 100 )));

        if (isNaN(discountAmount)) {
            discountAmount = 0;
        }

        $('#total_special_discount_amount').val(Math.round(discountAmount));

        calculateAllAmount()
    }





    /*
     |--------------------------------------------------------------------------
     | CALCULATE DISCOUNT PERCENT
     |--------------------------------------------------------------------------
    */
    function calculateSpecialDiscountPercent(obj)
    {
        let subtotal = $('#subtotal').val();

        let discountAmount = parseFloat($(obj).val());
        let discountPercent = (discountAmount / subtotal) * 100;

        if (isNaN(discountPercent)) {
            discountPercent = 0
        }

        $('#total_special_discount_percent').val(discountPercent.toFixed(2));

        calculateAllAmount()
    }





    getCustomerInfo($('#customerId'))


    function getCustomerInfo(obj)
    {
        let name = $(obj).find('option:selected').text();
        let phone = $(obj).find('option:selected').data('phone');
        let email = $(obj).find('option:selected').data('email');
        let address = $(obj).find('option:selected').data('address');
        setCustomerInfo(name, phone, email, address)
    }



    function setCustomerInfo(name, phone, email, address)
    {
        $('#customer_name').val(name);
        $('#customer_phone').val(phone);
        $('#customer_email').val(email);
        $('#customer_address').text(address);
        calculateAllAmount()
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

        // $('.select2').select2()

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
