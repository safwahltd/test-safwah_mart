<script>

    // ----- GET AREAS ----- //

    // getAreas($('#district_id'))
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


</script>
