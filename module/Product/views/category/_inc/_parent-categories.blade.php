@foreach ($parentCategories as $parentCategory)
    @include('category/_inc/_parent-categories', ['parentCategories' => $parentCategory->parentCategories])

    {{ $parentCategory->name }},
@endforeach
