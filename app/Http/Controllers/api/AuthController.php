<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\Http\Services\CommonService;
use Illuminate\Support\Facades\Cache;
use App\Http\Resources\CustomerResource;

class AuthController extends Controller
{
    public function __construct(
        CommonService $commonService
    ) {
        $this->commonService = $commonService;
    }

    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|string|email',
    //         'password' => 'required|string',
    //     ]);

    //     // $customer = Customer::where('email', $request->email)->first();

    //     // if (! $customer || ! Hash::check($request->password, $customer->password)) {
    //     //     return response()->json([
    //     //         'email' => ['The provided credentials are incorrect.']
    //     //     ], 401);
    //     // }

    //     // $customer->createToken('Personal Access Token')->plainTextToken;


    //     // $request->validate([
    //     //     'email' => 'required|string|email',
    //     //     'password' => 'required|string',
    //     // ]);

    //     if (!Auth::attempt($request->only('email', 'password'))) {
    //         return response()->json([
    //             'message' => 'Unauthorized'
    //         ], 401);
    //     }

    //     $user = $request->user();
    //     $tokenResult = $user->createToken('Personal Access Token');
    //     $token = $tokenResult->plainTextToken;

    //     return response()->json([
    //         'accessToken' => $token,
    //         'token_type' => 'Bearer',
    //     ]);
    // }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'device' => 'required',
        ]);

        try {
            $customer = Customer::where('email', $request->email)->first();

            if (!$customer || !Hash::check($request->password, $customer->password)) {
                return $this->sendError('The given data was invalid.', [
                    'message' => 'The provided credentials are incorrect.',
                ], 500);
            }
            $token = $customer->createToken($request->device . $customer->id)->plainTextToken;
            $data = [
                'user' => CustomerResource::make($customer->load(['state', 'country', 'phone_code'])),
                'access_token' => $token,
                'token_type' => 'Bearer',
            ];
            return $this->sendResponse($data, "Login successful", 200);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], 500);
        }
    }


    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|string|max:255',
            'username' => 'required|min:6|string|max:255|regex:/(^([a-zA-Z]+)(\d+)?$)/u|unique:customers,username,id',
            'email' => 'required|string|email|max:255|unique:customers,email,id',
            'password' => 'required|string|min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:8',
            'device' => 'required',
            'agree' => 'required|in:1',
        ]);
        try {
            $input = $request->all();
            unset($input['password']);
            unset($input['password_confirmation']);
            unset($input['device']);
            unset($input['agree']);
            $input['password'] = Hash::make($request->password);
            $customer = Customer::create($input);

            $token = $customer->createToken($request->device . $customer->id)->plainTextToken;
            $data = [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => CustomerResource::make($customer->load(['state', 'country', 'phone_code'])),
            ];
            return $this->sendResponse($data, "Register successful", 200);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], 500);
        }
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3|string|max:255',
            'email' => 'required|string|email|max:255|unique:customers,email,' . $request->user()->id,
        ]);

        try {
            $input = $request->all();
            unset($input['username']);
            unset($input['phone_code']);
            unset($input['state']);
            unset($input['country']);
            unset($input['phone_code_and_phone']);
            unset($input['photo']);
            $customer = Customer::findOrFail($request->user()->id);
            $customer->update($input);

            if ($request->hasFile('photo')) {
                $request->validate([
                    'photo' => 'required|mimes:jpeg,jpg,png,webp',
                ]);
                $customer->addMedia($request->file('photo'))->toMediaCollection("customer-photo");
            }

            return CustomerResource::make($customer->load(['state', 'country', 'phone_code']))->success(true)->message("Profile update successfully");
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->where('id', $request->device . $request->user()->id)->delete();
            return $this->sendResponse([], "logout successful", 200);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], 500);
        }
    }

    public function forgetMailSend(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|exists:customers,email',
            'question' => 'required',
            'answer' => 'required',
            'keep_me' => 'required|in:1',
            'i_understand' => 'required|in:1',
        ]);
        $customer = Customer::where('email', '=', $request->email)->firstOrFail();
        $code = $this->commonService->generateOtpCode($customer, 1440, 'froget_password_otp_'); //1 day validity
        $data = [
            'customer' => $customer,
            'code' => $code,
        ];
        Mail::to($request->email)->send(new \App\Mail\ForgetOtpEmail($data));
        return $this->sendResponse([], "Password reset mail send successful", 200);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:255|exists:customers,email',
            'password' => 'required|string|min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:8',
            'code' => 'required|min:6',
        ]);
        $customer = Customer::where('email', '=', $request->email)->firstOrFail();

        $code = Cache::get('froget_password_otp_' . $customer->id);

        if (!$code) {
            return $this->sendError("OTP code invalid or expired", [], 422);
        }
        if (intval($request->code) != $code) {
            return $this->sendError("The OTP doesn't match our records.", [], 422);
        }

        try {
            $customer->password = Hash::make($request->password);
            $customer->password_change_at = date('Y-m-d H:i:s');
            $customer->save();
            return $this->sendResponse($customer, "Password reset successfully", 200);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], 500);
        }
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:8',
            'old_password' => 'required|string|min:8',
        ]);
        $customer = $request->user();
        if (!Hash::check($request->old_password, $customer->password)) {
            return $this->sendError('The given data was invalid.', [
                'message' => 'The provided credentials are incorrect.',
            ], 422);
        }
        try {
            $customer->password = Hash::make($request->password);
            $customer->password_change_at = date('Y-m-d H:i:s');
            $customer->save();
            return CustomerResource::make($customer->load(['state', 'country', 'phone_code']))->success(true)->message("Password change successfully");
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], 500);
        }
    }
}
