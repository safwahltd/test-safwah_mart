<?php

namespace Module\Product\Services\Crud;
use Module\Product\Models\Attribute;
use Module\Product\Models\AttributeType;

class AttributeService
{





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

    public function attributeIndex(){

        
        $data['attributeTypes']     = AttributeType::pluck('name','id');

        $data['attributes']         = Attribute::query()
                                    ->likeSearch('name')
                                    ->searchByField('attribute_type_id')
                                    ->latest()
                                    ->paginate(50);

        $data['table']              = Attribute::getTableName();
                                    
        return $data;

    }







     
    /*
     |--------------------------------------------------------------------------
     | STORE ATTRIBUTE
     |--------------------------------------------------------------------------
    */

    public function attributeCreate(){
      
      return $data['attributeTypes'] = AttributeType::pluck('name','id');
    }







     
    /*
     |--------------------------------------------------------------------------
     | STORE NECK
     |--------------------------------------------------------------------------
    */

    public function attributeStore($request){
      
        $attribute = Attribute::create([
            'attribute_type_id'         => $request->attribute_type_id,
            'name'                      => $request->name,
            'description'               => $request->description,
            'color_code'                => $request->color_code,
            'status'                    => !empty($request->status) ? 1 : 0,
        ]);

    }








    /*
     |--------------------------------------------------------------------------
     | DELETE NECK
     |--------------------------------------------------------------------------
    */

    public function attributeDelete($id){

        $attribute = Attribute::find($id);
        $attribute->delete();
        
    }







    /*
     |--------------------------------------------------------------------------
     | DELETE SIZE
     |--------------------------------------------------------------------------
    */

    public function attributeEdit($id){

        $data['attribute']      = Attribute::find($id);
        $data['attributeTypes'] = AttributeType::pluck('name','id');

        return $data;
        
    }





        /*
     |--------------------------------------------------------------------------
     | DELETE SIZE
     |--------------------------------------------------------------------------
    */

    public function attributeUpdate($request,$id){

        $neck  = Attribute::find($id);

        $neck->update([
            'attribute_type_id'             => $request->attribute_type_id,
            'name'                          => $request->name,
            'description'                   => $request->description,
            'color_code'                    => $request->color_code,
            'status'                        => !empty($request->status) ? 1 : 0,
        ]);

    }



}
