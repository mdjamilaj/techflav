<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Cache;

class CommonService
{

    public function generateOtpCode($data, $time, $prefix)
    {
        //forget existing otp from cache
        Cache::forget($prefix . $data->id);
        //generate code
        $code =  mt_rand(100000, 999999);
        //put them in cache
        Cache::put($prefix . $data->id, $code, now()->addMinutes($time));
        //return generated code
        return $code;
    }
}