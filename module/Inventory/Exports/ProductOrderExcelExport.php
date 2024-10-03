<?php

namespace Module\Inventory\Exports;

use Illuminate\Http\Request;
use App\Models\SystemSetting;
use Module\Product\Models\Product;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ProductOrderExcelExport implements FromCollection, WithHeadings, ShouldAutoSize
{

    protected $productId;
    protected $date;
    protected $deliveryDate;
    protected $userId;


    function __construct($productId, $date, $deliveryDate, $userId) {
        $this->productId    = $productId;
        $this->date         = $date;
        $this->deliveryDate = $deliveryDate;
        $this->userId       = $userId;
    }

    /*
     |--------------------------------------------------------------------------
     | COLLECTION METHOD
     |--------------------------------------------------------------------------
    */
    public function collection()
    {
        $productId      = $this->productId;
        $date           = $this->date;
        $deliveryDate   = $this->deliveryDate;
        $userId         = $this->userId;


        $productWiseUser         = SystemSetting::find(3);


            return $product = Product::query()
                            ->when($userId, function ($q) use ($userId) {
                                $q->whereHas('productUsers', function($q) use ($userId){
                                // $q->where('user_id', auth()->user()->id);

                                    $q->where('user_id', $userId);

                                });

                            })
                            ->whereHas('orderDetails', function($q) use ($date, $deliveryDate){
                                $q->whereHas('order', function($q) use ($date, $deliveryDate){
                                    $q->when($date, function ($q) use ($date) {
                                        $q->where('date', $date);
                                    })->when($deliveryDate, function ($q) use ($deliveryDate) {
                                        $q->where('delivery_date', $deliveryDate);
                                    });
                                });
                            })
                            // ->withSum('orderDetails','quantity')
                            ->with(
                                ['orderDetails' => function($q) use ($date, $deliveryDate) {
                                    $q->whereHas('order', function($q) use ($date, $deliveryDate){

                                        $q->when($date, function ($q) use ($date) {

                                            $q->where('date', $date);

                                        })->when($deliveryDate, function ($q) use ($deliveryDate) {

                                            $q->where('delivery_date', $deliveryDate);

                                        });

                                    });
                                }],
                                
                            )
                            ->withSum('stockSummaries', 'balance_qty')
                            ->when($productId, function($q) use($productId){
                                $q->where('id', $productId);
                            })->get()
                            ->map(function($item){
                                return [
                                    'name'            => $item->name,
                                    // 'order_quantity'  => $item->order_details_sum_quantity,
                                    'order_quantity'  => $this->orderQuantity($item->orderDetails),
                                    'stock'           => $item->stock_summaries_sum_balance_qty,
                                ];
                            });

            

                    
    }


   function orderQuantity($orderDetails){

        $totalQuantity = 0;

        foreach($orderDetails as $orderDetail){
            $measurement_value = $orderDetail->measurement_value != 0 ? $orderDetail->measurement_value : 1;
            $totalQuantity += $measurement_value * $orderDetail->quantity;
        }

        return $totalQuantity;
   }

    /*
     |--------------------------------------------------------------------------
     | HEADINGS METHOD
     |--------------------------------------------------------------------------
    */
    public function headings(): array
    {
        return [
            [
              'Product List'
            ],
            [
                'Product Name',
                'Order Quantity',
                'Stock Quantity',
            ]
        ];
    }
}
