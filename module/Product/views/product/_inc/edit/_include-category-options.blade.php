@foreach ($childCategory->childCategories ?? [] as $childCategory)
    <option value="{{ $childCategory->id }}" data-product_type_id="{{ optional($childCategory)->product_type_id }}" 
        {{ old('category_id', $product->category_id) == $childCategory->id ? 'selected' : '' }}
        >
        @for($s = 0; $s < $space; $s++)
            &nbsp;
        @endfor
        &raquo;&nbsp;{{ $childCategory->name }}
    </option>
    
    @include('product/_inc/edit/_include-category-options', ['childCategory' => $childCategory, 'space' => $space + 1])
@endforeach