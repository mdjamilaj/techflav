<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ProductResource;

class ProductFavouriteResource extends JsonResource
{

    protected $success;
    protected $message;

    public function success($value)
    {
        $this->success = $value;
        return $this;
    }

    public function message($value)
    {
        $this->message = $value;
        return $this;
    }


    public function toArray($request)
    {
        return [
            'id'                  => $this->id,
            'customer_id'         => $this->customer_id,
            'product_id'          => $this->product_id,
            'product'             => ProductResource::make($this->product),
        ];
    }
}
