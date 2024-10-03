
<div class="tab-pane fade" id="nav-register" role="tabpanel" aria-labelledby="nav-register-tab">
    <form id="registerForm" action="{{ route('cus-auth.register') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="floating-label mb-3">
                    <input type="name" class="form-control" name="name" id="name" placeholder=" " autocomplete="off" required />
                    <label for="name">Name*</label>
                </div>

                <div class="floating-label">
                    <input type="email" class="form-control" name="email" id="email" placeholder=" " onkeyup="checkEmail(this)" autocomplete="off" />
                    <label for="email">Email</label>
                </div>
                <span id="emailMsg" style="display: none; font-size: 12px"></span>

                <div class="floating-label input-group mt-3">
                    <input type="text" class="form-control" name="phone" id="phone" placeholder=" " onkeyup="checkPhone(this)" autocomplete="off" required  aria-describedby="phone" />
                    <label for="phone">Phone*</label>

                    <div class="input-group-append">
                        <button class="btn btn-sm btn-dark text-uppercase" id="btnSendOTP" type="button" style="font-size: 12px !important; font-weight: bold" onclick="sendOTP(this)" disabled>
                            Send Otp <i class="fa fa-send ml-2"></i>
                        </button>
                    </div>

                </div>
                <input type="hidden" id="getOTP">
                <span id="phoneMsg" style="display: none; font-size: 12px"></span>


                <div class="floating-label mt-3" id="myOTP" style="display: none">
                    <input type="text" class="form-control" name="my_otp" id="my_otp" onkeyup="verifyOTP(this)" placeholder=" " autocomplete="off" required />
                    <label for="my_otp">OTP*</label>
                </div>
            </div>

            <div class="col-md-6">
                <div class="floating-label mt-3">
                    <input type="password" class="form-control" name="reg_password" id="reg_password" placeholder=" " onkeyup="givenPassword(this)" autocomplete="off" required />
                    <label for="reg_password">Password*</label>
                </div>
                <div id="pwdMsg" style="display: none; font-size: 12px"></div>
            </div>

            <div class="col-md-6">
                <div class="floating-label mt-3">
                    <input type="password" class="form-control" name="reg_confirm_password" id="reg_confirm_password" autocomplete="off" placeholder=" " onkeyup="confirmPassword(this)" required />
                    <label for="reg_confirm_password">Confirm Password*</label>
                </div>
                <span id="confirmPwdMsg" style="display: none; font-size: 12px"></span>
            </div>

        </div>
        <div class="d-flex flex-wrap justify-content-between mt-3">
            <div class="form-group mb-1">
                <div class="form-check-inline mb-1">
                    <input type="checkbox" class="mr-1 form-check-input form-check-primary" name="accept" id="accept" style="cursor: pointer" required>
                    <label class="mt-2" for="accept">
                        I accept the
                        <a class="font-size-sm" target="_blank" href="{{ route('terms-and-conditions') }}">
                            Terms and Condition
                        </a>
                    </label>
                </div>

            </div>
            <div class="text-right">
                <button class="btn btn-sm btn-primary text-uppercase" id="btnRegister" disabled><i class="fa fa-user-circle-o mr-1"></i> Register</button>
            </div>
        </div>
    </form>
</div>
