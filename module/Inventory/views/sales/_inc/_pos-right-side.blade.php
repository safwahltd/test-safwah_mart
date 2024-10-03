<div class="col-lg-7 position-relative side">


    <!-- TOP SEARCH -->
    <div class="row p-2 gutter-sizer" style="border-bottom: 2px solid #efefef">
        <div class="col input-group">
            <span class="input-group-text rounded-0"><i class="fas fa-bars"></i></span>
            <select class="form-control select2 rounded-0" name="category_id" id="category_id" onchange="searchItem(this, event)">
                <option value="" selected>All Category</option>
                @foreach ($categories ?? [] as $parentCategory)
                    <option value="{{ $parentCategory->id }}" 
                        {{ request('category_id') == $parentCategory->id ? 'selected' : '' }}>
                        {{ $parentCategory->name }}
                    </option>


                    @foreach ($parentCategory->childCategories ?? [] as $childCategory)
                        <option value="{{ $childCategory->id }}"
                            {{ request('category_id') == $childCategory->id ? 'selected' : '' }}>
                            &nbsp;&raquo;&nbsp;{{ $childCategory->name }}
                        </option>

                        @include('category/_inc/_search-options', ['childCategory' => $childCategory, 'space' => 1])
                    @endforeach
                @endforeach
            </select>

            
        </div>
        <div class="col input-group">
            <span class="input-group-text"><i class="fas fa-warehouse"></i></span>
            <select class="form-control select2" name="warehouse_id" id="warehouse_id">
                @foreach($warehouses as $warehouse)
                    <option value="{{ $warehouse->id }}" 
                        {{ count($warehouses) == 1 ? 'selected' : '' }} 
                        {{ old('warehouse_id') == $warehouse->id ? 'selected' : '' }}
                    >
                        {{ $warehouse->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="row p-2 gutter-sizer product-row" style="border-left: 3px solid #efefef !important; ">
        @include('sales/_inc/_products')
    </div>
</div>