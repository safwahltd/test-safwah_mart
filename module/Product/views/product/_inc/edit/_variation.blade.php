
<!-- ATTRIBUTE TYPE -->
<div class="row">
    <div class="col-lg-6 col-md-offset-3">
        <input type="hidden" id="purchasePrice" value="{{ number_format($product->purchase_price, 2, '.', '') }}">
        <input type="hidden" id="wholesalePrice" value="{{ number_format($product->wholesale_price, 2, '.', '') }}">
        <input type="hidden" id="salePrice" value="{{ number_format($product->sale_price, 2, '.', '') }}">


        <!-- WAREHOUSE -->
        <div class="input-group width-100 mb-1">
            <span class="input-group-addon width-30" style="text-align: left">
                Warehouse
            </span>
            <select class="form-control" name="warehouse_id" id="pdt_variation_opening_warehouse" style="width: 100%" {{ isset($warehouse) || isProductCreate() == 'no' ? 'readonly' : '' }}>
                @if (isset($warehouse))
                    <option value="{{ $warehouse->id }}">{{ $warehouse->name }}</option>
                @elseif ($product->openingStock == null)
                    @foreach ($warehouses as $id => $name)
                        <option value="{{ $id }}" {{ old('warehouse_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                @endif
            </select>
        </div>





        <div id="attributeSelect">
            <div class="input-group mb-1 width-100">
                <span class="input-group-addon width-30">
                    Attribute Type
                </span>
                <select name="product_type_id" id="atrributes_id" class="form-control select2 pr-0" data-placeholder="--- Select ---" style="width: 100%" multiple>
                    <option></option>
                    @foreach($attributeTypes as $item)
                        <option value="{{ $item->id }}"
                            {{ old('atrributes_id') == $item->id ? 'selected' : '' }}
                            data-attributes="{{ $item->attributes }}">{{ $item->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>





<!-- SELECTED ATTRIBUTES -->
<div class="row selected-attributes"></div>





<!-- GENERATE VARIATION -->
<div class="row mb-3">
    <div class="col-lg-6 col-md-offset-3">
        <button type="button" class="btn-block" style="background: #FFCA2C; color: #000000; border: 1px solid #efefef !important; padding-top: 6px; padding-bottom: 6px" onclick="generateVariation()">
            <i class="fa fa-cog"></i> GENERATE VARIATION
        </button>
    </div>
</div>





<!-- VARIATION TABLE -->
<div class="form-group pl-2 pr-2">
    <div class="col-12">
        <table id="variationTable" class="table table-bordered" style="{{ count($productVariations) == 0 ? 'display:none' : '' }}">
            <thead>
                <tr>
                    <td class="text-center" width="2%;">#</td>
                    <td style="width: 20%">Variation</td>
                    <td class="text-center" width="12%">Purchase Price</td>
                    <td class="text-center" width="12%">Wholesale Price</td>
                    <td class="text-center" width="12%">Sale Price</td>
                    <td class="text-center" width="10%">SKU</td>
                    <td width="10%">Lot</td>
                    <td class="text-center" width="12%">Opening Stock</td>
                    <td class="text-center" width="12%">Expired</td>
                    <td width="15%">Image</td>
                    <td class="text-center" width="5%">Action</td>
                </tr>
            </thead>





            <!-- CURRENT VARIATION -->
            @if (count($productVariations) > 0)
                <tr>
                    <td colspan="20" class="text-center" style="background-color:rgb(181, 186, 255); color:black">Current Variation</td>
                </tr>
            @endif
            <tbody class="variant-tbody">
                @foreach ($productVariations as $key => $variation)
                    <tr>
                        <td style="padding-top: 15px;">
                            {{ $loop->iteration }}
                            <input type="hidden" class="is_sync" name="is_sync[]" value="No">
                            <input type="hidden" class="variation_barcode" value="No">
                        </td>
                        <td>
                            <input type="hidden" class="product_variation_id" name="product_variation_id[]" value="{{ $variation->id }}">
                            <input type="text" class="form-control text-center variation_name current_variant_name" name="variation_name[]" value="{{ $variation->name }}" readonly>
                        </td>
                        <td>
                            <input type="text" class="form-control text-right only-number variation_purchase_price" name="variation_purchase_price[]" value="{{ number_format($variation->purchase_price, 2, '.', '') }}" autocomplete="off" readonly required>
                        </td>
                        <td>
                            <input type="text" class="form-control text-right only-number variation_wholesale_price" name="variation_wholesale_price[]" value="{{ number_format($variation->wholesale_price, 2, '.', '') }}" autocomplete="off" readonly required>
                        </td>
                        <td>
                            <input type="text" class="form-control text-right only-number variation_sale_price" name="variation_sale_price[]" value="{{ number_format($variation->sale_price, 2, '.', '') }}" autocomplete="off" readonly required>
                        </td>
                        <td>
                            <input type="text" class="form-control text-center variation_sku" name="variation_sku[]" value="{{ $variation->sku }}" readonly required>
                        </td>
                        <td>
                            <input type="text" class="form-control variation_lot" name="variation_lot[]" value="{{ optional($variation->openingStock)->lot }}" readonly>
                        </td>
                        <td>
                            <input type="text" class="form-control text-center only-number variation_opening_stock" name="variation_opening_stock[]" value="{{ number_format(optional($variation->openingStock)->quantity, 2, '.', '') }}" readonly required>
                        </td>
                        <td>
                            <input type="text" class="form-control text-center only-number date-picker" name="expired_dates[]" data-date-format="yyyy-mm-dd" value="{{ $variation->expired_date }}" readonly >
                        </td>
                        <td>
                            <button type="button" data-key="{{ $key }}" data-variation-id="{{ $variation->id }}" data-image-count="{{ count($variation->productVariationImages) }}" class="form-control btn btn-next" data-toggle="modal" data-target="#multipleImageModal">
                                Browse ...
                            </button>
                        </td>
                        <td class="text-center">
                            <a class="btn btn-sm btn-danger" onclick="deleteVariation(this, {{ $variation->id }})"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>





            <!-- NEW VARIATION -->
            <tr id="newVariation" style="{{ old('is_sync') == null ? 'display: none' : '' }}">
                <td colspan="20" class="text-center" style="background-color:rgb(209, 255, 209); color:black">New Variation</td>
            </tr>
            {{-- <tbody>
                @if (old('is_sync'))
                    @foreach (old('is_sync') as $key => $is_sync)
                        @if ($is_sync == 'Yes')
                            <tr>
                                <td style="padding-top: 15px;">
                                    {{ $loop->iteration }}
                                    <input type="hidden" class="is_sync" name="is_sync[]" value="{{ $is_sync }}">
                                    <input type="hidden" class="variation_barcode" value="No">
                                </td>
                                <td>
                                    <input type="hidden" class="product_variation_id" name="product_variation_id[]" value="{{ old(product_variation_id)[$key] }}">
                                    <input type="text" class="form-control text-center variation_name current_variant_name" name="variation_name[]" value="{{ old(variation_name)[$key] }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control text-right only-number variation_purchase_price" name="variation_purchase_price[]" value="{{ number_format(old('variation_purchase_price')[$key], 2, '.', '') }}" autocomplete="off" readonly required>
                                </td>
                                <td>
                                    <input type="text" class="form-control text-right only-number variation_wholesale_price" name="variation_wholesale_price[]" value="{{ number_format(old('variation_wholesale_price')[$key], 2, '.', '') }}" autocomplete="off" readonly required>
                                </td>
                                <td>
                                    <input type="text" class="form-control text-right only-number variation_sale_price" name="variation_sale_price[]" value="{{ number_format(old('variation_sale_price')[$key], 2, '.', '') }}" autocomplete="off" readonly required>
                                </td>
                                <td>
                                    <input type="text" class="form-control text-center variation_sku" name="variation_sku[]" value="{{ old(variation_sku)[$key] }}" readonly required>
                                </td>
                                <td>
                                    <input type="text" class="form-control variation_lot" name="variation_lot[]" value="{{ old(variation_lot)[$key] }}" readonly>
                                </td>
                                <td>
                                    <input type="text" class="form-control text-center only-number variation_opening_stock" name="variation_opening_stock[]" value="{{ number_format(old('variation_opening_stock')[$key], 2, '.', '') }}" readonly required>
                                </td>
                                <td>
                                    <div class="input-group">
                                        <a href="#multipleImage"
                                            role="button" title="Show Image"
                                            class="input-group-addon"
                                            data-toggle="{{ count($variation->productImages) > 0 ? 'modal' : '' }}"
                                            style="background: rgb(236, 255, 168)"
                                            data-variation-id="{{ $variation->id }}"
                                            data-variation-name="{{ $variation->name }}"
                                        >
                                            <i class="fa {{ count($variation->productImages) > 0 ? 'fa-eye' : 'fa-eye-slash' }}"></i>
                                        </a>
                                        <input type="file" class="form-control variation_images" id="variation_images{{ $key }}" name="variation_image_{{ $key }}[]" multiple readonly accept="image/*">
                                    </div>
                                </td>
                                <td class="text-center">
                                    <a class="btn btn-sm btn-danger" onclick="deleteVariation(this, {{ $variation->id }})"><i class="fa fa-trash"></i></a>
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            </tbody> --}}
            <tbody class="variant-tbody" id="variant-tbody">

            </tbody>

            <tbody id="appendVariationImages">

            </tbody>

            <tbody id="appendDefaultVariationImagesInput">

            </tbody>
        </table>
    </div>
</div>



<div class="modal fade" id="multipleImageModal" tabindex="-1" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="multipleImageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-body" style="margin: 0px; padding: 0px">
                <h4 class="heading">Upload Image</h4>
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#browse">Browse</a></li>
                    <li><a data-toggle="tab" href="#select">Select</a></li>
                    <li><a data-toggle="tab" href="#gallery">Gallery</a></li>
                </ul>

                <div class="tab-content">
                    <div id="browse" class="tab-pane active">
                        <div class="row add-image mt-1">
                            <div class="col-sm-12">
                                <div class="upload-section">
                                    <span id="more__img">

                                    </span>
                                    <label class="add-more" onclick="addMoreByKey(this)"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="select" class="tab-pane">
                        <div class="row add-image mt-1">
                            <div class="col-sm-12">
                                <div class="upload-section">
                                    @foreach ($multipleImages as $image)
                                        <label class="check-image" for="checkedImage{{ $loop->iteration }}" data-parent-id="{{ $image->id }}" data-image-path={{ $image->image }}>
                                            <input type="checkbox" class="multiple-image image-checked" data-id="{{ $image->id }}" name="image_checked[]" id="checkedImage{{ $loop->iteration }}">
                                            <img class="img-responsive" src="{{ asset($image->image) }}">
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="gallery" class="tab-pane">
                        <div class="row add-image mt-1">
                            <div class="col-sm-12">
                                <div class="upload-section gallery-images">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-theme" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
