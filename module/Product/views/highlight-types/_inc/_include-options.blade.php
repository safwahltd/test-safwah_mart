@foreach ($childCategory->childCategories ?? [] as $childCategory)
    <option value="{{ $childCategory->id }}" data-product_type_id="{{ optional($childCategory)->product_type_id }}" >
        @for($s = 0; $s < $space; $s++)
            &nbsp;
        @endfor
        &raquo;&nbsp;&nbsp;{{ $childCategory->name }}
    </option>
    
    @include('category._inc._include-options', ['childCategory' => $childCategory, 'space' => $space + 2])
@endforeach