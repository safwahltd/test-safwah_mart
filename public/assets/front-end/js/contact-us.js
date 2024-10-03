$(document).ready(function () {
    $('#contactForm').on('submit',function(event){
        event.preventDefault();

        name = $('.name').val();
        email = $('.email').val();
        mobile_number = $('.mobile_number').val();
        subject = $('.subject').val();
        message = $('.message').val();

        $.ajax({
            url: "https://demo.6amtech.com/6valley/admin/contact/contact-store",
            type:"POST",
            data:{
                "_token": "sBLUO6cCUqSFdnXntitovORvMRc7UVKFAGa67QMH",
                name:name,
                email:email,
                mobile_number:mobile_number,
                subject:subject,
                message:message,
            },
            success:function(response){
                toastr.success(response.success);
                $('#contactForm').trigger('reset');
                $('.invalid-feedback').remove();
                // window.location.reload();


            },
        });
    });
})