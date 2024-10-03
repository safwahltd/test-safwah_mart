$(document).ready(function () {
    $('#sign-in-form').submit(function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.post({
            url: 'https://demo.6amtech.com/6valley/customer/auth/login',
            dataType: 'json',
            data: $('#sign-in-form').serialize(),
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (data) {
                if (data.errors) {
                    for (var i = 0; i < data.errors.length; i++) {
                        toastr.error(data.errors[i].message, {
                            CloseButton: true,
                            ProgressBar: true
                        });
                    }
                } else {
                    toastr.success(data.message, {
                        CloseButton: true,
                        ProgressBar: true
                    });
                    setInterval(function () {
                        location.href = data.url;
                    }, 2000);
                }
            },
            complete: function () {
                $('#loading').hide();
            },
            error: function () {
                toastr.error('Credentials do not match or account has been suspended.', {
                    CloseButton: true,
                    ProgressBar: true
                });
            }
        });
    });
})