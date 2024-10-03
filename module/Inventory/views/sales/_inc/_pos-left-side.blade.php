<div class="col-lg-5 position-relative side pos-left-side">


    <!-- TOP SEARCH -->
    <div class="row p-2 gutter-sizer" style="border-bottom: 2px solid #efefef;">
        <div class="col input-group search-body">

            <a href="javascript:void(0)" class="input-group-text add-customer-btn" data-bs-toggle="modal" data-bs-target="#posCustomerAddModal">
                <i class="fas fa-user-plus"></i>
            </a>

            {{-- <select class="form-control select2 search-customer-select" name="customer_id" id="customer_id">
                <option value='{{ $customer->id }}'
                    data-name                     = '{{ $customer->name }}'
                    data-mobile                   = '{{ $customer->mobile }}'
                    data-email                    = '{{ $customer->email }}'
                    selected
                > {{ $customer->name }}
                </option>
            </select> --}}
            <select class="form-control select2 search-customer-select" name="customer_id" id="customer_id">
                <option value=""></option>
            </select>

            <button type="button" class="input-group-text edit-customer-btn" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fas fa fa-edit"></i>
            </button>

        </div>
        <div class="col input-group">
            <span class="input-group-text"><i class="far fa-calendar"></i></span>
            <input type="text" name="date" class="form-control datepicker" value="{{ old('date', date('Y-m-d')) }}" data-date-format="yyyy-mm-dd">
        </div>
    </div>





    <!-- ITEM ROW -->
    <div class="row p-2 gutter-sizer item-row" style="height: 100% !important;  overflow-y:scroll">
        <div class="col-lg-12">

             <div id="searchProduct" class="search-pos-product">
                <div class="search-any-product d-flex">

                    <span class="input-group-text rounded-0 search-icon" id="barcode"><i class="fas fa-barcode"></i></span>
                    <input type="text" class="form-control rounded-0 search-input" name="product_search" id="searchProductField"  placeholder="Scan Your Barcode or SKU" onkeyup="searchAnyProduct(this, event)">

                    <div class="dropdown-content live-load-content">

                    </div>

                </div>
            </div>


            {{-- <div class="input-group mb-2 search-any-product">
                <span class="input-group-text rounded-0 search-icon" id="barcode"><i class="fas fa-barcode"></i></span>
                <input type="text" class="form-control rounded-0 search-input" id="search" onkeyup="searchItem(this, event)" placeholder="Search By Barcode / SKU / Code / Name..." autocomplete="off">
            </div> --}}


            <div class="table-responsive" style="height: 73% !important; overflow-y: scroll">
                <table class="table table-hover item-table">
                    <thead style="background-color: aliceblue; border-bottom: 2px solid;">
                        <tr>
                            <th width="35%">Item</th>
                            <th width="15%">Unit</th>
                            <th width="15%" class="text-end">U. Price</th>
                            <th width="20%" class="text-center">Quantity</th>
                            <th width="13%" class="text-center">Total</th>
                            <th width="2%"><i class="fas fa-times"></i></th>
                        </tr>
                    </thead>
                    <tbody id="t-body">
                        @if (old('product_id'))
                            @foreach (old('product_id') as $key => $value)
                                <tr class="align-middle">
                                    <td style="display: none">
                                        <input type="text" name="product_id[]" class="product-id" value="{{ $value }}">
                                        <input type="text" name="product_name[]" class="product-name" value="{{ old('product_name')[$key] }}">
                                        <input type="text" name="product_variation_id[]" class="product-variation-id" value="{{ old('product_variation_id')[$key] }}">
                                        <input type="text" name="product_variation_name[]" class="product-variation-name" value="{{ old('product_variation_name')[$key] }}">
                                        <input type="text" name="measurement_title[]" class="measurement-title" value="{{ old('measurement_title')[$key] }}">
                                        <input type="text" name="measurement_sku[]" class="measurement-sku" value="{{ old('measurement_sku')[$key] }}">
                                        <input type="text" name="measurement_value[]" class="measurement-value" value="{{ old('measurement_value')[$key] }}">
                                        <input type="text" name="lot[]" value="{{ old('lot')[$key] }}">
                                        <input type="text" name="unit_measure[]" value="{{ old('unit_measure')[$key] }}">
                                        <input type="text" name="product_sku[]" class="product-sku" value="{{ old('product_sku')[$key] }}">
                                        <input type="text" name="purchase_price[]" class="product-purchase-price" value="{{ old('purchase_price')[$key] }}">
                                        <input type="text" name="sale_price[]" class="product-sale-price" value="{{ old('sale_price')[$key] }}">
                                        <input type="text" name="discount_price[]" class="product-discount-price" value="{{ old('discount_price')[$key] }}">
                                        <input type="text" name="pdt_vat_percent[]" class="product-vat-percent" value="{{ old('pdt_vat_percent')[$key] }}">
                                        <input type="text" name="pdt_discount_percent[]" class="product-discount-percent" value="{{ old('pdt_discount_percent')[$key] }}">
                                        <input type="text" name="quantity[]" class="product-quantity p-qty" value="{{ old('quantity')[$key] }}">
                                        <input type="text" name="product_current_stock[]" class="product-current-stock" value="{{ old('product_current_stock')[$key] }}">
                                        <input type="text" name="line_total[]" class="product-line-total" value="{{ old('line_total')[$key] }}">
                                    </td>
                                    <td>{{ old('product_name')[$key] }} {{ old('product_variation_name')[$key] != '' ? '(' . old('product_variation_name')[$key] . ')' : '' }}</td>
                                    <td>{{ old('unit_measure')[$key] }}</td>
                                    <td class="text-end">{{ old('discount_price')[$key] > 0 ? old('discount_price')[$key] : old('sale_price')[$key] }}</td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <span class="decrement input-group-text bg-light" onclick="quantityDecrement(this)"><i class="fas fa-minus"></i></span>
                                            <input type="text" class="form-control form-control-sm text-center fw-bold product-quantity bg-light" readonly value="{{ old('quantity')[$key] }}">
                                            <span class="increment input-group-text bg-light" onclick="quantityIncrement(this)"><i class="fas fa-plus"></i></span>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        <input type="hidden" name="pdt_vat_amount[]" class="line-total-vat-amount form-control" value="{{ old('pdt_vat_amount')[$key] }}">
                                        <input type="hidden" name="pdt_total_discount_amount[]" class="line-total-discount-amount form-control" value="{{ old('pdt_total_discount_amount')[$key] }}">
                                        <span class="line-total">{{ old('line_total')[$key] }}</span>
                                    </td>

                                    <td><a href="javascript:void(0)" class="text-danger" onclick="removeItem(this)"><i class="fas fa-times"></i></a></td>
                                </tr>
                            @endforeach
                        @else
                            <tr id="emptycart">
                                <td colspan="6" class="text-center p-5">
                                    <img src="{{ asset('emptycart.png') }}" height="100" alt="emptycart">
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
