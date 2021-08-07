<?php

// namespace App\Http\Resources;

// use Illuminate\Http\Resources\Json\JsonResource;
// use App\Http\Resources\CommonFileResource;

// class CustomerResource extends JsonResource
// {
//     public function toArray($request)
//     {
//         return [
//             'id'                      => $this->id,
//             'name'                    => $this->name,
//             'username'                => $this->username,
//             'email'                   => $this->email,
//             'country'                 => $this->country,
//             'state'                   => $this->state,
//             'phone_code'              => $this->phone_code,
//             'country_id'              => $this->country_id,
//             'state_id'                => $this->state_id,
//             'phone_code_id'           => $this->phone_code_id,
//             'phone'                   => $this->phone,
//             'photo'                   => CommonFileResource::make($this->getFirstMedia('user-profile')),
//             'password_change_at'      => $this->password_change_at,
//         ];
//     }
// }
