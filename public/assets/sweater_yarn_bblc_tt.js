
function addYarnForBbblOrTt()
{
    var currencyRate        = $("#currencyRate").val() > 0 ? parseFloat($("#currencyRate").val()) : 0
    var yarn_composition    = $("#yarn_composition").val() > 0 ? parseFloat($("#yarn_composition").val()) : 0
    var qty                 = $("#qty").val() > 0 ? parseFloat($("#qty").val()) : 0
    var fc_price            = $("#fc_price").val() > 0 ? parseFloat($("#fc_price").val()) : 0
    var bdt_price           = $("#bdt_price").val() > 0 ? parseFloat($("#bdt_price").val()) : 0;
    var yarn                = $("#yarn_composition option:selected");

    var fc_value            = fc_price * qty
    var bdt_value           = bdt_price * qty


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
        let yarn_id   = yarn.val()
        let yarn_name = yarn.text()
        let item_unit = $(".select-item-unit option:selected")

        var tr = `<tr> 
                    <td class="serial"></td>
                    <td><input type="hidden" class="select-yarn-id" name="yarn_id[]" value="${ yarn_id }">${ yarn_name }</td>
                    <td><input type="hidden" name="item_units[]" value="${ item_unit.val() }">${ item_unit.text() }</td>

                    <td><input type="text" class="form-control fc-quantity input-small text-center" name="qtys[]" readonly       value="${ qty }"></td>
                    <td><input type="text" class="form-control text-center input-small" name="fc_prices[]" readonly  value="${ fc_price }"></td>
                    <td><input type="text" class="form-control text-center input-small" name="bdt_prices[]" readonly  value="${ bdt_price }"></td>
                    <td><input type="text" class="form-control fc-value text-center input-small" name="fc_values[]" readonly  value="${ fc_value }"></td>
                    <td><input type="text" class="form-control yarn-bdt-value text-center input-small" name="bdt_values[]" readonly value="${ bdt_value }"></td>
                    <td><textarea name="remarks[]" class="form-control"></textarea></td>
                    <td><button type="button" class="btn btn-minier btn-danger" onclick="removeTr(this)"><i class="fa fa-times"></i></button></td>
                </tr>`



        $("#supplier_pi_table").append(tr)
        $("#yarn_composition option[value=" + yarn.val() + "]").attr('disabled','disabled');
        $("#yarn_composition").focus()
        $("#yarn_composition").val('').trigger('chosen:updated');

        $("#qty").val('')
        $("#fc_price").val('')
        $("#bdt_price").val('')

        $('.to-bdt').attr('readonly', true)

        serial()

    }
}

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



// input by keyboard enter event on chosen
$(".select-yarn-composition").chosen()
container = $(".select-yarn-composition").data("chosen").container
container.bind("keypress", function(event){
    if (event.keyCode == 13) {
        event.preventDefault();
        $('.yarn-composition-quantity').focus()
    }
});



function serial(){
    $(".serial").each(function (index){
        $(this).text(index+1)
    })

    grandTotalCal()
}

function removeTr(object)
{
    let yarn_id = $(object).closest('tr').find('.select-yarn-id').val()
    $(object).closest('tr').remove()

    serial()

    $("#yarn_composition option[value=" + yarn_id + "]").attr('disabled',false);
    $("#yarn_composition").val('').trigger('chosen:updated');
}



function setFcprice(evnt)
{

    // <!-- first catch key code
    let keycode = (evnt.keyCode ? evnt.keyCode : evnt.which);

    // <!-- check key is enter
    if(keycode == '13') {
        evnt.preventDefault();
        addYarnForBbblOrTt()
    }

    let currencyBdtRate = $('#currencyRate').val() | 0
    let bdtPrice        = $('#bdt_price').val()

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

        if ($('#fc_price').val() == '0.00') {
            $('#fc_price').val('')
        }
    }
}
