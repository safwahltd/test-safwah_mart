$(document).ready(function () {
    cartQuantityInitialize();
    getVariantPrice();
    $('#add-to-cart-form input').on('change', function () {
        getVariantPrice();
    });

    function showInstaImage(link) {
        $("#attachment-view").attr("src", link);
        $('#show-modal-view').modal('toggle')
    }

    $('#contact-seller').on('click', function (e) {
        // $('#seller_details').css('height', '200px');
        $('#seller_details').animate({'height': '276px'});
        $('#msg-option').css('display', 'block');
    });
    $('#sendBtn').on('click', function (e) {
        e.preventDefault();
        let msgValue = $('#msg-option').find('textarea').val();
        let data = {
            message: msgValue,
            shop_id: $('#msg-option').find('textarea').attr('shop-id'),
            seller_id: $('.msg-option').find('.seller_id').attr('seller-id'),
        }
        if (msgValue != '') {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });

            $.ajax({
                type: "post",
                url: 'https://demo.6amtech.com/6valley/messages-store',
                data: data,
                success: function (respons) {
                    console.log('send successfully');
                }
            });
            $('#chatInputBox').val('');
            $('#msg-option').css('display', 'none');
            $('#contact-seller').find('.contact').attr('disabled', '');
            $('#seller_details').animate({'height': '125px'});
            $('#go_to_chatbox').css('display', 'block');
        } else {
            console.log('say something');
        }
    });
    $('#cancelBtn').on('click', function (e) {
        e.preventDefault();
        $('#seller_details').animate({'height': '114px'});
        $('#msg-option').css('display', 'none');
    });
})
