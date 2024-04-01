<?php

namespace App\Http\Controllers;

use App\Models\parent_Registr; // Import the Parent model
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;

class ParentRegistrController extends Controller
{
    // Create new parent
    public function store(Request $request)
    {
        $parent = parent_Registr::create($request->all());
        return response()->json($parent, 201);
    }

    // Get all parent_Registrs
    public function index()
    {
        return parent_Registr::all();
    }

    // Get a specific parent_Registr
    public function show($id)
    {
        return parent_Registr::findOrFail($id);
    }

    // Update a parent_Registr
    public function update(Request $request, $id)
    {
        $parent = parent_Registr::findOrFail($id);
        $parent->update($request->all());
        return response()->json($parent, 200);
    }

    // Delete a parent_Registr
    public function destroy($id)
    {
        parent_Registr::findOrFail($id)->delete();
        return response()->json(null, 204);
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

        $parent = $this->getUserByUsername($request->input('username'));

        if (!$parent || !Hash::check($request->input('password'), $parent->password)) {
            throw ValidationException::withMessages([
                'username' => self::LOGIN_FAILED
            ]);
        }

        return $this->wrapResponse(HttpResponse::HTTP_OK, self::LOGIN_SUCCESS);
    }

    public function register(Request $request): JsonResponse
    {
        $request->validate([
            "first_name" => "required|string|min:3|max:25",
            "last_name" => "required|string|min:3|max:25",
            "phone_number" => "required|numeric|unique:parent,phone_number",
            "email" => "required|string|email|unique:parent,email",
            "address" => "required|string|max:255",
            "jop" => "required|string|max:50",
            "password" => "required|string|min:8",
            "role_id" => "required|numeric",
        ]);

        $parent = parent_Registr::create([
            "first_name" => $request->input('first_name'),
            "last_name" => $request->input('last_name'),
            "phone_number" => $request->input('phone_number'),
            "email" => $request->input('email'),
            "address" => $request->input('address'),
            "jop" => $request->input('jop'),
            "password" => bcrypt($request->input('password')),
            "role_id" => $request->input('role_id'),
        ]);

        $token = $parent->createToken("parentToken")->plainTextToken;

        return response()->json([
            "parent" => $parent,
            "parent_token" => $token
        ], HttpResponse::HTTP_CREATED);
    }

    public function logout(Request $request): JsonResponse
    {
        if ($request->user()->tokens()->delete()) {
            return $this->wrapResponse(HttpResponse::HTTP_OK, self::LOGOUT_SUCCESS);
        }
    }

    private function getUserByUsername(string $username): ?parent_Registr
    {
        return parent_Registr::where('email', $username)->first();
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
}
