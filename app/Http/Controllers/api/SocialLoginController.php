<?php

namespace App\Http\Controllers\api;

use App\Models\Customer;
use App\Models\UserSocial;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Two\InvalidStateException;

class SocialLoginController extends Controller
{
    protected $auth;

    public function __construct()
    {
        $this->middleware(['social', 'web']);
    }

    public function redirect($service)
    {
        return Socialite::driver($service)->redirect();
    }

    public function callback($service)
    {
        try {
            $serviceUser = Socialite::driver($service)->user();
        } catch (\Exception $e) {
            return redirect(env('CLIENT_BASE_URL') . '/auth/social-callback?error=Unable to login using ' . $service . '. Please try again' . '&origin=login');
        }

        // if ((env('RETRIEVE_UNVERIFIED_SOCIAL_EMAIL') == 0) && ($service != 'google')) {
        //     $email = $serviceUser->getId() . '@' . $service . '.local';
        // } elseif ($service == 'github') {
        //     $email = $serviceUser->email;
        // } else {
            $email = $serviceUser->getEmail();
        // }

        $customer = $this->getExistingUser($serviceUser, $email, $service);
        $newUser = false;
        if (!$customer) {
            $newUser = true;
            $customer = Customer::create([
                'name' => $serviceUser->getName(),
                'username' => $this->random_username($serviceUser->getName()),
                'email' => $email,
                'password' => ''
            ]);
        }

        if ($this->needsToCreateSocial($customer, $service)) {
            UserSocial::create([
                'customer_id' => $customer->id,
                'social_id' => $serviceUser->getId(),
                'service' => $service
            ]);
        }

        $token = $customer->createToken('social' . $customer->id)->plainTextToken;
        return redirect(env('CLIENT_BASE_URL') . '/auth/social-callback?token=' . $token . '&id=' . $customer->id . '&email=' . $customer->email . '&username=' . $customer->username . '&name=' . $customer->name . '&origin=' . ($newUser ? 'register' : 'login'));
    }

    public function random_username($string)
    {
        $pattern = " ";
        $firstPart = strstr(strtolower($string), $pattern, true);
        $secondPart = substr(strstr(strtolower($string), $pattern, false), 0, 3);
        $nrRand = rand(0, 100);

        $username = trim($firstPart) . trim($secondPart) . trim($nrRand);
        return $username;
    }

    public function needsToCreateSocial(Customer $customer, $service)
    {
        return !$customer->hasSocialLinked($service);
    }

    public function getExistingUser($serviceUser, $email, $service)
    {
        // if ((env('RETRIEVE_UNVERIFIED_SOCIAL_EMAIL') == 0) && ($service != 'google')) {
        //     $userSocial = UserSocial::where('social_id', $serviceUser->getId())->first();
        //     return $userSocial ? $userSocial->user : null;
        // }
        return Customer::where('email', $email)->orWhereHas('social', function ($q) use ($serviceUser, $service) {
            $q->where('social_id', $serviceUser->getId())->where('service', $service);
        })->first();
    }
}
