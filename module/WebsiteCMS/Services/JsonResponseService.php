<?php

namespace Module\WebsiteCMS\Services;



class JsonResponseService
{

    private $data       = [];
    private $status     = 1;
    private $message    = "Success";


    public function find($query, $responseField)
    {
        try {

            $this->data[$responseField] = $query->first();

        } catch (\Throwable $th) {

            $this->status   = 0;
            $this->message  = $th->getMessage();
        }

        return response()->json($this->getResponse());
    }


    public function get($query, $responseField)
    {
        try {

            $this->data[$responseField] = $query->apiQuery()->get();

        } catch (\Throwable $th) {

            $this->status   = 0;
            $this->message  = $th->getMessage();
        }

        return response()->json($this->getResponse());
    }




    public function paginate($query, $responseField, $item_per_page = 10)
    {
        try {

            $this->data[$responseField] = $query->apiQuery()->paginate($item_per_page);

        } catch (\Throwable $th) {

            $this->status   = 0;
            $this->message  = $th->getMessage();
        }

        return response()->json($this->getResponse());
    }









    private function getResponse()
    {
        return [

            'data'      => $this->data,
            'message'   => $this->message,
            'status'    => $this->status,
        ];
    }
}
