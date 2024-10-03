{{--
<div id="sms-api-setting" class="tab-pane" style="margin-top: -36px !important;">

    <form class="form-horizontal mt-2" action="{{ route('settings.update-sms-api-setting', $smsApiSetting->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-sm-6">
                <!-- BASE URL -->
                <div class="input-group width-100 @error('base_url') has-error @enderror">
                    <span class="input-group-addon width-40" style="text-align: left">
						Base Url<span class="label-required">*</span>
                    </span>

                    <input type="url" class="form-control" name="base_url" id="base_url"
                           value="{{ old('base_url', $smsApiSetting->base_url ) }}" tabindex="1" autocomplete="off" placeholder="Base Url" required>
                </div>
                <span class="text-danger pt-1">
                    @error('base_url')
                    {{ $message }}
                    @enderror
                </span>




                <!-- API KEY -->
                <div class="input-group mt-2 width-100 @error('api_key') has-error @enderror">
                    <span class="input-group-addon width-40" style="text-align: left">
						API Key<span class="label-required">*</span>
                    </span>

                    <input type="text" class="form-control" name="api_key" id="api_key"
                           value="{{ old('api_key', $smsApiSetting->api_key ) }}" tabindex="2" autocomplete="off" placeholder="API Key" required>
                </div>
                <span class="text-danger">
                    @error('api_key')
                    {{ $message }}
                    @enderror
                </span>




                <!-- SENDER ID -->
                <div class="input-group mt-2 width-100 @error('sender_id') has-error @enderror">
                    <span class="input-group-addon width-40" style="text-align: left">
						Sender ID
                    </span>

                    <input type="text" class="form-control" name="sender_id" id="sender_id"
                           value="{{ old('sender_id', $smsApiSetting->sender_id ) }}" tabindex="3" autocomplete="off" placeholder="Sender ID" required>
                </div>
                <span class="text-danger">
                    @error('sender_id')
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

 --}}
