<!DOCTYPE html>
<html>

<head>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 2px;
            font-size: 11px;
            text-align: center;
        }

        table {
            width: 100%;
        }

        h2,
        h3,
        p {
            margin: 1px;
        }

    </style>
</head>

<body>
    <div style="text-align: center">
        <h2>{{ $company->name }}</h2>
        <p>{{ $company->phone }}</p>
        <p>{{ $company->address }}</p>
        <p class="">Date:{{date('d-m-Y')}}</h3>
    </div>
    <h4 style="text-align: center">Productwise Order Report</h4>

    <table style="width:100%">
        <tr>
            <th>Product Name</th>
            <th>Order Quantity</th>
            <th>Stock Quantity</th>
        </tr>

        <tbody>
            @php
                $total_order_quantity = 0;
                $total_stock_quantity = 0;
            @endphp
            @if (request()->has('product_id'))
                @forelse ($product_orders as $item)
                    @php
                        $totalQuantity = 0;

                        foreach($item->orderDetails as $orderDetail){
                            $measurement_value = $orderDetail->measurement_value != 0 ? $orderDetail->measurement_value : 1;
                            $totalQuantity += $measurement_value * $orderDetail->quantity;
                        }

                        $total_order_quantity += $totalQuantity;
                        $total_stock_quantity += $item->stock_summaries_sum_balance_qty;
                    @endphp
                    <tr>
                        <td>{{ $item->name }} </td>
                        <td>{{ number_format($totalQuantity, 2) }}</td>
                        {{-- <td>{{ number_format($item->order_details_sum_quantity, 2) }}</td> --}}
                        <td>{{ number_format($item->stock_summaries_sum_balance_qty, 2) }}</td>
                    </tr>
                @empty
                    <tr colspan="50">
                        <td></td>
                        <td style="color: red; text-align:center">No Data to Show!</td>
                        <td></td>
                    </tr>
                @endforelse
            @else
                <tr colspan="50">
                    <td></td>
                    <td style="color: red; text-align:center">No Data to Show!</td>
                    <td></td>
                </tr>
            @endif

        </tbody>
        <tfoot>
            <tr style="background: #ddd !important; color:black !important">
                <th colspan="1">Total</th>
                <th>{{ number_format($total_order_quantity, 2) }}</th>
                <th>{{ number_format($total_stock_quantity, 2) }}</th>
            </tr>
        </tfoot>
      
    </table>

</body>

</html>
