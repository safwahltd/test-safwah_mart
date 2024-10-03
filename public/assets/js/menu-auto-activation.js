

let path = window.location.href

path = path.replace('#', '')

let selector = "a[href='" + path + "']"





if (!$(selector).closest('li').hasClass('hasQuery')) {
    path = path.split('?')[0]
    selector = "a[href='" + path + "']"
}




if ($(selector).length < 1) {

    selector = selector.substring(0, selector.lastIndexOf('/'))

    if ($(selector).length < 1) {

        selector = selector.substring(0, selector.lastIndexOf('/'))
    }
}






let li_tag = $(selector).closest('li')

li_tag.addClass('active')




li_tag.parents('li').add(this).each(function() {

    $(this).addClass('open')

});





// --------------------------------------------------------------
//  EMPTY MENU AUTO HIDE/REMOVE
// --------------------------------------------------------------

$(document).on('ready', function() {
    $('.nav-list>li>ul').each(function() {


        $.each($(this).find('li>ul'), function() {

            $.each($(this).find('li>ul'), function() {


                if ($(this).children().length == 0) {
                    $(this).parent().remove()
                }
            })

            if ($(this).children().length == 0) {
                $(this).parent().remove()
            }
        })

        if ($(this).find('li').length == 0) {
            $(this).parent().remove()
        }
    })
})