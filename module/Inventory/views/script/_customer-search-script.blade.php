<script>
     $(document).ready(function () {

            $("#customer_id").select2({
                ajax: {
                    url: `{{ route('get-customers') }}`,
                    type: 'GET',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        return {
                            q: params.term, // search term
                            page: params.current_page
                        };
                    },
                    processResults: function(data, params) {
                        params.current_page = params.current_page || 1;
                        return {
                            results: data.data,
                            pagination: {
                                more: (params.current_page * 30) < data.total
                            }
                        };
                    },
                    autoWidth: true,
                    cache: true
                },
                placeholder: 'Search Customer(s)',
                minimumInputLength: 1,
                templateResult: formatCustomer,
                templateSelection: formatCustomerSelection
            }).on('change', function(e) {
                console.log($(this).select2('data')[0]);
                // let customer_data = JSON.stringify($(this).select2('data')[0]);
                // let customer_base64 = Buffer.from(customer_data).toString("base64");
                $(this).html(`
                    <option value='${ $(this).select2('data')[0].id }'
                        data-name                     = '${$(this).select2('data')[0].name}'
                        data-mobile                   = '${$(this).select2('data')[0].mobile}'
                        data-email                    = '${$(this).select2('data')[0].email}'
                        data-address                  = '${$(this).select2('data')[0].address}'
                        data-gender                   = '${$(this).select2('data')[0].gender}'
                        data-user_id                  = '${$(this).select2('data')[0].user_id}'
                        selected
                    > ${ $(this).select2('data')[0].name + ' - ' + $(this).select2('data')[0].mobile }
                    </option>
                `);
            });
            function formatCustomer(customer) {
                if (customer.loading) {
                    return customer.text;
                }
                var $container = $(`
                    <div class='select2-result-customer clearfix'>
                        <div class='select2-result-customer__title'>
                            ${ customer.name + ' -> ' + customer.mobile }
                        </div>
                    </div>
                `);
                return $container;
            }
            function formatCustomerSelection(customer) {
                return customer.name;
            }
        });

      
</script>