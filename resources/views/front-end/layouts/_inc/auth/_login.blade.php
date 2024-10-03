
<div class="tab-pane fade" id="nav-login" role="tabpanel" aria-labelledby="nav-login-tab">
    <form id="loginForm" action="{{ route('cus-auth.login') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="floating-label mb-3">
                    <input type="text" class="form-control" name="login_phone" id="login_phone" placeholder=" " autocomplete="off" required />
                    <label for="phone">Phone*</label>
                </div>
            </div>

            <div class="col-md-12">
                <div class="floating-label mb-3">
                    <input type="password" class="form-control" name="login_password" id="login_password" placeholder=" " autocomplete="off" required />
                    <label for="password">Password*</label>
                </div>
            </div>

        </div>

        <div class="d-flex flex-wrap justify-content-between">
            <a class="font-size-sm" href="javascript:void(0)" data-toggle="modal" data-target="#forgotPasswordModal" type="button" data-dismiss="modal" aria-label="Close" onclick="dismissModal()">
                Forgot Password?
            </a>
            <div class="text-right">
                <button class="btn btn-sm btn-primary text-uppercase"><i class="fa fa-sign-in mr-1"></i> Login</button>
            </div>
        </div>
    </form>
</div>
