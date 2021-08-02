<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\CommonFileResource;

class CustomerResource extends JsonResource
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
        if ($this->phone) $phone_code_and_phone = '+'.$this->phone_code->phonecode.$this->phone;
        else $phone_code_and_phone = null;
        
        return [
            'id'                      => $this->id,
            'name'                    => $this->name,
            'username'                => $this->username,
            'email'                   => $this->email,
            'country'                 => $this->country,
            'state'                   => $this->state,
            'phone_code'              => $this->phone_code,
            'country_id'              => $this->country_id,
            'state_id'                => $this->state_id,
            'phone_code_id'           => $this->phone_code_id,
            'phone'                   => $this->phone,
            'photo'                   => CommonFileResource::make($this->getFirstMedia('customer-photo')),
            'phone_code_and_phone'    => $phone_code_and_phone,
        ];
    }
}
