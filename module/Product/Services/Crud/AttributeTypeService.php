<?php

namespace Module\Product\Services\Crud;
use Module\Product\Models\AttributeType;

class AttributeTypeService
{
    // public $duePayment;
    // public $invoiceNumberService;
    // public $transactionService;




    /*
     |--------------------------------------------------------------------------
     | CONSTRUCTOR
     |--------------------------------------------------------------------------
    */
    public function __construct()
    {
        // $this->invoiceNumberService = new InvoiceNumberService();

    }








    /*
     |--------------------------------------------------------------------------
     | INDEX NECK
     |--------------------------------------------------------------------------
    */

    public function attributeTypeIndex(){

        $data['attributeTypes']        = AttributeType::query()
                                        ->likeSearch('name')
                                        ->latest()
                                        ->paginate(50);

        $data['table']                 = AttributeType::getTableName();

        return $data;

    }






     
    /*
     |--------------------------------------------------------------------------
     | STORE NECK
     |--------------------------------------------------------------------------
    */

    public function attributeTypeStore($request){
      
        $attributeType = AttributeType::create([
            'name'          => $request->name,
            'description'   => $request->description,
            'status'        => !empty($request->status) ? 1 : 0,
        ]);

    }








    /*
     |--------------------------------------------------------------------------
     | DELETE NECK
     |--------------------------------------------------------------------------
    */

    public function attributeTypeDelete($id){

        $attributeType = AttributeType::find($id);
        $attributeType->delete();
        
    }







    /*
     |--------------------------------------------------------------------------
     | DELETE SIZE
     |--------------------------------------------------------------------------
    */

    public function attributeTypeEdit($id){

        $data['attributeType']  = AttributeType::find($id);
        return $data;
        
    }





        /*
     |--------------------------------------------------------------------------
     | DELETE SIZE
     |--------------------------------------------------------------------------
    */

    public function attributeTypeUpdate($request,$id){

        $neck  = AttributeType::find($id);

        $neck->update([
            'name'          => $request->name,
            'description'   => $request->description,
            'status'        => !empty($request->status) ? 1 : 0,
        ]);

    }



}
