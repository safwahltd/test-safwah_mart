@foreach ($childCategory->childCategories ?? [] as $childCategory)
    <option value="{{ $childCategory->id }}" 
        data-product_type_id="{{ optional($childCategory)->product_type_id }}" 
        {{ old('parent_id', $category->parent_id) == $childCategory->id ? 'selected' : '' }}
        {{ $childCategory->id == $category->id ? 'disabled' : '' }}
        >
        @for($s = 0; $s < $space; $s++)
            &nbsp;
        @endfor
        &raquo;&nbsp;{{ $childCategory->name }}
    </option>
    
    @include('category._inc._include-options-edit', ['childCategory' => $childCategory, 'space' => $space + 1])
@endforeach