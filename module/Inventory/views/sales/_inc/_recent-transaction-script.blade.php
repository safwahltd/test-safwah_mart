
<script>

    function recentTransaction(object){

        let transactionRow  = '';

        let date = $(object).val();

        $('#recent_transaction').empty('');

        const route = `{{ route('inv.sales.axios.recent-transaction') }}`;

        axios.get(route, {
            params: {
                date: date
            }
        })

        .then(function (response) {

            let total_transaction = Object.keys(response.data).length;

            if(total_transaction != 0){
                $.each(response.data, function(key, transaction) {

                    transactionRow += `

                        <tr class="content-body">
                            <td class="serial">${key+1}</td>
                            <td class="title">
                                <a href="javascript:void(0)">${transaction.invoice_no} ( ${transaction.customer.name} )</a>
                            </td>
                            <td class="amount">${transaction.payable_amount}</td>
                            <td class="action">
                                <a href="#">
                                    <i class="fas fa-edit edit-icon"></i>
                                </a>
                                <a href="javascript:void(0)" onclick="">
                                    <i class="fas fa-trash trash-icon"></i>
                                </a>
                                <a href="#">
                                    <i class="fas fa-print print-icon"></i>
                                </a>
                                <a href="#">
                                    <i class="fas fa-eye eye-icon"></i>
                                </a>
                            </td>
                        </tr>

                    `;

                });
            }
            else{
                transactionRow += `

                    <tr class="content-body text-center text-danger justify-content-center">
                        <td><b>No Data Found</b></td>
                    </tr>

                `;
            }


            $('#recent_transaction').append(transactionRow);

        })
        .catch(function (error) {
            warning('Something wrong!!!');
        });



    }


</script>
