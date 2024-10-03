

@php
    $isRequired = isset($is_required);
    $colSm      = isset($colSm) ? $colSm : 8;
    $title      = isset($title) ? $title : ucwords($name);
    $value      = isset($value) ? $value : '';
    $type       = isset($type)  ? $type  : 'text';
@endphp

<div class="form-group">
    <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> 
        {{ $title }}
        <sup class="text-danger">*</sup>
    </label>

    <div class="col-sm-8">
        <div class="input-group">
            <input type="text" autocomplete="off" class="form-control date-picker" placeholder="Click to Select Date" name="{{ $name }}" value="{{ old($name) }}">

            <div class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </div>
        </div>
    </div>
</div>

<br>
<br>