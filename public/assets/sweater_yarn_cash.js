function addYarn()
{
    var currencyRate        = $("#currencyRate").val() > 0 ? parseFloat($("#currencyRate").val()) : 0
    var yarn_composition    = $("#yarn_composition").val() > 0 ? parseFloat($("#yarn_composition").val()) : 0
    var qty                 = $("#qty").val() > 0 ? parseFloat($("#qty").val()) : 0
    var fc_price            = $("#fc_price").val() > 0 ? parseFloat($("#fc_price").val()) : 0
    var bdt_price           = $("#bdt_price").val() > 0 ? parseFloat($("#bdt_price").val()) : 0
    var yarn                = $("#yarn_composition option:selected");
    let yarn_id             = yarn.val()


    if (!currencyRate) {
        swal.fire({
            title: "Error",
            html: "<b>Please Select Currency !</b>",
            type: "error",
            timer: 1000
        });
    } else if (!yarn_composition) {
        swal.fire({
            title: "Error",
            html: "<b>Please Select Yarn !</b>",
            type: "error",
            timer: 1000
        });
    } else if (!qty) {
        swal.fire({
            title: "Error",
            html: "<b>Please Set Qty !</b>",
            type: "error",
            timer: 1000
        });
    } else if (!fc_price) {
        swal.fire({
            title: "Error",
            html: "<b>Please Set Fc Price !</b>",
            type: "error",
            timer: 1000
        });
    } else {

        var table = `<div class="mb-6 yarn-table">
                        <div class="space-10"></div>
                            <h3>
                                <span class="table_serial"></span>. <span class="added-yarn-name">${ yarn.text() }</span> 
                                <span class="btn btn-sm btn-danger pull-right" onclick="removeYarnTable(this, ${ yarn_id })"><i class="fa fa-times"></i></span>
                                <small class="yarn-validation-message text-danger ml-1"></small>
                            </h3>
                            <input type="hidden" name="yarn_id[]" value="${ yarn_id }">

                            <input type="hidden" name="yarn_quantities[]" value="${ qty }">
                            <input type="hidden" class="yarn-currency-rate" name="yarn_currency_rates[]" value="${ currencyRate }">
                            <input type="hidden" name="fc_prices[]" value="${ fc_price }">
                            <input type="hidden" class="yarn-table-bdt-price" name="bdt_prices[]" value="${ bdt_price }">


                            <input type="hidden" name="old_yarn_composition_ids[]" value="">
                            
                            <table class="table table-bordered" id="table_${ yarn_id }">
                                <tr>
                                    <th colspan="12" class="text-center bg-success" style="color: #588e6e; font-size: 14px; font-style="italic">
                                        Oty: <span class="added-yarn-quantities">${ qty }</span>
                                        - Currency Rate: <span id="currency_rate_${ yarn_id }">${ currencyRate }</span>
                                        - Fc Price: <span id="fc_price_${ yarn_id }"><span class="yarn-table-fc-price">${ fc_price }</span></span>
                                        - Bdt Price: <span id="bdt_price_${ yarn_id }">${ bdt_price }</span>
                                    </th>
                                </tr>
            
                                <tr>
                                    <th class="bg-success">Sl</th>
                                    <th class="bg-success">Color Name</th>
                                    <th class="bg-success">Pantone</th>
                                    <th class="bg-success">Lab-dip ref.</th>
                                    <th class="bg-success">Color No</th>
                                    <th class="bg-success">Date</th>
                                    <th class="bg-success">Shade</th>
                                    <th class="bg-success">Qty/Lbs</th>
                                    <th class="bg-success">Rate</th>
                                    <th class="bg-success">Total</th>
                                    <th class="bg-success">Remarks</th>
                                    <th class="bg-success"></th>
                                </tr>
            
                                <tr>
                                    <td class="serial_${ yarn_id } item-serial">1</td>
                                    <td>
                                        <input type="hidden" name="old_detail_ids[${ yarn_id }][]" value="">
                                        <input type="text" class="form-control input-sm" name="color_name[${ yarn_id }][]"></td>
                                    <td><input type="text" class="form-control input-sm" name="pantone[${ yarn_id }][]"></td>
                                    <td><input type="text" class="form-control input-sm" name="lab_dip_ref[${ yarn_id }][]"></td>
                                    <td><input type="text" class="form-control input-sm" name="color_number[${ yarn_id }][]"></td>
                                    <td><input type="text" class="form-control input-sm date-picker" name="yarn_date[${ yarn_id }][]"></td>
                                    <td><input type="text" class="form-control input-sm" name="shade[${ yarn_id }][]"></td>
                                    <td>
                                        <input type="number" class="form-control input-sm text-center yarn-item-quantity" name="qty[${ yarn_id }][]" onkeyup="checkQty(this)">
                                    </td>
                                    <td>
                                        <input type="number" step="0.01" class="form-control text-center" name="rate[${ yarn_id }][]" value="${ fc_price }" readonly>
                                    </td>
                                    <td>
                                        <input type="text" class="form-control input-sm yarn-item-subtotal text-center" name="total[${ yarn_id }][]" readonly>
                                    </td>
                                    <td><textarea  name="remarks[${ yarn_id }][]" class="form-control"></textarea></td>
                                    <td>
                                        <button type="button" class="ibtnDel btn btn-minier btn-danger" onclick="removeTableTr(this)">
                                            <i class="fa fa-times-circle"></i>
                                        </button>
                                    </td>
                                </tr>


                                <tfoot>
                                    <tr>
                                        <td colspan="7"><strong>Subtotal:</strong></td>
                                        <td class="text-center"><span class="bolder total-fc-quantity"></span></td>
                                        <td></td>
                                        <td class="text-center"><span class="bolder total-fc-value"></span></td>
                                        <td colspan="2"></td>
                                    </tr>
                                </tfoot>
                            </table>

                            <button class="btn btn-mini btn-primary pull-right" type="button" id="add_more_${ yarn_id }" onclick="addMore(${ yarn_id })">
                                <i class="fa fa-plus"></i> Add More
                            </button>
                        </div>`

        $("#trimData").append(table)
        $("#yarn_composition option[value=" + yarn_id + "]").attr('disabled','disabled');
        $("#yarn_composition").val('').trigger('chosen:updated');

        $("#qty").val("")
        $("#fc_price").val("")
        $("#bdt_price").val("")

        $('.date-picker').datepicker({
            autoclose: true,
            format:'yyyy-mm-dd',
            todayHighlight: true
        }).next().on(ace.click_event, function(){
            $(this).prev().focus();
        });


        setSerialTable()

        // set read only currency rate
        $('#currencyRate').attr('readonly', true)

        observeSaveButtonActivity()
    }
}

// input by keyboard enter event on chosen
$(".select-yarn-composition").chosen()
container = $(".select-yarn-composition").data("chosen").container
container.bind("keypress", function(event){
    if (event.keyCode == 13) {
        event.preventDefault();
        $('.yarn-composition-quantity').focus()
    }
});


// <!-- added item when press enter
$('.yarn-composition-quantity').keypress(function(event) {
    // <!-- first catch key code
    let keycode = (event.keyCode ? event.keyCode : event.which);

    // <!-- check key is enter
    if(keycode == '13') {
        event.preventDefault();
        $('.select-fc-rate').focus()
    }
})

// <!-- added item when press enter
$('.select-fc-rate').keypress(function(event) {
    // <!-- first catch key code
    let keycode = (event.keyCode ? event.keyCode : event.which);

    // <!-- check key is enter
    if(keycode == '13') {
        event.preventDefault();
        addYarn()
    }
})

function removeYarnTable(object, yarn_id)
{
    $(".select-yarn-composition option[value=" + yarn_id + "]").attr('disabled', false);
    $(".select-yarn-composition").focus();
    $('.select-yarn-composition').val('').trigger('chosen:updated');
    $(".select-yarn-composition").trigger('chosen:activate');

    $(object).closest('.yarn-table').remove()

    if ($('.yarn-table').length < 1) {
        $('#currencyRate').attr('readonly', false)
        $(".select-currency").attr('disabled', false);
        $(".select-currency").trigger('chosen:updated');
    }
    grandTotalCal()
}

function removeTable(id)
{
    $("#table_"+id).remove()
    $("#add_more_"+id).remove()
    $("#yarn_composition option[value=" + id + "]").attr('disabled', false)
    $("#yarn_composition").val('').trigger('chosen:updated')

    grandTotalCal()
    
}



function setSerialTable(){
    $(".table_serial").each(function (index){
        $(this).text(index+1)
    })
}


function setSerialTr(id){
    $(".serial_"+id).each(function (index){
        $(this).text(index+1)
    })
}


var i = 2;
var key = 1;

function addMore(id)
{
    var fc_price = $('#fc_price_'+id).text();

    var newRow = $("<tr>");
    var cols = "";

    cols += '<td class="serial_'+id+' item-serial"></td>';
    cols += '<td><input type="hidden" name="old_detail_ids['+id+'][]" value=""><input type="text" class="form-control input-sm" name="color_name['+id+'][]"></td>';
    cols += '<td><input type="text" class="form-control input-sm" name="pantone['+id+'][]"></td>';
    cols += '<td><input type="text" class="form-control input-sm" name="lab_dip_ref['+id+'][]"></td>';
    cols += '<td><input type="text" class="form-control input-sm" name="color_number['+id+'][]"></td>';
    cols += '<td><input type="text" class="form-control input-sm date-picker" name="yarn_date['+id+'][]"></td>';
    cols += '<td><input type="text" class="form-control input-sm" name="shade['+id+'][]"></td>';
    cols += '<td><input type="number" name="qty['+id+'][]" class="form-control  yarn-item-quantity text-center" onkeyup="checkQty(this)"></td>';
    cols += '<td><input type="number" name="rate['+id+'][]" step="0.01" class="form-control text-center" value="'+fc_price+'" readonly></td>';
    cols += '<td><input type="text" name="total['+id+'][]" class="form-control input-sm yarn-item-subtotal text-center" readonly></td>';
    cols += '<td><textarea name="remarks['+id+'][]" class="form-control"></textarea></td>';
    cols += '<td><button type="button" class="ibtnDel btn btn-minier btn-danger" onclick="removeTableTr(this)"><i class="fa fa-times-circle"></i></button></td>';
    cols += '</tr>';
    i++;


    newRow.append(cols);
    $("#table_"+id).append(newRow);
    setSerialTr(id);

    $('.date-picker').datepicker({
        autoclose: true,
        format:'yyyy-mm-dd',
        todayHighlight: true
    }).next().on(ace.click_event, function(){
        $(this).prev().focus();
    });

}

function removeTableTr(object)
{
    let table = $(object).closest('table')

    $(object).closest("tr").remove();
 
    table.find('.item-serial').each(function (index){
        $(this).text(index+1)
    })

    observeSaveButtonActivity()
}

function setFcprice(evnt)
{

    // <!-- first catch key code
    let keycode = (evnt.keyCode ? evnt.keyCode : evnt.which);

    // <!-- check key is enter
    if(keycode == '13') {
        evnt.preventDefault();
        addYarn()
    }

    let currencyBdtRate = $('#currencyRate').val() | 0
    let bdtPrice        = $('#bdt_price').val()
    let quantity        = $('#qty').val()

    if (currencyBdtRate < 1) {
        $('#bdt_price').val('')
        swal.fire({
            title: "Error",
            html: "<b>Please select currency and bdt price must be greater than 0 !</b>",
            type: "error",
            timer: 4000
        });
        
    } else {
        $('#fc_price').val(((bdtPrice / currencyBdtRate)).toFixed(2))
    }
}
