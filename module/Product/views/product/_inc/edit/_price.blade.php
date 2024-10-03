




<div class="row mt-3">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <!-- PURCHASE PRICE -->
                <div class="input-group width-100 mb-1">
                    <span class="input-group-addon width-30" style="text-align: left">
                        <span id="purchasePriceLabel">Purchase Price</span>
                    </span>
                    <input type="text" class="form-control only-number" name="purchase_price" id="purchase_price" value="{{ $product->purchase_price != 0 ? old('purchase_price', number_format($product->purchase_price, 2, '.', '')) : '' }}" autocomplete="off">
                </div>





                <!-- WHOLESALE PRICE -->
                <div class="input-group width-100 mb-1">
                    <span class="input-group-addon width-30" style="text-align: left">
                        <span id="wholeSalePriceLabel">Wholesale Price</span>
                    </span>
                    <input type="text" class="form-control only-number" name="wholesale_price" id="wholesale_price" value="{{ $product->wholesale_price != 0 ? old('wholesale_price', number_format($product->wholesale_price, 2, '.', '')) : '' }}" autocomplete="off">
                </div>





                <!-- SALE PRICE -->
                <div class="input-group width-100 mb-1">
                    <span class="input-group-addon width-30" style="text-align: left">
                        <span id="salePriceLabel">Sale Price</span>
                    </span>
                    <input type="text" class="form-control sale-price only-number" name="sale_price" id="sale_price" value="{{ $product->sale_price != 0 ? old('sale_price', number_format($product->sale_price, 2, '.', '')) : '' }}" autocomplete="off" required>
                </div>





                <!-- VAT -->
                <div class="input-group width-100 mb-1">
                    <span class="input-group-addon width-30" style="text-align: left">
                        <span id="vatLabel">VAT</span>
                    </span>
                    <input type="text" class="form-control text-center" style="width: 50%" name="vat" id="vat" value="{{ $product->vat != 0 ? old('vat', number_format($product->vat, 2, '.', '')) : '' }}" placeholder="VAT" autocomplete="off">
                    <select name="vat_type" id="vat_type" class="form-control select2" style="width: 50%" data-placeholder="--- Select ---">
                        <option value="Percentage" {{ old('vat_type', $product->vat_type) == 'Percentage' ? 'selected' : '' }} selected>Percentage</option>
                        <option value="Flat" {{ old('vat_type', $product->vat_type) == 'Flat' ? 'selected' : '' }}>Flat</option>
                    </select>
                </div>





                <!-- DISCOUNT -->
                <div class="input-group width-100 mb-1">
                    <span class="input-group-addon width-30" style="text-align: left; width: 130px !important;">
                        <span id="vatLabel">Discount (%)</span>
                    </span>
                    <input type="text" class="form-control discount-percentage only-number text-center" name="discount_percentage" value="{{ old('discount_percentage', $product->discount_percentage) }}" placeholder="Percentage Discount" autocomplete="off">
                    <span class="input-group-addon width-30" style="text-align: left; width: 130px !important;">
                        <span id="vatLabel">Discount (Flat)</span>
                    </span>
                    <input type="text" class="form-control only-number discount-flat text-center" name="discount_flat" value="{{ old('discount_flat', $product->discount_flat) }}" placeholder="Flat Discount" autocomplete="off">
                </div>
            </div>
        </div>
    </div>
</div>
