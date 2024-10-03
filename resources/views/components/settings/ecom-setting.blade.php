<div id="ecom-setting" class="tab-pane" style="margin-top: -36px !important;">
    <form class="form-horizontal mt-2" action="{{ route('settings.update-ecom-setting') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-7">
                @foreach($ecomSettings as $key => $setting)
                    <input type="hidden" name="id[]" value="{{ $setting->id }}">

                    <div class="input-group mb-1 width-100">


                        @if ($setting->id == 1)
                            <span class="input-group-addon width-45" style="text-align: left">
                                {{ $setting->title }}
                                <span class="label-required">*</span>
                            </span>
                            <span class="color-picker" id="color-picker-component" style="display: flex;">
                                <input type="text" class="form-control w-35" name="value[{{ $setting->id }}]" value="{{ $setting->value }}">
                                <span class="input-group-addon" style="width: 40px; line-height: 20px;"><i></i></span>
                            </span>

                        @elseif ($setting->id == 33)
                            <span class="input-group-addon width-45" style="text-align: left">
                                {{ $setting->title }}
                                <span class="label-required">*</span>
                            </span>
                            <span class="color-picker" id="color-picker-component2" style="display: flex;">
                                <input type="text" class="form-control w-35" name="value[{{ $setting->id }}]" value="{{ $setting->value }}">
                                <span class="input-group-addon" style="width: 40px; line-height: 20px;"><i></i></span>
                            </span>


                        @elseif ($setting->id == 3)
                            <span class="input-group-addon width-45" style="text-align: left">
                                {{ $setting->title }}
                                <span class="label-required">*</span>
                            </span>
                            <label style="margin: 6px 0 0 15px;" class="width-55">
                                <input name="value[{{ $setting->id }}]" class="ace ace-switch ace-switch-6 status{{ $setting->id }}" type="checkbox" @if(!empty($setting->value) && $setting->value == 'on') checked @endif>
                                <span class="lbl" id="status{{ $setting->id }}"></span>
                            </label>



                        @elseif ($setting->id == 4)
                            <span class="input-group-addon width-45" style="text-align: left">
                                {{ $setting->title }}
                                <span class="label-required">*</span>
                            </span>
                            <label style="margin: 6px 0 0 15px;" class="width-55">
                                <input name="value[{{ $setting->id }}]" class="ace ace-switch ace-switch-6 status{{ $setting->id }}" type="checkbox" @if(!empty($setting->value) && $setting->value == 'on') checked @endif>
                                <span class="lbl" id="status{{ $setting->id }}"></span>
                            </label>



                        @elseif ($setting->id == 5)
                            <span class="input-group-addon width-45" style="text-align: left">
                                {{ $setting->title }}
                                <span class="label-required">*</span>
                            </span>
                            <input type="file" class="form-control text-right" name="value[{{ $setting->id }}]" placeholder="{{ $setting->title }}">
                            <small style="margin-left: 13px;"><b>Loading image size must be 130x110.</b></small>




                        @elseif($setting->id == 34)
                            <span class="input-group-addon width-45" style="text-align: left">
                                {{ $setting->title }}
                            </span>
                            <input type="text" class="form-control text-center only-number" name="value[{{ $setting->id }}]" placeholder="{{ $setting->title }}" value="{{ old('value', $setting->value) }}" required>



                        @elseif ($setting->id > 5)

                            <span class="input-group-addon width-45" style="text-align: left">
                                {{ $setting->title }}
                            </span>

                            <label style="margin: 6px 0 0 15px; position: relative;" class="width-55">
                                <input name="value[{{ $setting->id }}]" class="ace ace-switch ace-switch-6 status{{ $setting->id }}" type="checkbox" @if(!empty($setting->value) && $setting->value == 'on') checked @endif>
                                <span class="lbl"></span>
                            </label>





                        @else
                            <span class="input-group-addon width-45" style="text-align: left">
                                {{ $setting->title }}
                            </span>
                            <input type="text" class="form-control text-center" name="value[{{ $setting->id }}]" placeholder="{{ $setting->title }}" value="{{ old('value', $setting->value) }}" required>


                        @endif

                    </div>


                    <span class="text-danger pt-1">
                        @error('value')
                            {{ $message }}
                        @enderror
                    </span>


                @endforeach
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-right">
                <div class="btn-group">
                    <button class="btn btn-sm btn-primary" type="submit"> <i class="fa fa-check"></i> UPDATE </button>
                </div>
            </div>
        </div>
    </form>
</div>

@section('script')
    <script>










        $('#status3').click(function(){

            if ($('.status4').attr('checked',true)) {
                $('.status4').attr('checked',false);
            }
            else{
                $('.status4').attr('checked',true);
            }

        });
        $('#status4').click(function(){

            if ($('.status3').attr('checked',true)) {
                $('.status3').attr('checked',false)
            }
            else{
                $('.status3').attr('checked',true);
            }

        });





    </script>
@endsection


