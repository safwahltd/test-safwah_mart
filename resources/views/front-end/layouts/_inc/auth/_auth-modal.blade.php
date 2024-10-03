
<div class="modal fade" id="authModal" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <a class="nav-link" id="nav-login-tab" data-toggle="tab" href="#nav-login" role="tab" aria-controls="nav-login" aria-selected="true" style="color: #000000 !important;">LOGIN</a>
                        <a class="nav-link" id="nav-register-tab" data-toggle="tab" href="#nav-register" role="tab" aria-controls="nav-register" aria-selected="false" style="color: #000000 !important;">REGISTER</a>
                        <button type="button" class="close" data-dismiss="modal" onclick="dismissModal()" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                </nav>
                <div class="tab-content" id="nav-tabContent">

                    @include('front-end.layouts._inc.auth._login')

                    @include('front-end.layouts._inc.auth._register')

                </div>
            </div>
        </div>
    </div>
</div>
