$(document).ready(function () {
    $('.card-header').click(function() {
        $('.card-header').removeClass('active');
        $(this).addClass('active');
    });

});
function get_categories(route) {
    $.get({
        url: route,
        dataType: 'json',
        beforeSend: function () {
            $('#loading').show();
        },
        success: function (response) {
            $('html,body').animate({scrollTop: $("#ajax-category").offset().top}, 'slow');
            $('#ajax-category').html(response.view);
        },
        complete: function () {
            $('#loading').hide();
        },
    });
}
