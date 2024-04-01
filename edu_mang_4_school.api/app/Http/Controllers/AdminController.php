<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\API\AuthRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

use App\Models\Admin;

class AdminController extends Controller
{
    use \Laravel\Sanctum\HasApiTokens;

    public function index()
    {
        $admin = Admin::all();
        return $admin;
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|string|min:3|max:255",
            "email" => "required|string|email|unique:admin,email",
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

    public function show($id)
    {
        $admin = Admin::find($id);
        return $admin ? $admin : response()->json(["message" => "Admin not found"], Response::HTTP_NOT_FOUND);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required|string|min:3|max:255",
            "email" => "required|string|email|unique:admin,email," . $id,
            "password" => "required|string|min:8",
            "image" => "required|string|max:255",
            "role" => "required|numeric",
        ]);

        $admin = Admin::find($id);
        if ($admin) {
            $admin->update($request->all());
            return $admin;
        } else {
            return response()->json(["message" => "Admin not found"], Response::HTTP_NOT_FOUND);
        }
    }

    public function destroy($id)
    {
        $admin = Admin::find($id);
        if ($admin) {
            $admin->delete();
            return response()->json(["message" => "Admin deleted successfully"], Response::HTTP_OK);
        } else {
            return response()->json(["message" => "Admin not found"], Response::HTTP_NOT_FOUND);
        }
    }

    private const LOGIN_SUCCESS = 'Logged in succesfully.';
    private const LOGIN_FAILED = 'The credentials does not match.';
    private const LOGOUT_SUCCESS = 'Logged out succesfully.';

    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        $admin = $this->getUserByUsername($request->input('username'));

        if (!$admin || !Hash::check($request->input('password'), $admin->password)) {
            throw ValidationException::withMessages([
                'username' => self::LOGIN_FAILED
            ]);
        }
        return $this->wrapResponse(Response::HTTP_OK, self::LOGIN_SUCCESS);
    }
    public function logout(Request $request): JsonResponse
    {
        if ($request->user()->tokens()->delete()) {
            return $this->wrapResponse(Response::HTTP_OK, self::LOGOUT_SUCCESS);
        }
    }

    private function getUserByUsername(string $username): ?admin
    {
        return admin::where('email', $username)->first();
    }

    private function wrapResponse(int $code, string $message, ?array $resource = []): JsonResponse
    {
        $result = [
            'code' => $code,
            'message' => $message
        ];

        if (count($resource)) {
            $result = array_merge(
                $result,
                [
                    'data' => $resource['data'],
                    'token' => $resource['token']
                ]
            );
        }

        return response()->json($result);
    }
    public function register(Request $request)
    {
        $request->validate([
            "name" => "required|string|min:3|max:255",
            "email" => "required|string|email|unique:admin,email",
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
            if ($user = Admin::create($request->validatedData())) {
                event(new Registered($user));

                return response()->json(['code' => Response::HTTP_CREATED, 'message' => self::SUCCESS_MESSAGE,], Response::HTTP_CREATED);
            }

            return response()->json(['code' => 500, 'message' => self::FAILED_MESSAGE], 500);
        }

}
