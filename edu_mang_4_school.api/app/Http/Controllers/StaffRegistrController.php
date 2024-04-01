<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use App\Models\staff_Registr;
use Laravel\Sanctum\HasApiTokens;

class StaffRegistrController extends Controller
{
    // Create new staff
    public function store(Request $request)
    {
        $staff = staff_Registr::create($request->all());
        return response()->json($staff, 201);
    }

    // Get all staff_Registr
    public function index()
    {
        return staff_Registr::all();
    }

    // Get a specific staff_Registr
    public function show($id)
    {
        return staff_Registr::findOrFail($id);
    }

    // Update a staff_Registr
    public function update(Request $request, $id)
    {
        $staff = staff_Registr::findOrFail($id);
        $staff->update($request->all());
        return response()->json($staff, 200);
    }

    // Delete a staff_Registr
    public function destroy($id)
    {
        staff_Registr::findOrFail($id)->delete();
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

        $student = $this->getUserByUsername($request->input('username'));

        if (!$student || !Hash::check($request->input('password'), $student->password)) {
            throw ValidationException::withMessages([
                'username' => self::LOGIN_FAILED
            ]);
        }
        return $this->wrapResponse(Response::HTTP_OK, self::LOGIN_SUCCESS);
    }


    public function register(Request $request)
    {
        $request->validate([
            "name" => "required|string|max:255",
            "role_position" => "required|string|max:100",
            "department" => "required|string|max:100",
            "phone_number" => "required|numeric",
            "email" => "required|string|email|unique:staff,email",
            "password" => "required|string|min:8",
            "role_id" => "required|numeric",
        ]);

        $staff = staff_Registr::create([
            "name" => $request->input('name'),
            "role_position" => $request->input('role_position'),
            "department" => $request->input('department'),
            "phone_number" => $request->input('phone_number'),
            "email" => $request->input('email'),
            "password" => bcrypt($request->input('password')),
            "role_id" => $request->input('role_id'),
        ]);

        $token = $staff->createToken("staffToken")->plainTextToken;

        return response()->json([
            "staff" => $staff,
            "staff_token" => $token
        ], Response::HTTP_CREATED);
    }

    public function logout(Request $request): JsonResponse
    {
        if ($request->user()->tokens()->delete()) {
            return $this->wrapResponse(Response::HTTP_OK, self::LOGOUT_SUCCESS);
        }
    }

    private function getUserByUsername(string $username): ?staff_Registr
    {
        return staff_Registr::where('email', $username)->first();
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
