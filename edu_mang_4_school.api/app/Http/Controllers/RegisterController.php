<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required|string|min:3|max:255",
            "email" => "required|string|email|unique:admins,email",
            "password" => "required|string|min:8",
            "image" => "required|string|max:255",
            "role" => "required|numeric",
        ]);

        $admin = Admin::create([
            "name" => $request->input('name'),
            "email" => $request->input('email'),
            "password" => bcrypt($request->input('password')),
            "image" => $request->input('image'),
            "role" => $request->input('role'),
        ]);

        $token = $admin->createToken("adminToken")->plainTextToken;

        return response()->json([
            "admin" => $admin,
            "admin_token" => $token
        ], Response::HTTP_CREATED);
    }
        private const SUCCESS_MESSAGE = 'Account has been successfully registered, please check your email to verify your account.',
            FAILED_MESSAGE = 'Your account failed to register.';
        /**
         * Handle the user register.
         *
         * @param  \Illuminate\Http\Request  $request
         * @return \Illuminate\Http\JsonResponse
         */
        public function __invoke(AuthRequest $request): JsonResponse
        {
            if ($user = User::create($request->validatedData())) {
                event(new Registered($user));

                return response()->json(['code' => Response::HTTP_CREATED, 'message' => self::SUCCESS_MESSAGE,], Response::HTTP_CREATED);
            }

            return response()->json(['code' => 500, 'message' => self::FAILED_MESSAGE], 500);
        }

}
