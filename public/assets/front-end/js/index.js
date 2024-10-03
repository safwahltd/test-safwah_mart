$(function () {
    $('.list-group-item').on('click', function () {
        $('.glyphicon', this)
            .toggleClass('glyphicon-chevron-right')
            .toggleClass('glyphicon-chevron-down');
    });

    function addWishlist(product_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "https://demo.6amtech.com/6valley/store-wishlist",
            method: 'POST',
            data: {
                product_id: product_id
            },
            success: function (data) {
                if (data.value == 1) {
                    Swal.fire({
                        position: 'top-end',
                        type: 'success',
                        title: data.success,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    $('.countWishlist').html(data.count);
                    $('.countWishlist-' + product_id).text(data.product_count);
                    $('.tooltip').html('');
                    /*$('.wishlist' + data.id).html('<button type="button" class="btn" title="Add to wishlist" onclick="addWishlist(' + data.id + ')" style="background-color: transparent ;font-size: 18px; height: 45px; color: #9E9E9E; border: 2px solid #9E9E9E;">' +
                        '                       <i class="fa fa-heart-o mr-2" aria-hidden="true"></i>' +
                        '                   </button>');*/

                } else if (data.value == 2) {
                    Swal.fire({
                        type: 'info',
                        title: 'WishList',
                        text: data.error
                    });
                } else {
                    Swal.fire({
                        type: 'error',
                        title: 'WishList',
                        text: data.error
                    });
                }
            }
        });
    }

    function removeWishlist(product_id) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            url: "https://demo.6amtech.com/6valley/delete-wishlist",
            method: 'POST',
            data: {
                id: product_id
            },
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (data) {
                Swal.fire({
                    type: 'success',
                    title: 'WishList',
                    text: data.success
                });
                $('.countWishlist').html(data.count);
                $('#set-wish-list').html(data.wishlist);
                $('.tooltip').html('');
                /*$('.wishlist' + data.id).html('<button type="button" class="btn" title="Add to wishlist" onclick="addWishlist(' + data.id + ')" style="background-color: transparent ;font-size: 18px; height: 45px; color: #9E9E9E; border: 2px solid #9E9E9E;">' +
                    '                       <i class="fa fa-heart-o mr-2" aria-hidden="true"></i>' +
                    '                   </button>');*/
            },
            complete: function () {
                $('#loading').hide();
            },
        });
    }

    function quickView(product_id) {
        $.get({
            url: 'https://demo.6amtech.com/6valley/quick-view',
            dataType: 'json',
            data: {
                product_id: product_id
            },
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (data) {
                console.log("success...")
                $('#quick-view').modal('show');
                $('#quick-view-modal').empty().html(data.view);
            },
            complete: function () {
                $('#loading').hide();
            },
        });
    }

    function addToCart(form_id = 'add-to-cart-form') {
        if (checkAddToCartValidity()) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.post({
                url: 'https://demo.6amtech.com/6valley/cart/add',
                data: $('#' + form_id).serializeArray(),
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    console.log(data)
                    if (data.data == 1) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Cart',
                            text: "Product already added in cart"
                        });
                        return false;
                    } else if (data.data == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Cart',
                            text: 'Sorry, product out of stock.'
                        });
                        return false;
                    }
                    $('.call-when-done').click();

                    toastr.success('Item has been added in your cart!', {
                        CloseButton: true,
                        ProgressBar: true
                    });

                    updateNavCart();
                    updateToolbar();
                },
                complete: function () {
                    $('#loading').hide();
                }
            });
        } else {
            Swal.fire({
                type: 'info',
                title: 'Cart',
                text: 'Please choose all the options'
            });
        }
    }

    function buy_now() {
        addToCart();
        location.href = "https://demo.6amtech.com/6valley/checkout-details";
    }

    function currency_change(currency_code) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type: 'POST',
            url: 'https://demo.6amtech.com/6valley/currency',
            data: {
                currency_code: currency_code
            },
            success: function (data) {
                toastr.success('Currency changed to' + data.name);
                location.reload();
            }
        });
    }

    function removeFromCart(key) {
        $.post('https://demo.6amtech.com/6valley/cart/remove', {_token: 'sBLUO6cCUqSFdnXntitovORvMRc7UVKFAGa67QMH', key: key}, function (data) {
            updateNavCart();
            updateToolbar();
            $('#cart-summary').empty().html(data);
            toastr.info('Item has been removed from cart', {
                CloseButton: true,
                ProgressBar: true
            });
        });
    }

    function updateNavCart() {
        $.post('https://demo.6amtech.com/6valley/cart/nav-cart-items', {_token: 'sBLUO6cCUqSFdnXntitovORvMRc7UVKFAGa67QMH'}, function (data) {
            $('#cart_items').html(data);
        });
    }

    function updateToolbar() {
        $.post('https://demo.6amtech.com/6valley/cart/toolbar', {_token: 'sBLUO6cCUqSFdnXntitovORvMRc7UVKFAGa67QMH'}, function (data) {
            $('#toolbar').html(data);
        });
    }

    function cartQuantityInitialize() {
        $('.btn-number').click(function (e) {
            e.preventDefault();

            fieldName = $(this).attr('data-field');
            type = $(this).attr('data-type');
            var input = $("input[name='" + fieldName + "']");
            var currentVal = parseInt(input.val());

            if (!isNaN(currentVal)) {
                if (type == 'minus') {

                    if (currentVal > input.attr('min')) {
                        input.val(currentVal - 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('min')) {
                        $(this).attr('disabled', true);
                    }

                } else if (type == 'plus') {

                    if (currentVal < input.attr('max')) {
                        input.val(currentVal + 1).change();
                    }
                    if (parseInt(input.val()) == input.attr('max')) {
                        $(this).attr('disabled', true);
                    }

                }
            } else {
                input.val(0);
            }
        });

        $('.input-number').focusin(function () {
            $(this).data('oldValue', $(this).val());
        });

        $('.input-number').change(function () {

            minValue = parseInt($(this).attr('min'));
            maxValue = parseInt($(this).attr('max'));
            valueCurrent = parseInt($(this).val());

            var name = $(this).attr('name');
            if (valueCurrent >= minValue) {
                $(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Cart',
                    text: 'Sorry, the minimum value was reached'
                });
                $(this).val($(this).data('oldValue'));
            }
            if (valueCurrent <= maxValue) {
                $(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Cart',
                    text: 'Sorry, stock limit exceeded.'
                });
                $(this).val($(this).data('oldValue'));
            }


        });
        $(".input-number").keydown(function (e) {
            // Allow: backspace, delete, tab, escape, enter and .
            if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
                // Allow: Ctrl+A
                (e.keyCode == 65 && e.ctrlKey === true) ||
                // Allow: home, end, left, right
                (e.keyCode >= 35 && e.keyCode <= 39)) {
                // let it happen, don't do anything
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
                e.preventDefault();
            }
        });
    }

    function updateQuantity(key, element) {
        $.post('https://demo.6amtech.com/6valley/cart/updateQuantity', {
            _token: 'sBLUO6cCUqSFdnXntitovORvMRc7UVKFAGa67QMH',
            key: key,
            quantity: element.value
        }, function (data) {
            updateNavCart();
            updateToolbar();
            $('#cart-summary').empty().html(data);
        });
    }

    function updateCartQuantity(key) {
        var quantity = $("#cartQuantity" + key).children("option:selected").val();
        $.post('https://demo.6amtech.com/6valley/cart/updateQuantity', {
            _token: 'sBLUO6cCUqSFdnXntitovORvMRc7UVKFAGa67QMH',
            key: key,
            quantity: quantity
        }, function (data) {
            console.log(data);
            if (data['data'] == 0) {
                toastr.error('Sorry, stock limit exceeded.', {
                    CloseButton: true,
                    ProgressBar: true
                });
                $("#cartQuantity" + key).val(data['qty']);
            } else {
                toastr.info('Quantity updated!', {
                    CloseButton: true,
                    ProgressBar: true
                });
                updateNavCart();
                updateToolbar();

                $('#cart-summary').empty().html(data);
            }


        });
    }

    $('#add-to-cart-form input').on('change', function () {
        getVariantPrice();
    });

    function getVariantPrice() {
        if ($('#add-to-cart-form input[name=quantity]').val() > 0 && checkAddToCartValidity()) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: 'https://demo.6amtech.com/6valley/cart/variant_price',
                data: $('#add-to-cart-form').serializeArray(),
                success: function (data) {
                    console.log(data)
                    $('#add-to-cart-form #chosen_price_div').removeClass('d-none');
                    $('#add-to-cart-form #chosen_price_div #chosen_price').html(data.price);
                    $('#set-tax-amount').html(data.tax);
                    $('#set-discount-amount').html(data.discount);
                    $('#available-quantity').html(data.quantity);
                    $('.cart-qty-field').attr('max', data.quantity);
                }
            });
        }
    }

    function checkAddToCartValidity() {
        var names = {};
        $('#add-to-cart-form input:radio').each(function () { // find unique names
            names[$(this).attr('name')] = true;
        });
        var count = 0;
        $.each(names, function () { // then count them
            count++;
        });
        if ($('input:radio:checked').length == count) {
            return true;
        }
        return false;
    }

    $(document).ready(function () {
        $('#popup-modal').appendTo("body").modal('show');
    });

    $(".clickable").click(function() {
        window.location = $(this).find("a").attr("href");
        return false;
    });

    function couponCode() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        });
        $.ajax({
            type: "POST",
            url: 'https://demo.6amtech.com/6valley/coupon/apply',
            data: $('#coupon-code-ajax').serializeArray(),
            success: function (data) {
                if (data.status == 1) {
                    let ms = data.messages;
                    ms.forEach(
                        function (m, index) {
                            toastr.success(m, index, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    );
                } else {
                    let ms = data.messages;
                    ms.forEach(
                        function (m, index) {
                            toastr.error(m, index, {
                                CloseButton: true,
                                ProgressBar: true
                            });
                        }
                    );
                }
                setInterval(function () {
                    location.reload();
                }, 2000);
            }
        });
    }

    jQuery(".search-bar-input").keyup(function () {
        $(".search-card").css("display", "block");
        let name = $(".search-bar-input").val();
        if (name.length > 0) {
            $.get({
                url: 'https://demo.6amtech.com/6valley/searched-products',
                dataType: 'json',
                data: {
                    name: name
                },
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('.search-result-box').empty().html(data.result)
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        } else {
            $('.search-result-box').empty();
        }
    });

    jQuery(".search-bar-input-mobile").keyup(function () {
        $(".search-card").css("display", "block");
        let name = $(".search-bar-input-mobile").val();
        if (name.length > 0) {
            $.get({
                url: 'https://demo.6amtech.com/6valley/searched-products',
                dataType: 'json',
                data: {
                    name: name
                },
                beforeSend: function () {
                    $('#loading').show();
                },
                success: function (data) {
                    $('.search-result-box').empty().html(data.result)
                },
                complete: function () {
                    $('#loading').hide();
                },
            });
        } else {
            $('.search-result-box').empty();
        }
    });

    jQuery(document).mouseup(function (e) {
        var container = $(".search-card");
        if (!container.is(e.target) && container.has(e.target).length === 0) {
            container.hide();
        }
    });

    const img = document.getElementByTagName("img")
    img.addEventListener("error", function(event) {
        event.target.src = 'https://demo.6amtech.com/6valley/public/assets/front-end/img/image-place-holder.png';
        event.onerror = null
    })
});
