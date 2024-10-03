<script>




    //--------------------------------------------------------------------//
    //                        GET AREAS METHOD                            //
    //--------------------------------------------------------------------//
    function getAreas(obj)
    {
        const route = `{{ route('inv.get-areas-by-district') }}`;

        let district_id = $(obj).find('option:selected').val();
        // alert(district_id);

        axios.get(route, {
            params: {
                district_id : district_id
            }
        })
        .then(function (response) {
            let data = response.data;

            // alert(data);

            $('#area_id').empty().select2();
            $('#area_id').append(`<option value="" selected>Select an Area</option>`).select2();

            $.each(data, function (key, item) {
                $('#area_id').append(`<option value="${ item.id }">${ item.name }</option>`).select2();
            })
        })
        .catch(function (error) { });
    }






    //--------------------------------------------------------------------//
    //                         ADD CUSTOMER (AXIOS)                       //
    //--------------------------------------------------------------------//
    function addCustomer(obj)
    {

        let _this           = $(obj).closest('#customerAddForm');
        let name            = _this.find('#name').val();
        let phone           = _this.find('#phone').val();
        let email           = _this.find('#email').val();
        let zip_code        = _this.find('#zip_code').val();
        let district_id     = _this.find('#district_id').val();
        let area_id         = _this.find('#area_id').val();
        let customer_type_id= _this.find('#customer_type_id').val();
        let gender          = _this.find('#gender').find('option:selected').val();
        let address         = _this.find('#address').val();
        let is_default      = 0;

        if(_this.find('#is_default').prop("checked") == true){
            is_default = 1
        }
        else if(_this.find('#is_default').prop("checked") == false){
            is_default = 0
        }

        if (phone == '') {
            alert('Customer Phone is required!');
            return;
        }

        if (phone.length != 11) {
            alert('Phone Number must be 11 digits!');
            return;
        }


        const route = `{{ route('inv.sales.axios.create-customer') }}`;

        axios.post(route, {

            name            : name,
            phone           : phone,
            email           : email,
            zip_code        : zip_code,
            district_id     : district_id,
            area_id         : area_id,
            customer_type_id: customer_type_id,
            gender          : gender,
            address         : address,
            is_default      : is_default,
        })
        .then(function (response) {

            // $('.payment-info').show();
            // $('.customer-info').show();
            // $('#customerAddForm').hide();
            // $('#paymentAddForm').hide();

            $('#customerAddModal').modal('hide');

            appendAndSelectCustomer(response.data);

            _this.find('#name').val('');
            _this.find('#phone').val('');
            _this.find('#email').val('');
            _this.find('#zip_code').val('');
            _this.find('#district_id').val('');
            _this.find('#area_id').val('');
            _this.find('#customer_type_id').val('');
            _this.find('#gender').find('option:selected').val('');
            _this.find('#address').val('');


        })
        .catch(function (error) { });
    }







    //--------------------------------------------------------------------//
    //                        EDIT CUSTOMER (AXIOS)                       //
    //--------------------------------------------------------------------//
    function editCustomer(obj)
    {
        let _this           = $(obj).closest('#customerEditForm');
        let user_id         = _this.find('#editUserId').val();
        let name            = _this.find('#editName').val();
        let phone           = _this.find('#editMobile').val();
        let email           = _this.find('#editEmail').val();
        let zip_code        = _this.find('#editZipCode').val();
        let district_id     = _this.find('#editDistrictId').val();
        let area_id         = _this.find('#editAreaId').val();
        let customer_type_id= _this.find('#editCustomerTypeId').val();
        let gender          = _this.find('#editGender').find('option:selected').val();
        let address         = _this.find('#editAddress').val();
        let is_default      = 0;


        if(_this.find('#is_default').prop("checked") == true){
            is_default = 1
        }
        else if(_this.find('#is_default').prop("checked") == false){
            is_default = 0
        }

        if (phone == '') {
            alert('Customer Phone is required!');
            return;
        }

        if (phone.length != 11) {
            alert('Phone Number must be 11 digits!');
            return;
        }

        const route = `{{ route('inv.sales.axios.edit-customer') }}`;

        axios.post(route, {
            user_id         : user_id,
            name            : name,
            phone           : phone,
            email           : email,
            zip_code        : zip_code,
            district_id     : district_id,
            area_id         : area_id,
            customer_type_id: customer_type_id,
            gender          : gender,
            address         : address,
            is_default      : is_default,
        })
        .then(function (response) {

            $('#customerEditModal').modal('hide');

            _this.find('#editName').val('');
            _this.find('#editPhone').val('');
            _this.find('#editEmail').val('');
            _this.find('#zip_code').val('');
            _this.find('#district_id').val('');
            _this.find('#area_id').val('');
            _this.find('#customer_type_id').val('');
            _this.find('#editGender').find('option:selected').val('');
            _this.find('#editAddress').val('');

            localStorage.setItem('customer_type_id','');

        })
        .catch(function (error) { });
    }








    //--------------------------------------------------------------------//
    //                      SHOW EDIT CUSTOMER METHOD                     //
    //--------------------------------------------------------------------//
    function showEditCustomer(){

        let name                = $("#customer_id").find('option:selected').data('name');
        let mobile              = $("#customer_id").find('option:selected').data('mobile');
        let email               = $("#customer_id").find('option:selected').data('email');
        let address             = $("#customer_id").find('option:selected').data('address');
        let gender              = $("#customer_id").find('option:selected').data('gender');
        let zip_code            = $("#customer_id").find('option:selected').data('zip_code');
        let district_id         = $("#customer_id").find('option:selected').data('district_id');
        let area_id             = $("#customer_id").find('option:selected').data('area_id');
        let customer_type_id    = $("#customer_id").find('option:selected').data('customer_type_id');
        let is_default          = $("#customer_id").find('option:selected').data('is_default');
        let userId              = $("#customer_id").find('option:selected').data('user_id');
        alert(name);
        $("#editName").val(name);
        $("#editMobile").val(mobile);
        $("#editEmail").val(email);
        $("#editAddress").val(address);
        $("#editZipCode").val(zip_code);

        $("#editUserId").val(userId);
        console.log(gender);
        $("#editGender").val(gender);


        $("#editGender").html(`
            <option value="" selected>Select Gender</option>
            <option value="Male" ${ gender == "Male" ? "selected" : '' }>Male</option>
            <option value="Female" ${ gender == "Female" ? "selected" : '' }>Female</option>
            <option value="Others" ${ gender == "Others" ? "selected" : '' }>Others</option>
        `);


        $("#editDistrictId").val(district_id).trigger('change').select2();
        $("#editCustomerTypeId").val(customer_type_id).trigger('change').select2();


        if(district_id != null && area_id != null){
            getEditAreas(district_id, area_id)
        }

    }








    //--------------------------------------------------------------------//
    //                APPEND & SELECT CUSTOMER METHOD                     //
    //--------------------------------------------------------------------//
    function appendAndSelectCustomer(response)
    {

        let is_new = response.is_new;
        let data = response.data;

        if (is_new == 'Yes') {

            $('#customer_id').append(`<option value='${ data.id }' selected>${ data.name + ' - ' + data.phone }</option>`);
            $('#customerId').append(`<option value='${ data.id }' data-phone='${ data.phone }' data-email='${ data.email }' selected>${ data.name }</option>`);

            Swal.fire(
                'Success',
                'Customer create successfully',
                'success'
            )

            success('toastr', 'Customer create successfully');

        } else {

            $("#customer_id option").each(function() {

                if ($(this).val() == data.id) {
                    $("#customer_id option[value='" + data.id + "']").attr('selected', 'selected');
                }
            });

            Swal.fire(
                'Success',
                'Customer already exists',
                'info'
            );

            success('toastr', 'Customer already exists');
        }

        setCustomerInfo(data.name, data.phone, data.email, data.address)

        // $('.select2').select2();
    }




    function getEditAreas(district_id, area_id)
    {
        const route = `{{ route('inv.get-areas-by-district') }}`;

        axios.get(route, {
            params: {
                district_id : district_id
            }
        })
        .then(function (response) {
            let data = response.data;

            // alert(data);

            $('#editAreaId').empty().select2();
            $('#editAreaId').append(`<option value="" selected>Select an Area</option>`).select2();

            $.each(data, function (key, item) {
                $('#editAreaId').append(`<option value="${ item.id }" ${ area_id == item.id ? 'selected' : '' }>${ item.name }</option>`).select2();
            })
        })
        .catch(function (error) { });
    }


</script>
