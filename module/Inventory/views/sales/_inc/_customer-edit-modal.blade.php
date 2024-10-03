<!-- Modal -->
<div class="modal" id="customerEditModal" data-backdrop="static" role="dialog" aria-labelledby="customerAddModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="customerAddModalLabel"><i class="far fa-user-plus"></i> Edit Customer</h4>
            </div>

            <div class="modal-body">
                <form id="customerEditForm" method="post" action="{{ route('inv.sales.axios.edit-customer') }}">
                    @csrf
                    <div class="row">


                        <!-- NAME -->
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="name"><b>Name:</b></label>
                                <input type="text" class="form-control" name="name" id="editName" autocomplete="off">
                            </div>
                        </div>




                        <!-- PHONE -->
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="phone"><b>Phone:</b><sup class="text-danger">*</sup><span id="existPhone" style="color:red;"></span></label>
                                <input type="number" class="form-control" name="mobile" id="editMobile" autocomplete="off" placeholder="01444444444" onkeyup="checkUser(this)">
                            </div>
                        </div>




                        <!-- EMAIL -->
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="email"><b>Email:</b></label>
                                <input type="email" name="email" class="form-control" id="editEmail" autocomplete="off">
                            </div>
                        </div>




                        <!-- COUNTRY -->
                        {{-- <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="text"><b>Country:</b></label>
                                <input type="text" class="form-control" id="country" value="Bangladesh" autocomplete="off" readonly>
                            </div>
                        </div> --}}




                        <!-- ZIP CODE -->
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="text"><b>ZIP Code:</b></label>
                                <input type="text" id="editZipCode" class="form-control" autocomplete="off">
                            </div>
                        </div>






                        <!-- DISTRICT -->
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="email"><b>District:</b></label>
                                <select class="form-control select2" id="editDistrictId" onchange="getAreas(this)" style="width: 100%">
                                    <option value="" selected>Selete District</option>
                                    @foreach ($districts as $district)
                                        <option value="{{ $district->id }}">{{ $district->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>




                        <!-- AREA -->
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="email"><b>Area:</b></label>
                                <select class="form-control select2" id="editAreaId" style="width: 100%">
                                    <option value="" selected>Selete Area</option>

                                </select>
                            </div>
                        </div>





                        <!-- GENDER -->
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="email"><b>Gender:</b></label>
                                <select class="form-control" id="editGender" name="gender">
                                    <option value=""  selected>Selete Gender</option>

                                </select>
                            </div>
                        </div>






                        <!-- CUSTOMER TYPE -->
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="email"><b>Customer Type:</b></label>
                                <select class="form-control select2" id="editCustomerTypeId" style="width: 100%">
                                    <option value="" selected>Selete Type</option>
                                    @foreach ($customer_types as $customer_type)
                                        {{-- <option value="{{ $customer_type->id }}" {{ $customer_type->id == $_COOKIE['customer_type_id'] ? 'selected' : '' }}>{{ $customer_type->name }}</option> --}}
                                        <option value="{{ $customer_type->id }}">{{ $customer_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>




                        <!-- ADDRESS -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="address"><b>Address:</b></label>
                                <textarea name="address" class="form-control" id="editAddress"></textarea>
                            </div>
                        </div>

                        <input type="hidden" class="form-control" id="editUserId" name="user_id" autocomplete="off">



                        <!-- IS DEFAULT -->
                        <div class="col-sm-12">
                            <div class="form-group row">
                                <label class="col-md-3 control-label" for="is_default">
                                    <b>Make Default</b>
                                </label>

                                <div class="col-md-9">
                                    <label>
                                        <input type="checkbox" class="ace ace-switch ace-switch-2" id="is_default">
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                            </div>
                        </div>



                        <!-- ACTION -->
                        <div class="col-sm-12 text-right">
                            <button type="button" onclick="editCustomer(this)" id="customerEditFormSubmitButton" class="btn btn-primary btn-sm">
                                <i class="fas fa-save"></i> SAVE
                            </button>
                        </div>


                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
