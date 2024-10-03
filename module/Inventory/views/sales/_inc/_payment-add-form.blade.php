<div class="modal payment-add-modal" id="paymentModal" data-bs-backdrop="static" data-bs-keyboard="false"  aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered justify-content-center">
        <div class="modal-content rounded-0">

            <div class="modal-header justify-content-center text-uppercase">
                <h3 class="mb-0" style="font-weight: bold;    color: #004d9b;">Payment</h3>
            </div>
            <div class="d-flex justify-content-between" style="padding: 10px 18px 0 15px;">
                <div style="font-size: 16px">
                    <b>Payable: &nbsp;&nbsp;</b>৳ <span style="font-size: 16px" id="invoicePayableAmount">0.00</span>
                </div>
                <div style="font-size: 16px">
                    <b>Paid: &nbsp;&nbsp;</b>৳ <span style="font-size: 16px" id="pay">0.00</span>
                </div>
            </div>

			<div class="modal-body text-center payment-add-modal-body">


                <table class="table table-bordered table-striped" id="payment-table">
                    <tbody>

                        {{-- FIRST ROW --}}
                        <tr class="first-tr">
                            <td style="width: 4%"><span class="sn-no">1</span></td>
                            <td style="width: 50%">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <label class="input-group-text">
                                            Account
                                        </label>
                                    </div>
                                    <select name="ecom_account_id[]" class="form-control ecom-account select2" onchange="checkAccountExistOrNot(this)">
                                        <option value="" selected class="text-left">- Select -</option>
                                        @foreach ($accounts as $account)
                                            <option value="{{ $account->id }}">{{ $account->name }}</option>
                                        @endforeach
                              
                                    </select>

                                </div>
                            </td>

                            <td style="width: 40%">
                                <div class="input-group">
                                    <div class="input-group-addon">
                                        <label class="input-group-text">
                                            Amount
                                        </label>
                                    </div>
                                    <input type="text" name="payment_amount[]" class="form-control only-number text-right payment-modal-paid-amount" placeholder="Type amount" autocomplete="off" onkeyup="calculatePaymentModalPaidAmount()" requird>
                                </div>
                            </td>

                            <td class="text-center" style="width: 6%">
                                <div class="btn-group">
                                    <a href="javascript:void(0)" class="btn btn-sm btn-info text-white add-button" onclick="addPaymentAccount()" type="button">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>

                    </tbody>

                    {{-- <tfoot>
                        <tr>
                            <th colspan="3" class="text-right">
                                <span class="label label-inverse">
                                    <strong id="total_payment_amount">0</strong>
                                </span>
                            </th>
                        </tr>
                    </tfoot> --}}

                </table>

			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-success text-white" data-bs-dismiss="modal" data-type="ok" onclick="calculatePaid(this)">OK</button>
				<button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal" data-type="cancel" onclick="calculatePaid(this)">CANCEL</button>
			</div>

		</div>
    </div>
</div>

