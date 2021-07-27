<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;
use Validator;

class AuthController extends Controller
{
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
                throw ValidationException::withMessages([
                    'message' => 'The provided credentials are incorrect.',
                ]);
            }
            $token = $customer->createToken($request->device)->plainTextToken;
            $data = [
                'user' => $customer,
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
        $validatedData = $request->validate([
            'name' => 'required|min:3|string|max:255',
            'username' => 'required|min:6|without_spaces|string|max:255|unique:customers|regex:/(^([a-zA-Z]+)(\d+)?$)/u',
            'email' => 'required|string|email|max:255|unique:customers',
            'password' => 'required|string|min:8|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:8',
            'device' => 'device',
        ]);
        try {
            $input = $request->all();
            unset($input['password']);
            $input['product'] = Hash::make($validatedData['password']);
            $customer = Customer::create($input);

            $token = $customer->createToken($request->device)->plainTextToken;
            $data = [
                'access_token' => $token,
                'token_type' => 'Bearer',
            ];
            return $this->sendResponse($data, "Register successful", 200);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], 500);
        }
    }

    public function logout(Request $request)
    {
        try {
            $request->user()->tokens()->delete();
            return $this->sendResponse([], "logout successful", 200);
        } catch (\Throwable $th) {
            return $this->sendError($th->getMessage(), [], 500);
        }
    }
}
