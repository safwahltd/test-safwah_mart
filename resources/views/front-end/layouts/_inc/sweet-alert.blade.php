<script>
    function showAlertMessage(message, time = 5000, type = 'error')
    {
        swal.fire({
            title: type.toUpperCase(),
            html: "<b>" + message + "</b>",
            type: type,
            timer: time
        })
    }


    @if(session()->get('message'))
    swal.fire({
        title: "Success",
        html: "<b>{{ session()->get('message') }}</b>",
        type: "success",
        timer: 5000
    });
    @elseif(session()->get('error'))
    swal.fire({
        title: "Error",
        html: "<b>{{ session()->get('error') }}</b>",
        type: "error",
        timer: 5000
    });
    @endif
</script>
