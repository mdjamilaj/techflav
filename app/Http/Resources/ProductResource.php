<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CommonFileResource;
use App\Http\Resources\ReviewResource;

class ProductResource extends JsonResource
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
            'id'                                  => $this->id,
            'name'                                => $this->name,
            'details'                             => $this->details,
            'product_price_type'                  => $this->product_price_type,
            'product_type'                        => $this->product_type,
            'licence_key'                         => $this->licence_key,
            'price'                               => $this->price,
            'discount_price'                      => $this->discount_price,
            'reviews'                             => ReviewResource::collection($this->reviews),
            'product_category'                    => $this->product_category,
            'product_platform'                    => $this->product_platform,
            'favourite'                           => $this->favourite,
            'product_and_documentation_download'  => CommonFileResource::make($this->getFirstMedia('product-and-documentation-download')),
            'product_download'                    => CommonFileResource::make($this->getFirstMedia('product-download')),
            'product_gallery'                     => CommonFileResource::collection($this->getMedia('product-gallery')),
        ];
    }
}
