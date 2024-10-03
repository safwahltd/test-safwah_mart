




<div class="row mt-3" id="productOpening">
    <div class="col-lg-6 col-md-offset-3">
        <!-- WAREHOUSE -->
        <div class="input-group width-100 mb-1">
            <span class="input-group-addon width-30" style="text-align: left">
                Warehouse
            </span>
            <select class="form-control" name="warehouse_id" style="width: 100%" {{ isProductCreate() == 'no' ? 'disabled' : '' }} required>
                @if ($product->openingStock == null)
                    @foreach ($warehouses as $id => $name)
                        <option value="{{ $id }}" {{ old('warehouse_id') == $id ? 'selected' : '' }}>{{ $name }}</option>
                    @endforeach
                @else
                    <option value="{{ optional(optional($product->openingStock)->warehouse)->id }}">{{ optional(optional($product->openingStock)->warehouse)->name }}</option>
                @endif
            </select>
        </div>





        <!-- LOT NO -->
        <div class="input-group width-100 mb-1">
            <span class="input-group-addon width-30" style="text-align: left">
                Lot
            </span>
            <input type="text" class="form-control" name="lot" value="{{ optional($product->openingStock)->lot }}" {{ isProductCreate() == 'no' ? 'disabled' : '' }}>
        </div>





        <!-- EXPIRE DATE -->
        <div class="input-group width-100 mb-1">
            <span class="input-group-addon width-30" style="text-align: left">
                Expire Date
            </span>
            <input type="text" class="form-control date-picker" name="expire_date" id="expire_date" value="{{ optional($product->openingStock)->expire_date }}" {{ isProductCreate() == 'no' ? 'disabled' : '' }} autocomplete="off" placeholder="Expire Date" data-date-format="yyyy-mm-dd">
        </div>





        <!-- OPENING QTY -->
        <div class="input-group width-100 mb-1">
            <span class="input-group-addon width-30" style="text-align: left">
                Opening Qty
            </span>
            <input type="number" class="form-control" name="opening_quantity" value="{{ $product->is_variation == 'Yes' ? 0 : number_format(optional($product->openingStock)->quantity, 2, '.', '') }}" {{ isProductCreate() == 'no' ? 'disabled' : '' }} required>
        </div>






        <!-- Expire Note -->
        <div class="input-group width-100 mb-1">
            <span class="input-group-addon width-30" style="text-align: left">
                Expire Note
            </span>
            <input type="text" class="form-control" name="expired_note" value="{{ old('expired_note', $product->expired_note) }}">
        </div>
    </div>
</div>
