$(document).ready(function () {
    function openNav() {
        document.getElementById("mySidepanel").style.width = "50%";
    }

    function closeNav() {
        document.getElementById("mySidepanel").style.width = "0";
    }

    function filter(value) {
        $.get({
            url: 'https://demo.6amtech.com/6valley/products',
            data: {
                id: '',
                name: '',
                data_from: 'search',
                min_price: '',
                max_price: '',
                sort_by: value
            },
            dataType: 'json',
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (response) {
                $('#ajax-products').html(response.view);
            },
            complete: function () {
                $('#loading').hide();
            },
        });
    }


    function searchByPrice() {
        let min = $('#min_price').val();
        let max = $('#max_price').val();
        $.get({
            url: 'https://demo.6amtech.com/6valley/products',
            data: {
                id: '',
                name: '',
                data_from: 'search',
                sort_by: 'latest',
                min_price: min,
                max_price: max,
            },
            dataType: 'json',
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (response) {
                $('#ajax-products').html(response.view);
                $('#paginator-ajax').html(response.paginator);
            },
            complete: function () {
                $('#loading').hide();
            },
        });
    }

    $('#searchByFilterValue, #searchByFilterValue-m').change(function () {
        var url = $(this).val();
        if (url) {
            window.location = url;
        }
        return false;
    });

    $("#search-coupon-m").on("keyup", function () {
        var value = this.value.toLowerCase().trim();
        $("#lista1 div>li").show().filter(function () {
            return $(this).text().toLowerCase().trim().indexOf(value) == -1;
        }).hide();
    });
})
