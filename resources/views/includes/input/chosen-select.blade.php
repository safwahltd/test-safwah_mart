
<select id="{{ $name }}" class="chosen-select-100-percent" name="{{ $name }}">

    <option value="" selected disabled>- {{ isset($title) ? $title : 'Select' }}-</option>

    @foreach([] as $key => $value)
        <option {{ getOldValue($name) == $key ? 'selected' : ''  }} value="{{ $key }}">{{ $value }}</option>
    @endforeach
</select>