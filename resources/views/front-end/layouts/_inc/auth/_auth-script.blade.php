<script>

    /*
     |--------------------------------------------------------------------------
     | GIVEN PASSWORD METHOD
     |--------------------------------------------------------------------------
    */
    function givenPassword(object)
    {
        let password = $(object).val();
        let confirmPassword = $(object).closest('#registerForm').find('#reg_confirm_password').val();

        if (confirmPassword.length > 0 && password.length >= 8 && password != confirmPassword) {

            $('#confirmPwdMsg').show();
            $('#confirmPwdMsg').html('<span class="text-danger">Password & Confirm Password didn\'t match</span>');
            $('#btnRegister').prop('disabled', true);

            $('#pwdMsg').hide();
            $('#btnRegister').prop('disabled', false);

        } else if (password.length < 8) {

            $('#pwdMsg').show();
            $('#pwdMsg').html('<span class="text-danger">Password Must be at least 8 characters.</span>');
            $('#btnRegister').prop('disabled', true);

        } else {

            $('#pwdMsg').hide();
            $('#btnRegister').prop('disabled', false);
        }
    }




    /*
     |--------------------------------------------------------------------------
     | CONFIRM PASSWORD METHOD
     |--------------------------------------------------------------------------
    */
    function confirmPassword(object)
    {
        let confirmPassword = $(object).val();
        let password = $(object).closest('#registerForm').find('#reg_password').val();


        if (confirmPassword.length >= 8 && password != confirmPassword) {

            $('#confirmPwdMsg').show();
            $('#confirmPwdMsg').html('<span class="text-danger">Password & Confirm Password didn\'t match</span>');
            $('#btnRegister').prop('disabled', true);

        } else if (confirmPassword.length >= 8 && password == confirmPassword) {

            $('#confirmPwdMsg').hide();
            $('#btnRegister').prop('disabled', false);

        } else {

            $('#confirmPwdMsg').hide();
            $('#btnRegister').prop('disabled', true);
        }
    }




    /*
     |--------------------------------------------------------------------------
     | DISMISS METHOD
     |--------------------------------------------------------------------------
    */
    function dismissModal()
    {
        $('#name').val('');
        $('#email').val('');
        $('#phone').val('');
        $('#login_phone').val('');
        $('#my_otp').val('');
        $('#reg_password').val('');
        $('#login_password').val('');
        $('#reg_confirm_password').val('');
        $('#forgot_pass_phone').val('');
        $('#forgot_pass_otp').val('');
        $('#forgot_new_password').val('');
        $('#forgot_confirm_password').val('');
        $('#getForgotPassOTP').val('');
        $("#accept").prop("checked", false);
        $('#myOTP').hide()
        $('#sendOTPMessage').hide()
    }




    /*
     |--------------------------------------------------------------------------
     | CHECK EMAIL METHOD
     |--------------------------------------------------------------------------
    */
    function checkEmail(object)
    {
        let email = $(object).val();

        if (email.length > 0) {
            $.ajax({
                type : "POST",
                url : "{{ route('cus-auth.check-email') }}",
                data: {email: email},
                success: function (resp) {
                    if (resp == 'exists') {
                        $(object).closest('#registerForm').find('#emailMsg').show();
                        $('#emailMsg').html('<span class="text-danger">Email already Exists!</span>');
                    } else {
                        $('#emailMsg').hide();
                    }
                }, error: function () {
                    alert("Error");
                }
            });
        }
    }




    /*
     |--------------------------------------------------------------------------
     | CHECK PHONE METHOD
     |--------------------------------------------------------------------------
    */
    function checkPhone(object)
    {
        let phone = $(object).val();

        if (phone.length == 11) {
            $.ajax({
                type : "POST",
                url : "{{ route('cus-auth.check-phone') }}",
                data: {phone: phone},
                success: function (resp) {
                    console.log(resp)
                    if (resp == 'exists') {
                        $(object).closest('#registerForm').find('#phoneMsg').show();
                        $('#phoneMsg').html('<span class="text-danger">Phone already Exists!</span>');
                        $('#btnSendOTP').prop('disabled', true);
                    } else {
                        $('#btnSendOTP').prop('disabled', false);
                        $('#phoneMsg').hide();
                    }
                }, error: function () {
                    alert("Error");
                }
            });
        } else {
            $(object).closest('#registerForm').find('#phoneMsg').show();
            $('#phoneMsg').html('<span class="text-dark">Phone must be 11 digits!</span>');
        }
    }




    /*
     |--------------------------------------------------------------------------
     | SEND OTP METHOD
     |--------------------------------------------------------------------------
    */
    function sendOTP(object)
    {
        let phone =  $(object).closest('#registerForm').find('#phone').val();

        $.ajax({

            type : "POST",
            url : "{{ route('cus-auth.get-otp') }}",
            data: {phone: phone},
            success: function (resp) {

                $(object).closest('#registerForm').find('#phoneMsg').show();
                $(object).closest('#registerForm').find('#myOTP').show();
                $('#phoneMsg').html('<span class="text-success">'+resp.message+'</span>');
                $(object).closest('#registerForm').find('#getOTP').val(resp.myOTP);
                $(object).prop('disabled', true);

                setTimeout(function(){
                    $('#phoneMsg').hide()
                }, 5000)

                console.log(resp.myOTP)
            }, error: function () {
                alert("Error");
            }
        });
    }




    /*
     |--------------------------------------------------------------------------
     | VERIFY OTP METHOD
     |--------------------------------------------------------------------------
    */
    function verifyOTP(object)
    {
        let otp = $(object).val();
        let myOTP = $(object).closest('#registerForm').find('#getOTP').val();

        if (otp == myOTP) {
            $('#btnRegister').prop('disabled', false);
        }
    }




    /*
     |--------------------------------------------------------------------------
     | CHANGE MODAL TYPE METHOD
     |--------------------------------------------------------------------------
    */
    function changeModalType(object)
    {
        $('#nav-login-tab').removeClass('active')
        $('#nav-register-tab').removeClass('active')
        $('#nav-login').removeClass('show active')
        $('#nav-register').removeClass('show active')

        let getType = $(object).data('type');

        if (getType == 'login') {
            $('#nav-login-tab').addClass('active')
            $('#nav-login').addClass('show active')
        } else {
            $('#nav-register-tab').addClass('active')
            $('#nav-register').addClass('show active')
        }
    }




    /*
     |--------------------------------------------------------------------------
     | CHECK FORGOT PASSWORD PHONE METHOD
     |--------------------------------------------------------------------------
    */
    function checkForgotPassPhone(object)
    {
        let phone = $(object).val();

        if (phone.length == 11) {
            $.ajax({
                type : "POST",
                url : "{{ route('cus-auth.forgot-pass-check-phone') }}",
                data: {phone: phone},
                success: function (resp) {
                    console.log(resp)
                    if (resp != 'exists') {
                        $(object).closest('#forgotPasswordForm').find('#forgotPassPhoneMsg').show();
                        $('#forgotPassPhoneMsg').html('<span class="text-danger">Phone Not Found!</span>');
                        $('#btnSendForgotPassOTP').prop('disabled', true);
                    } else {
                        $('#btnSendForgotPassOTP').prop('disabled', false);
                        $('#forgotPassPhoneMsg').hide();
                    }
                }, error: function () {
                    alert("Error");
                }
            });
        } else {
            $(object).closest('#forgotPasswordForm').find('#forgotPassPhoneMsg').show();
            $('#forgotPassPhoneMsg').html('<span class="text-dark">Phone must be 11 digits!</span>');
        }
    }




    /*
     |--------------------------------------------------------------------------
     | SEND FORGOT PASSWORD OTP METHOD
     |--------------------------------------------------------------------------
    */
    function sendForgotPassOTP(object)
    {
        let phone =  $(object).closest('#forgotPasswordForm').find('#phone').val();

        $.ajax({

            type : "POST",
            url : "{{ route('cus-auth.forgot-pass-get-otp') }}",
            data: {phone: phone},
            success: function (resp) {

                $(object).closest('#forgotPasswordForm').find('#forgotPassPhoneMsg').show();
                $(object).closest('#forgotPasswordForm').find('#forgotPassOTP').show();
                $('#forgotPassPhoneMsg').html('<span class="text-success">'+resp.message+'</span>');
                $(object).closest('#forgotPasswordForm').find('#getForgotPassOTP').val(resp.myForgotPassOTP);
                $(object).prop('disabled', true);

                setTimeout(function(){
                    $('#forgotPassPhoneMsg').hide()
                }, 5000)

                console.log(resp.myForgotPassOTP)
            }, error: function () {
                alert("Error");
            }
        });
    }




    /*
     |--------------------------------------------------------------------------
     | VERIFY FORGOT PASSWORD OTP METHOD
     |--------------------------------------------------------------------------
    */
    function verifyForgotPassOTP(object)
    {
        let otp = $(object).val();
        let myOTP = $(object).closest('#forgotPasswordForm').find('#getForgotPassOTP').val();

        if (otp == myOTP) {
            $('#btnForgotPass').prop('disabled', false);

            $(object).closest('#forgotPasswordForm').find('#forgotNewPass').show();
            $(object).closest('#forgotPasswordForm').find('#forgotConfirmPass').show();
        }
    }




    /*
     |--------------------------------------------------------------------------
     | FORGOT NEW PASSWORD METHOD
     |--------------------------------------------------------------------------
    */
    function forgotNewPassword(object)
    {
        let newPassword = $(object).val();
        let confirmPassword = $(object).closest('#forgotPasswordForm').find('#forgot_confirm_password').val();

        if (confirmPassword.length > 0 && newPassword.length >= 8 && newPassword != confirmPassword) {

            $('#forgotConfirmPwdMsg').show();
            $('#forgotConfirmPwdMsg').html('<span class="text-danger">New Password & Confirm Password didn\'t match</span>');
            $('#btnForgotPass').prop('disabled', true);

            $('#forgotNewPwdMsg').hide();
            $('#btnForgotPass').prop('disabled', false);

        } else if (newPassword.length < 8) {

            $('#forgotNewPwdMsg').show();
            $('#forgotNewPwdMsg').html('<span class="text-danger">New Password Must be at least 8 characters.</span>');
            $('#btnForgotPass').prop('disabled', true);

        } else {

            $('#forgotNewPwdMsg').hide();
            $('#btnForgotPass').prop('disabled', false);
        }
    }




    /*
     |--------------------------------------------------------------------------
     | FORGOT CONFIRM PASSWORD METHOD
     |--------------------------------------------------------------------------
    */
    function forgotConfirmPassword(object)
    {
        let confirmPassword = $(object).val();
        let newPassword = $(object).closest('#forgotPasswordForm').find('#forgot_new_password').val();


        if (confirmPassword.length >= 8 && newPassword != confirmPassword) {

            $('#forgotConfirmPwdMsg').show();
            $('#forgotConfirmPwdMsg').html('<span class="text-danger">New Password & Confirm Password didn\'t match</span>');
            $('#btnForgotPass').prop('disabled', true);

        } else if (confirmPassword.length >= 8 && newPassword == confirmPassword) {

            $('#forgotConfirmPwdMsg').hide();
            $('#btnForgotPass').prop('disabled', false);

        } else {

            $('#forgotConfirmPwdMsg').hide();
            $('#btnForgotPass').prop('disabled', true);
        }
    }

</script>
