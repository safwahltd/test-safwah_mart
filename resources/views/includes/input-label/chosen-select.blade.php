

@php
    $title = isset($title) ? $title : 'Title';
    $required_class = '';
    $value = isset($value) ? $value : getOldValue($name);

    if (isset($required)) {
        $required_class = 'required';
    }
@endphp

<div class="form-group">
    <label class="col-sm-4 control-label no-padding-right" for="form-field-1"> {{ $title }} 
        @if (isset($required))
            <sup class="text-danger">*</sup>
        @endif
    </label>

    <div class="col-sm-8">
        <select 
        @if (isset($multiple))
            name="{{ $name }}[]" multiple
        @else 
            name="{{ $name }}"
        @endif
         id="{{ $name }}" class="chosen-select-100-percent {{ $required_class }}"
                @if($required_class) 
                    required="required" 
                @endif
                @if(isset($method_name))
                    onchange="{{ $method_name }}()"
                @endif
            >

            @if (!isset($multiple))
                <option value="" selected disabled>- {{ $title }} -</option>
            @endif

            @foreach($items as $id => $name)
                <option {{ $value == $id ? 'selected' : ''  }} value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
    </div>
</div>





