<div class="modal" id="posCustomerAddModal" data-bs-backdrop="static" data-bs-keyboard="false" aria-labelledby="posCustomerAddModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-0">
            <div class="modal-body">
                <h5 class="modal-title mb-3" id="posCustomerAddModalLabel"><i class="fas fa-user-plus"></i> Add Customer</h5>
                <form id="customerAddForm">
                    <div class="row gutter-sizer align-items-center">
                        <div class="col mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" id="name" class="form-control" autocomplete="off">
                        </div>
                        <div class="col mb-3">
                            <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                            <input type="text" id="phone" class="form-control" autocomplete="off">
                        </div>
                    </div>
                    <div class="row gutter-sizer align-items-center">
                        <div class="col mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" class="form-control" autocomplete="off">
                        </div>
                        <div class="col mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-control" name="gender" id="gender">
                                <option value="" selected disabled>Select</option>
                                @foreach (['Male', 'Female', 'Others'] as $gender)
                                    <option value="{{ $gender }}">{{ $gender }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row gutter-sizer align-items-center">
                        <div class="col mb-3">
                            <label for="email" class="form-label">Customer Type</label>
                            <select class="form-control select2" id="customer_type_id" style="width: 100%">
                                <option value="" selected>Selete Type</option>
                                @foreach ($customer_types as $customer_type)
                                    <option value="{{ $customer_type->id }}">{{ $customer_type->name }}</option>
                                @endforeach
                            </select>                        </div>
                        <div class="col mb-3">
                            <label for="gender" class="form-label">Zip Code</label>
                            <input type="zip_code" id="zipCode" class="form-control" autocomplete="off">

                        </div>
                    </div>
                    <div class="row gutter-sizer align-items-center">
                        <div class="col mb-3">
                            <label for="email" class="form-label">District</label>
                            <select class="form-control select2" id="district_id" onchange="getAreas(this)" style="width: 100%">
                                <option value="" selected>Selete District</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                                @endforeach
                            </select>                        </div>
                        <div class="col mb-3">
                            <label for="gender" class="form-label">Gender</label>
                            <select class="form-control select2" id="area_id" style="width: 100%">
                                <option value="" selected>Selete Area</option>

                            </select>
                        </div>
                    </div>
                    <div class="row gutter-sizer align-items-center">
                        <div class="col mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea name="address" class="form-control" id="address" cols="30" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="text-end mt-3">
                        <button type="button" class="btn btn-success rounded-0" onclick="addCustomer(this)">SUBMIT</button>
				        <button type="button" class="btn btn-danger rounded-0" data-bs-dismiss="modal">CANCEL</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>