<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
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
            'id'             => $this->id,
            'created_at'      => $this->created_at,
            'rating'         => $this->rating,
            'customer'       => $this->customer,
            'admin'          => $this->admin,
            'review'         => $this->review,
            'reply'          => $this->reply,
        ];
    }
}
