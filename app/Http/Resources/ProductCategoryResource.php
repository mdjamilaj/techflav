<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CommonFileResource;

class ProductCategoryResource extends JsonResource
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
            'id'                          => $this->id,
            'name'                        => $this->name,
            'details'                     => $this->details,
            'created_at'                  => $this->created_at,
            'updated_at'                  => $this->updated_at,
            'deleted_at'                  => $this->deleted_at,
            'photo'                       => CommonFileResource::make($this->getFirstMedia('productcateory-photo')),
        ];
    }
}
