@foreach ($childCategory->childCategories ?? [] as $childCategory)
    <option value="{{ $childCategory->id }}"
        {{ request('category_id') == $childCategory->id ? 'selected' : '' }}>
        @for($s = 0; $s < $space; $s++)
            &nbsp;
        @endfor
        &raquo;&nbsp;{{ $childCategory->name }}
    </option>
    
    @include('category/_inc/_search-options', ['childCategory' => $childCategory, 'space' => $space + 1])
@endforeach