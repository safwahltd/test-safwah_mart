<div class="payment-info p-2" style="border-top: 3px solid #efefef">
    

    <div class="row">

        <input type="hidden" name="radio" value="pos-print">
        <input type="hidden" name="total_cost" id="invoiceTotalCost" value="{{ old('total_cost') }}">
        <input type="hidden" name="total_quantity" id="invoiceTotalQuantity" value="{{ old('total_quantity') }}">
        <input type="hidden" name="order_source" value="POS">

        <div class="col-md-3 pe-3">
            <div class="row">
                <div class="col-md-8 fs-5 text-end pe-2">
                    Subtotal :
                </div>
                <div class="col-md-4">
                    <input type="hidden" name="subtotal" id="invoiceSubtotal" value="{{ old('subtotal') }}">
                    <b id="showInvoiceSubtotal" class="fs-5">{{ old('subtotal', 0) }}</b>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 fs-5 text-end pe-2">
                    VAT :
                </div>
                <div class="col-md-4">
                    <input type="hidden" name="total_vat_amount" id="invoiceTotalVatAmount" value="{{ old('total_vat_amount') }}">
                    <input type="hidden" name="total_vat_percent" id="invoiceTotalVatPercent" value="{{ old('total_vat_percent') }}">
                    <b id="showInvoiceTotalVatAmount" class="fs-5">{{ old('total_vat_amount', 0) }}</b>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 fs-5 text-end pe-2">
                    Discount :
                </div>
                <div class="col-md-4">
                    <input type="hidden" name="total_discount_amount" id="invoiceTotalDiscountAmount" value="{{ old('total_discount_amount') }}">
                    <input type="hidden" name="total_discount_percent" id="invoiceTotalDiscountPercent" value="{{ old('total_discount_percent') }}">
                    <b id="showInvoiceTotalDiscountAmount" class="fs-5">{{ old('total_discount_amount', 0) }}</b>
                </div>
            </div>
        </div>
        <div class="col-md-3 pe-3 fs-5">
            <div class="row mt-3">
                <div class="col-md-8 fs-5 text-end pe-2">
                    Rounding :
                </div>
                <div class="col-md-4">
                    <input type="hidden" name="rounding" id="invoiceRounding" value="{{ old('rounding') }}">
                    <b id="showInvoiceRounding" class="invoice-rounding fs-5">{{ old('rounding', 0) }}</b>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 fs-5 text-end pe-2">
                    Payable :
                </div>
                <div class="col-md-4">
                    <input type="hidden" name="payable_amount" id="invoicePayable" value="{{ old('payable_amount') }}">
                    <b id="showInvoicePayable" class="fs-5">{{ old('payable_amount', 0) }}</b>
                </div>
            </div>
        </div>
        <div class="col-md-3 pe-3 fs-5">
            <div class="row">
                <div class="col-md-8 fs-5 text-end pe-2">
                    Paid :
                </div>
                <div class="col-md-4">
                    <input type="hidden" name="paid_amount" id="invoicePaidAmount" value="{{ old('paid_amount') }}">
                    <b id="showInvoicePaidAmount" class="fs-5">{{ old('paid_amount', 0) }}</b>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 fs-5 text-end pe-2">
                    Due :
                </div>
                <div class="col-md-4">
                    <input type="hidden" name="due_amount" id="invoiceDueAmount" value="{{ old('due_amount') }}">
                    <b id="showInvoiceDueAmount" class="fs-5">{{ old('due_amount', 0) }}</b>
                </div>
            </div>

            <div class="row">
                <div class="col-md-8 fs-5 text-end pe-2">
                    Change :
                </div>
                <div class="col-md-4">
                    <input type="hidden" name="change_amount" id="invoiceChangeAmount" value="{{ old('change_amount') }}">
                    <b id="showInvoiceChangeAmount" class="fs-5">{{ old('change_amount', 0) }}</b>
                </div>
            </div>
        </div>
        <div class="col-md-3 pe-3 fs-5">
            <div class="d-flex">
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button type="button" class="btn btn-info rounded-0 text-white" onclick="recentTransaction(this)" data-bs-toggle="modal" data-bs-target="#draftPaymentModal" style="width: 95%;">
                        RECENT TRANS.
                    </button>
                    <button type="button" class="btn btn-warning rounded-0 text-white" style="width: 95%;">
                        DRAFT
                    </button>
                </div>
                <div class="d-grid gap-2 col-6 mx-auto">
                    <button type="button" class="btn btn-dark rounded-0" data-bs-toggle="modal" data-bs-target="#paymentModal" style="width: 95%;" onclick="addDataToPaymentModal()">
                        PAYMENT
                    </button>
                    <button class="btn btn-success rounded-0 text-white" type="button" id="submitPOSSaleForm" style="width: 95%; color: white !important;">
                        SUBMIT
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
