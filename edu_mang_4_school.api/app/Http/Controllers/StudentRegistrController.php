<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use App\Models\student_Registr;
use Laravel\Sanctum\HasApiTokens;

class StudentRegistrController extends Controller
{
    public function store(Request $request)
    {
        $student = student_Registr::create($request->all());
        return response()->json($student, 201);
    }

    public function index()
    {
        return student_Registr::all();
    }

    public function show($id)
    {
        return student_Registr::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $student = student_Registr::findOrFail($id);
        $student->update($request->all());
        return response()->json($student, 200);
    }

    public function destroy($id)
    {
        student_Registr::findOrFail($id)->delete();
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
            "first_name" => "required|string|min:3|max:25",
            "last_name" => "required|string|min:3|max:25",
            "bith_date" => "required|date",
            "address" => "required|string|max:255",
            "phone_number" => "required|numeric|unique:student,phone_number",
            "email" => "required|string|email|unique:student,email",
            "gender" => "required|in:male,female",
            "class" => "required|string|max:25",
            "parent_name" => "required|string|max:50",
            "password" => "required|string|min:8",
            "role_id" => "required|numeric",
        ]);

        $student = student_Registr::create([
            "first_name" => $request->input('first_name'),
            "last_name" => $request->input('last_name'),
            "bith_date" => $request->input('bith_date'),
            "address" => $request->input('address'),
            "phone_number" => $request->input('phone_number'),
            "email" => $request->input('email'),
            "gender" => $request->input('gender'),
            "class" => $request->input('class'),
            "parent_name" => $request->input('parent_name'),
            "password" => bcrypt($request->input('password')),
            "role_id" => $request->input('role_id'),
        ]);

        $token = $student->createToken("studentToken")->plainTextToken;

        return response()->json([
            "student" => $student,
            "student_token" => $token
        ], Response::HTTP_CREATED);
    }
    public function logout(Request $request): JsonResponse
    {
        if ($request->user()->tokens()->delete()) {
            return $this->wrapResponse(Response::HTTP_OK, self::LOGOUT_SUCCESS);
        }
    }

    private function getUserByUsername(string $username): ?student_Registr
    {
        return student_Registr::where('email', $username)->first();
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
