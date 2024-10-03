
<script>
    function getProductType(obj)
    {
        let productTypeId = $(obj).find('option:selected').data('product_type_id');

        if (productTypeId == undefined) {
            $("#product_type_id option[value='1']").prop("selected", true);
            $('#productType').show();
            $('.select2').select2();
            return;
        }

        $("#product_type_id option").each(function() {
            if ($(this).val() == productTypeId) {
                
                $("#product_type_id option[value='" + productTypeId + "']").attr("selected", "selected");

                $('#productType').hide();
            }
        });

        $('.select2').select2();
    }
</script>