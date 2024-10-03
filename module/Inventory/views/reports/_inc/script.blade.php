<script>

        
    // ----- GET PRODUCT VARIATIONS ----- //
    function getProducts(obj) 
    {
        const route = `{{ route('inv.reports.axios.get-products-by-category') }}`;

        let category_id = $(obj).find('option:selected').val();
        let request_product_id = `{{ request('product_id') }}`;

        axios.get(route, {
            params: {
                category_id : category_id
            }
        })
        .then(function (response) {
            let data = response.data;

            $('#product_id').empty().select2();
            $('#product_variation_id').empty().select2();

            $('#product_id').append(`<option value="" selected>All Product</option>`).select2();
            $('#product_variation_id').append(`<option value="" selected>All Variation</option>`).select2();

            $.each(data, function (key, item) {
                $('#product_id').append(`<option value="${ item.id }" ${ request_product_id == item.id ? 'selected' : '' }>${ item.name } &mdash; ${ item.code || '' }</option>`).select2();
            })
        })
        .catch(function (error) { });
    }
    




    // ----- GET PRODUCT VARIATIONS ----- //
    getProductVariations($('#product_id'))
    function getProductVariations(obj)
    {
        const route = `{{ route('inv.reports.axios.get-variations-by-product') }}`;

        let product_id = $(obj).find('option:selected').val();

        axios.get(route, {
            params: {
                product_id : product_id
            }
        })
        .then(function (response) {
            let data = response.data;

            $('#product_variation_id').empty().select2();
            $('#product_variation_id').append(`<option value="" selected>All Variation</option>`).select2();

            $.each(data, function (key, item) {
                $('#product_variation_id').append(`<option value="${ item.id }">${ item.name }</option>`).select2();
            })
        })
        .catch(function (error) { });
    }


</script>