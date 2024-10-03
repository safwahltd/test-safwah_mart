<style>
    .modal.right .modal-dialog {
        position: fixed;
        margin: auto;
        width: 320px;
        height: 100%;
        -webkit-transform: translate3d(0%, 0, 0);
        -ms-transform: translate3d(0%, 0, 0);
        -o-transform: translate3d(0%, 0, 0);
        transform: translate3d(0%, 0, 0);
    }

    .modal.right .modal-content {
        height: 100%;
        overflow-y: auto;
    }

    .modal.right .modal-body {
        padding: 15px 15px 80px;
    }

    /*Right*/
    .modal.right.fade .modal-dialog {
        right: -320px;
        -webkit-transition: opacity 0.3s linear, right 0.3s ease-out;
        -moz-transition: opacity 0.3s linear, right 0.3s ease-out;
        -o-transition: opacity 0.3s linear, right 0.3s ease-out;
        transition: opacity 0.3s linear, right 0.3s ease-out;
    }

    .modal.right.fade.in .modal-dialog {
        right: 0;
    }

    /* ----- MODAL STYLE ----- */
    .modal-content {
        border-radius: 0;
        border: none;
    }

    .modal-header {
        border-bottom-color: #EEEEEE;
        background-color: #FAFAFA;
    }

    .modal-body>p,
    .modal-title {
        color: black;
    }

</style>



<!-- Modal -->
<div class="modal right fade" id="customerAddModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="customerAddModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="customerAddModalLabel"><i class="far fa-user-circle"></i> Add Customer</h4>
            </div>

            <div class="modal-body">
                <form id="customerAddForm">
                    <div class="row">
                        <div class="col-sm-12">


                            <!-- NAME -->
                            <div class="form-group">
                                <label for="name"><b>Name:</b></label>
                                <input type="text" class="form-control" id="name" autocomplete="off">
                            </div>





                            <!-- PHONE -->
                            <div class="form-group">
                                <label for="phone"><b>Phone:</b><sup class="text-danger">*</sup></label>
                                <input type="number" class="form-control" id="phone" autocomplete="off" placeholder="01444444444">
                            </div>





                            <!-- EMAIL -->
                            <div class="form-group">
                                <label for="email"><b>Email:</b></label>
                                <input type="email" class="form-control" id="email" autocomplete="off">
                            </div>





                            <!-- GENDER -->
                            <div class="form-group">
                                <label for="email"><b>Gender:</b></label>
                                <select class="form-control" id="gender">
                                    <option value="" selected>Selete Gender</option>
                                    @foreach (['Male', 'Female', 'Others'] as $gender)
                                        <option value="{{ $gender }}">{{ $gender }}</option>
                                    @endforeach
                                </select>
                            </div>
                            




                            <!-- ADDRESS -->
                            <div class="form-group">
                                <label for="address"><b>Address:</b></label>
                                <textarea name="address" class="form-control" id="address"></textarea>
                            </div>






                            <!-- IS DEFAULT -->
                            <div class="form-group row mt-3">
                                <label class="col-md-5 control-label" for="is_default">
                                    <b>Make Default</b>
                                </label>

                                <div class="col-md-7">
                                    <label>
                                        <input type="checkbox" class="ace ace-switch ace-switch-2" id="is_default">
                                        <span class="lbl"></span>
                                    </label>
                                </div>
                            </div>





                            <!-- ACTION -->
                            <a href="javascript:void(0)" type="button" onclick="addCustomer(this)" class="btn btn-primary btn-sm">
                                <i class="fas fa-save"></i> Save
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
