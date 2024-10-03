<script>
    $(document).ready(function () {
        cartload();
    })




    /*
     |--------------------------------------------------------------------------
     | CART LOAD METHOD
     |--------------------------------------------------------------------------
    */
    function cartload()
    {
        $.ajax({
            url: "{{ route('load-cart-data') }}",
            method: "GET",
            success: function (response) {
                $('#myHeaderCart').html(response);
            }
        });
    }




    /*
     |--------------------------------------------------------------------------
     | FLY TO CART METHOD
     |--------------------------------------------------------------------------
    */
    function flyToCart(object, cart)
    {
        let imgtodrag = $(object).closest('.this-product').find('.this-image').eq(0);

        if (imgtodrag) {
            let imgclone = imgtodrag.clone().offset({
                top: imgtodrag.offset().top,
                left: imgtodrag.offset().left
            }).css({
                'opacity': '0.8',
                'position': 'absolute',
                'height': '150px',
                'width': '150px',
                'z-index': '100000'
            }).appendTo($('body')).animate({
                'top': cart.offset().top + 20,
                'left': cart.offset().left + 30,
                'width': 75,
                'height': 75
            }, 1000, 'easeInOutExpo');

            imgclone.animate({
                'width': 0,
                'height': 0
            }, function () {
                $(this).detach()
            });
        }
    }




    /*
     |--------------------------------------------------------------------------
     | ADD TO CART METHOD
     |--------------------------------------------------------------------------
    */
    let quantity = 0;
    function addToCart(object){

        let cart = $('#cart_items');

        flyToCart(object, cart)

        let product_id = $(object).data('product-id');

        quantity++;

        $.ajax({
            url: "{{ route('add-to-cart') }}",
            method: "POST",
            data: {
                'quantity': quantity,
                'product_id': product_id,
            },
            success: function (response) {
                cartload();
            },
        });
    }




    /*
     |--------------------------------------------------------------------------
     | UPDATE CART QTY METHOD
     |--------------------------------------------------------------------------
    */
    function updateCartQty(object, price, discountPrice)
    {
        cartload();

        let quantity = $(object).find('option:selected').val();
        let product_id = $(object).find('option:selected').data('product-id');

        let data = {
            'quantity':quantity,
            'product_id':product_id,
        };

        $.ajax({
            url: "{{ route('update-cart-qty') }}",
            type: 'POST',
            data: data,
            success: function (response) {
                cartload();
                calculateItemPrice(object, price, discountPrice);
            }
        });
    }




    /*
     |--------------------------------------------------------------------------
     | CALCULATE ITEM PRICE METHOD
     |--------------------------------------------------------------------------
    */
    function calculateItemPrice(object, price, discountPrice) {

        let quantity = $(object).find('option:selected').val();
        let total  = parseFloat(quantity) * parseFloat(price);
        let totalWithDisc  = parseFloat(quantity) * parseFloat(discountPrice);

        let _this = $(object);
        _this.closest('.item-row').find('.item-total-price').val(total.toFixed(2));
        _this.closest('.item-row').find('.item-total-price-with-disc').text(totalWithDisc.toFixed(2));

        subTotal()
        discount()
        grandTotal()
    }




    /*
     |--------------------------------------------------------------------------
     | SUB TOTAL METHOD
     |--------------------------------------------------------------------------
    */
    function subTotal()
    {
        let price = 0;

        $('.item-total-price').each(function(key, value){
            let pr = $(value).val();
            price += parseFloat(pr);
        })

        $('.cart-sub-total').text(price.toFixed(2))

        discount()
    }




    /*
     |--------------------------------------------------------------------------
     | CART TOTAL DISCOUNT METHOD
     |--------------------------------------------------------------------------
    */
    function discount()
    {
        let subTotal = $('.cart-sub-total').text();
        let grandTotal = $('.cart-grand-total-inline').text();
        let discount = parseFloat(grandTotal) - parseFloat(subTotal);

        $('.cart-total-discount').text(discount.toFixed(2))
        $('.cart-total-discount').text($('.cart-total-discount').text().replace("-", " "));
    }




    /*
     |--------------------------------------------------------------------------
     | GRAND TOTAL METHOD
     |--------------------------------------------------------------------------
    */
    function grandTotal()
    {
        let price = 0;

        $('.item-total-price-with-disc').each(function(key, value){
            let pr = $(value).text().replace(/^\s+|\s+$/gm,'');
            price += parseFloat(pr);
        })

        $('.cart-grand-total').text(price.toFixed(2))

        discount()
    }




    /*
     |--------------------------------------------------------------------------
     | DELETE FROM CART METHOD
     |--------------------------------------------------------------------------
    */
    function deleteFromCart(object)
    {
        let _this = $(object);
        let product_id = $(object).data('product-id');

        let data = {
            "product_id": product_id,
        };

        $.ajax({
            url: "{{ route('delete-from-cart') }}",
            type: 'DELETE',
            data: data,
            success: function (response) {
                cartload();
                _this.parents('.item-row').remove();

                subTotal()
                discount()
                grandTotal()
            }
        });
    }
</script>
