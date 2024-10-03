
<div class="modal fade" id="forgotPasswordModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="forgotPasswordModalLabel">Forgot Password?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="dismissModal()" >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="forgotPasswordForm" action="{{ route('cus-auth.forgot-password') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-12">
                            <div class="floating-label input-group">
                                <input type="text" class="form-control" name="forgot_pass_phone" id="forgot_pass_phone" placeholder=" " onkeyup="checkForgotPassPhone(this)" autocomplete="off" required />
                                <label for="forgot_pass_phone">Phone*</label>

                                <div class="input-group-append">
                                    <button class="btn btn-sm btn-dark text-uppercase" id="btnSendForgotPassOTP" type="button" style="font-size: 12px !important; font-weight: bold" onclick="sendForgotPassOTP(this)" disabled>
                                        Send Otp <i class="fa fa-send ml-2"></i>
                                    </button>
                                </div>

                            </div>
                            <input type="hidden" id="getForgotPassOTP">
                            <span id="forgotPassPhoneMsg" style="display: none; font-size: 12px"></span>

                            <div class="floating-label mt-3" id="forgotPassOTP" style="display: none">
                                <input type="text" class="form-control" name="forgot_pass_otp" id="forgot_pass_otp" onkeyup="verifyForgotPassOTP(this)" placeholder=" " autocomplete="off" required />
                                <label for="forgot_pass_otp">OTP*</label>
                            </div>
                        </div>

                        <div class="col-md-6" id="forgotNewPass" style="display: none">
                            <div class="floating-label mt-3">
                                <input type="password" class="form-control" name="forgot_new_password" id="forgot_new_password" placeholder=" " onkeyup="forgotNewPassword(this)" autocomplete="off" required />
                                <label for="forgot_new_password">New Password*</label>
                            </div>
                            <div id="forgotNewPwdMsg" style="display: none; font-size: 12px"></div>
                        </div>

                        <div class="col-md-6" id="forgotConfirmPass" style="display: none">
                            <div class="floating-label mt-3">
                                <input type="password" class="form-control" name="forgot_confirm_password" id="forgot_confirm_password" autocomplete="off" placeholder=" " onkeyup="forgotConfirmPassword(this)" required />
                                <label for="forgot_confirm_password">Confirm Password*</label>
                            </div>
                            <span id="forgotConfirmPwdMsg" style="display: none; font-size: 12px"></span>
                        </div>

                    </div>

                    <div class="text-right">
                        <button class="btn btn-sm btn-primary text-uppercase mt-3" id="btnForgotPass" disabled><i class="fa fa-key mr-1"></i> Change Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
