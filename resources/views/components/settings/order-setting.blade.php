<div id="order-setting" class="tab-pane" style="margin-top: -36px !important;">
    <form class="form-horizontal mt-2" action="{{ route('settings.update-order-setting') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-7">
                @foreach($orderSettings as $key => $setting)
                    <input type="hidden" name="id[]" value="{{ $setting->id }}">

                    <div class="input-group mb-1 width-100">
                        <span class="input-group-addon width-45" style="text-align: left">
                            {{ $setting->title }}
                            <span class="label-required">*</span>
                        </span>
                        <input type="text" class="form-control text-center" name="value[]" placeholder="{{ $setting->title }}" value="{{ old('value', $setting->value) }}" required>
                    </div>
                @endforeach


                
                <div class="btn-group pull-right">
                    <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-check"></i> UPDATE </button>
                </div>
            </div>
        </div>
    </form>
</div>


