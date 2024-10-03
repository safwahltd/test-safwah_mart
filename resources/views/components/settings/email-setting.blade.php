
<div id="email-setting" class="tab-pane" style="margin-top: -36px !important;">

    <form class="form-horizontal mt-2" action="{{ route('settings.update-email-setting', $emailSetting->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-sm-6">
                <!-- SENDER NAME -->
                <div class="input-group width-100 @error('sender_name') has-error @enderror">
                    <span class="input-group-addon width-40" style="text-align: left">
						Sender Name<span class="label-required">*</span>
                    </span>

                    <input type="text" class="form-control" name="sender_name" id="sender_name"
                           value="{{ old('sender_name', $emailSetting->sender_name ) }}" tabindex="1" placeholder="Sender Name" required>
                </div>
                <span class="text-danger pt-1">
                    @error('sender_name')
                    {{ $message }}
                    @enderror
                </span>




                <!-- SENDER EMAIL -->
                <div class="input-group mt-2 width-100 @error('sender_email') has-error @enderror">
                    <span class="input-group-addon width-40" style="text-align: left">
						Sender Email<span class="label-required">*</span>
                    </span>

                    <input type="text" class="form-control" name="sender_email" id="sender_email"
                           value="{{ old('sender_email', $emailSetting->sender_email ) }}" tabindex="2" placeholder="Sender Email" required>
                </div>
                <span class="text-danger">
                    @error('sender_email')
                    {{ $message }}
                    @enderror
                </span>




                <!-- MAIL MAILER -->
                <div class="input-group mt-2 width-100 @error('mail_mailer') has-error @enderror">
                    <span class="input-group-addon width-40" style="text-align: left">
						Mail Mailer
                    </span>

                    <input type="text" class="form-control" name="mail_mailer" id="mail_mailer"
                           value="{{ old('mail_mailer', $emailSetting->mail_mailer ) }}" placeholder="Mail Mailer" readonly required>
                </div>
                <span class="text-danger">
                    @error('mail_mailer')
                    {{ $message }}
                    @enderror
                </span>




                <!-- MAIL HOST -->
                <div class="input-group mt-2 width-100 @error('mail_host') has-error @enderror">
                    <span class="input-group-addon width-40" style="text-align: left">
						Mail Host<span class="label-required">*</span>
                    </span>

                    <input type="text" class="form-control" name="mail_host" id="mail_host"
                           value="{{ old('mail_host', $emailSetting->mail_host ) }}" tabindex="3" placeholder="Mail Host" required>
                </div>
                <span class="text-danger">
                    @error('mail_host')
                    {{ $message }}
                    @enderror
                </span>




                <!-- MAIL PORT -->
                <div class="input-group mt-2 width-100 @error('mail_port') has-error @enderror">
                    <span class="input-group-addon width-40" style="text-align: left">
						Mail Port<span class="label-required">*</span>
                    </span>

                    <input type="text" class="form-control" name="mail_port" id="mail_port"
                           value="{{ old('mail_port', $emailSetting->mail_port ) }}" tabindex="4" placeholder="Mail Port" required>
                </div>
                <span class="text-danger">
                    @error('mail_port')
                    {{ $message }}
                    @enderror
                </span>




                <!-- MAIL ENCRYPTION -->
                <div class="input-group mt-2 width-100 @error('mail_encryption') has-error @enderror">
                    <span class="input-group-addon width-40" style="text-align: left">
						Mail Encryption<span class="label-required">*</span>
                    </span>

                    <select name="mail_encryption" id="mail_encryption" class="form-control" tabindex="5" required style="width: 100%">
                        @foreach($mailEncryptions ?? [] as $encryption)
                            <option value="{{ $encryption }}" {{ old('mail_encryption', $emailSetting->mail_encryption) == $encryption ? 'selected' : '' }}>{{ $encryption }}</option>
                        @endforeach
                    </select>
                </div>
                <span class="text-danger">
                    @error('mail_encryption')
                    {{ $message }}
                    @enderror
                </span>




                <!-- MAIL USERNAME -->
                <div class="input-group mt-2 width-100 @error('mail_username') has-error @enderror">
                    <span class="input-group-addon width-40" style="text-align: left">
						Mail Username<span class="label-required">*</span>
                    </span>

                    <input type="text" class="form-control" name="mail_username" id="mail_username"
                           value="{{ old('mail_username', $emailSetting->mail_username ) }}" tabindex="6" placeholder="Mail Username" required>
                </div>
                <span class="text-danger">
                    @error('mail_username')
                    {{ $message }}
                    @enderror
                </span>




                <!-- MAIL PASSWORD -->
                <div class="input-group mt-2 width-100 @error('mail_password') has-error @enderror">
                    <span class="input-group-addon width-40" style="text-align: left">
						Mail Password<span class="label-required">*</span>
                    </span>

                    <input type="text" class="form-control" name="mail_password" id="mail_password"
                           value="{{ old('mail_password', $emailSetting->mail_password ) }}" tabindex="7" placeholder="Mail Password" required>
                </div>
                <span class="text-danger">
                    @error('mail_password')
                    {{ $message }}
                    @enderror
                </span>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-right">
                <div class="btn-group">
                    <button class="btn btn-sm btn-primary"> <i class="fa fa-check"></i> UPDATE </button>
                </div>
            </div>
        </div>

    </form>
</div>


