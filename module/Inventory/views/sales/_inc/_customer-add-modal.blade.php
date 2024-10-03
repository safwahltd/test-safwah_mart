<!-- Modal -->
<div class="modal" id="customerAddModal" data-backdrop="static" role="dialog" aria-labelledby="customerAddModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="customerAddModalLabel"><i class="far fa-user-plus"></i> Add Customer</h4>
            </div>

            <div class="modal-body">
                <form id="customerAddForm">
                    <div class="row">



                        <!-- NAME -->
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="name"><b>Name:</b></label>
                                <input type="text" class="form-control" id="name" autocomplete="off">
                            </div>
                        </div>




                        <!-- PHONE -->
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="phone"><b>Phone:</b><sup class="text-danger">*</sup></label>
                                <input type="number" class="form-control" id="phone" autocomplete="off" placeholder="01444444444">
                            </div>
                        </div>




                        <!-- EMAIL -->
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="email"><b>Email:</b></label>
                                <input type="email" class="form-control" id="email" autocomplete="off">
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
                                <input type="text" id="zip_code" id="zipCode" class="form-control" autocomplete="off">
                            </div>
                        </div>






                        <!-- DISTRICT -->
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="email"><b>District:</b></label>
                                <select class="form-control select2" id="district_id" onchange="getAreas(this)" style="width: 100%">
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
                                <select class="form-control select2" id="area_id" style="width: 100%">
                                    <option value="" selected>Selete Area</option>

                                </select>
                            </div>
                        </div>




                        <!-- GENDER -->
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="email"><b>Gender:</b></label>
                                <select class="form-control select2" id="gender" style="width: 100%">
                                    <option value="" selected>Selete Gender</option>
                                    @foreach (['Male', 'Female', 'Others'] as $gender)
                                        <option value="{{ $gender }}">{{ $gender }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>





                        <!-- CUSTOMER TYPE -->
                        <div class="col-sm-12 col-md-6">
                            <div class="form-group">
                                <label for="email"><b>Customer Type:</b></label>
                                <select class="form-control select2" id="customer_type_id" style="width: 100%">
                                    <option value="" selected>Selete Type</option>
                                    @foreach ($customer_types as $customer_type)
                                        <option value="{{ $customer_type->id }}">{{ $customer_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>





                        <!-- ADDRESS -->
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="address"><b>Address:</b></label>
                                <textarea name="address" class="form-control" id="address"></textarea>
                            </div>
                        </div>







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
                            <a href="javascript:void(0)" type="button" onclick="addCustomer(this)" class="btn btn-primary btn-sm">
                                <i class="fas fa-save"></i> SAVE
                            </a>
                        </div>


                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
