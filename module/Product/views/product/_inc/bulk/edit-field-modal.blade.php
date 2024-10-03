<div class="modal" id="editFieldModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-footer">
            </div>
            <div class="modal-body">
                <div class="input-group width-100 mb-1 change-field-div change-field-div-thumbnail_image" style="display: none">
                    <span class="input-group-addon width-20" style="background-color: #e1ecff; color: #000000;">
                        <span>Thumbnail Image</span>
                    </span>
                    <input type="file" class="form-control change-field change-field-thumbnail_image" name="change_value">
                </div>

                <div class="input-group width-100 mb-1 change-field-div change-field-div-name" style="display: none">
                    <span class="input-group-addon width-20" style="background-color: #e1ecff; color: #000000;">
                        <span>Name</span>
                    </span>
                    <input type="text" class="form-control change-field change-field-name" name="change_value">
                </div>

                <div class="input-group width-100 mb-1 change-field-div change-field-div-category_id" style="display: none">
                    <span class="input-group-addon width-20" style="background-color: #e1ecff; color: #000000;">
                        <span>Category</span>
                    </span>
                    <select name="change_value" class="form-control change-field change-field-category_id select2" style="width: 100%">
                        <option value="" selected>All Category</option>
                        @foreach ($categories ?? [] as $parentCategory)
                            <option value="{{ $parentCategory->id }}" data-product_type_id="{{ optional($parentCategory)->product_type_id }}" {{ old('parent_id') }}>{{ $parentCategory->name }}</option>

                            @foreach ($parentCategory->childCategories ?? [] as $childCategory)
                                <option value="{{ $childCategory->id }}" data-product_type_id="{{ optional($childCategory)->product_type_id }}" >
                                    &nbsp;&raquo;&nbsp;{{ $childCategory->name }}
                                </option>

                                @include('category._inc._include-options', ['childCategory' => $childCategory, 'space' => 1])
                            @endforeach
                        @endforeach
                    </select>
                </div>

                <div class="input-group width-100 mb-1 change-field-div change-field-div-brand_id" style="display: none">
                    <span class="input-group-addon width-20" style="background-color: #e1ecff; color: #000000;">
                        <span>Brand</span>
                    </span>
                    <select name="change_value" class="form-control change-field change-field-brand_id select2" style="width: 100%">
                        <option value="" selected>All Brand</option>
                        @foreach($brands ?? [] as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="input-group width-100 mb-1 change-field-div change-field-div-sale_price" style="display: none">
                    <span class="input-group-addon width-20" style="background-color: #e1ecff; color: #000000;">
                        <span>MRP</span>
                    </span>
                    <input type="text" class="form-control change-field change-field-sale_price" name="change_value">
                </div>

                <div class="input-group width-100 mb-1 change-field-div change-field-div-is_refundable" style="display: none">
                    <span class="input-group-addon width-20" style="background-color: #e1ecff; color: #000000;">
                        <span>Refundable</span>
                    </span>
                    <select name="change_value" class="form-control change-field change-field-is_refundable select2" style="width: 100%">
                        @foreach(['Yes', 'No'] ?? [] as $is_refundable)
                            <option value="{{ $is_refundable }}">{{ $is_refundable }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="modal-body text-right">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">CLOSE</button>
                <button type="submit" class="btn btn-sm btn-primary">UPDATE</button>
            </div>
        </div>
    </div>
</div>
