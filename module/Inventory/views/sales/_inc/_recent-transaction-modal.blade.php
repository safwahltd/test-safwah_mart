<div class="modal recent-transaction-modal" id="draftPaymentModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="draftPaymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered justify-content-center">
        <div class="modal-content rounded-0">

            <div class="recent-transaction-modal-header">
                <div class="row mt-2">
                    <div class="col-lg-6">
                        <h3 style="font-weight: bold; text-transform: uppercase; margin-bottom: 0;    color: #004d9b;">Recent Transaction</h3>
                    </div>
                    <div class="col-lg-2"></div>
                    <div class="col-lg-4 d-flex">
                        <span class="input-group-text"><i class="far fa-calendar"></i></span>
                        <input type="text" name="date" class="form-control datepicker" onchange="recentTransaction(this)" value="{{ old('date', date('Y-m-d')) }}" data-date-format="yyyy-mm-dd">
                    </div>
                </div>
            </div>

			<div class="modal-body text-center recent-transaction-modal-body pb-0">

                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                      <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Sale</button>
                      <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Quotation</button>
                      <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Draft</button>
                    </div>
                </nav>

                <div class="tab-content" id="nav-tabContent">

                    <div class="tab-pane fade show active sale-pane" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                        <table class="table table-striped">
                            <tbody id="recent_transaction">
                                <tr class="content-body">
                                    <td class="serial">1</td>
                                    <td class="title">
                                        <a href="javascript:void(0)">123345 ( Name )</a>
                                    </td>
                                    <td class="amount">120.00</td>
                                    <td class="action">
                                        <a href="#">
                                            <i class="fas fa-edit edit-icon"></i>
                                        </a>
                                        <a href="#">
                                            <i class="fas fa-trash trash-icon"></i>
                                        </a>
                                        <a href="#">
                                            <i class="fas fa-print print-icon"></i>
                                        </a>
                                        <a href="#">
                                            <i class="fas fa-eye eye-icon"></i>
                                        </a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">
                        <div class="content-body">
                            <div class="serial">3</div>
                            <div class="title">
                                <a href="#">123345 ( Name )</a>
                            </div>
                            <div class="amount">120.00</div>
                            <div class="action">
                                <a href="#">
                                    <i class="fas fa-edit edit-icon"></i>
                                </a>
                                <a href="#">
                                    <i class="fas fa-trash trash-icon"></i>
                                </a>
                                <a href="#">
                                    <i class="fas fa-print print-icon"></i>
                                </a>
                                <a href="#">
                                    <i class="fas fa-eye eye-icon"></i>
                                </a>
                            </div>
                        </div>
                        <div class="content-body">
                            <div class="serial">3</div>
                            <div class="title">
                                <a href="#">123345 ( Name )</a>
                            </div>
                            <div class="amount">120.00</div>
                            <div class="action">
                                <a href="#">
                                    <i class="fas fa-edit edit-icon"></i>
                                </a>
                                <a href="#">
                                    <i class="fas fa-trash trash-icon"></i>
                                </a>
                                <a href="#">
                                    <i class="fas fa-print print-icon"></i>
                                </a>
                                <a href="#">
                                    <i class="fas fa-eye eye-icon"></i>
                                </a>
                            </div>
                        </div>
                        <div class="content-body">
                            <div class="serial">3</div>
                            <div class="title">
                                <a href="#">123345 ( Name )</a>
                            </div>
                            <div class="amount">120.00</div>
                            <div class="action">
                                <a href="#">
                                    <i class="fas fa-edit edit-icon"></i>
                                </a>
                                <a href="#">
                                    <i class="fas fa-trash trash-icon"></i>
                                </a>
                                <a href="#">
                                    <i class="fas fa-print print-icon"></i>
                                </a>
                                <a href="#">
                                    <i class="fas fa-eye eye-icon"></i>
                                </a>
                            </div>
                        </div>
                    </div>


                    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab">
                        <div class="content-body">
                            <div class="serial">3</div>
                            <div class="title">
                                <a href="#">123345 ( Name )</a>
                            </div>
                            <div class="amount">120.00</div>
                            <div class="action">
                                <a href="#">
                                    <i class="fas fa-edit edit-icon"></i>
                                </a>
                                <a href="#">
                                    <i class="fas fa-trash trash-icon"></i>
                                </a>
                                <a href="#">
                                    <i class="fas fa-print print-icon"></i>
                                </a>
                                <a href="#">
                                    <i class="fas fa-eye eye-icon"></i>
                                </a>
                            </div>
                        </div>
                        <div class="content-body">
                            <div class="serial">3</div>
                            <div class="title">
                                <a href="#">123345 ( Name )</a>
                            </div>
                            <div class="amount">120.00</div>
                            <div class="action">
                                <a href="#">
                                    <i class="fas fa-edit edit-icon"></i>
                                </a>
                                <a href="#">
                                    <i class="fas fa-trash trash-icon"></i>
                                </a>
                                <a href="#">
                                    <i class="fas fa-print print-icon"></i>
                                </a>
                                <a href="#">
                                    <i class="fas fa-eye eye-icon"></i>
                                </a>
                            </div>
                        </div>
                        <div class="content-body">
                            <div class="serial">3</div>
                            <div class="title">
                                <a href="#">123345 ( Name )</a>
                            </div>
                            <div class="amount">120.00</div>
                            <div class="action">
                                <a href="#">
                                    <i class="fas fa-edit edit-icon"></i>
                                </a>
                                <a href="#">
                                    <i class="fas fa-trash trash-icon"></i>
                                </a>
                                <a href="#">
                                    <i class="fas fa-print print-icon"></i>
                                </a>
                                <a href="#">
                                    <i class="fas fa-eye eye-icon"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>

			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-success text-white" data-bs-dismiss="modal" data-type="ok">OK</button>
				<button type="button" class="btn btn-danger text-white" data-bs-dismiss="modal" data-type="cancel">CANCEL</button>
			</div>

		</div>
    </div>
</div>

