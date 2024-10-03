
<script>
    function autocompleteSearch(object)
    {
        let search = $(object).val();

        let query = '<div style="padding: 40px; text-align: center">'+
            'No products for query '+'<strong>"'+search+'"</strong>'+
            '</div>';

        $.ajax({
            type : 'GET',
            url : '{{ route('autocomplete-search') }}',
            data:{search:search},
            success:function(data){
                if ($(object).val().length > 0) {
                    if (data === '') {
                        $('#autoCompleteDiv').show();
                        $('#autoCompleteDiv').html(query);
                    } else {

                        $('#autoCompleteDiv').show();
                        $('#sub_category_id').empty();


                        let output = [];
                        let publicPath = '{{ asset("/") }}';
                        $.each(data, function (key, item) {

                            output += `<tr class="this-product">
                                        <td width="15%" style="padding: 10px !important;">
                                            <a href="#">
                                                <img src="${publicPath + item.image}" class="this-image" width="50">
                                            </a>
                                        </td>
                                        <td width="75%" style="padding: 10px !important;">
                                            <a href="#">
                                                <small>${item.name}</small>
                                            </a>
                                        </td>
                                        <td width="10%" style="padding: 10px !important;">
                                            <a href="javascript:void(0)" onclick="addToCart(this)"
                                               data-product-id="${item.id}">
                                                <i class="czi-cart" style=""></i>
                                            </a>
                                        </td>
                                    </tr>`

                        })

                        $('#productRow').html(output);
                    }
                } else {
                    $('#autoCompleteDiv').hide();
                }
            }
        });

    }

    // (function ($) {
    //     $('#q').on('focusout', function () {
    //         $('#autoCompleteDiv').hide();
    //     })
    // })(jQuery);

</script>
