
function success(type, message)
{

    if(type == 'toastr') {

        toastr.options = {
            "closeButton" : true,
            "progressBar" : true
        }

        toastr.success(message)

    } else {

    }

}
function warning(type, message)
{

    if(type == 'toastr') {

        toastr.options = {
            "closeButton" : true,
            "progressBar" : true
        }

        toastr.warning(message)

    } else {

    }

}
function info(type, message)
{

    if(type == 'toastr') {

        toastr.options = {
            "closeButton" : true,
            "progressBar" : true
        }

        toastr.info(message)

    } else {

    }

}
