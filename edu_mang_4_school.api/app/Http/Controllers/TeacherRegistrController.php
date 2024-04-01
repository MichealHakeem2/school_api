<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use App\Models\teacher_Registr;

class TeacherRegistrController extends Controller
{
    public function store(Request $request)
    {
        $teacher = teacher_Registr::create($request->all());
        return response()->json($teacher, 201);
    }

    public function index()
    {
        return teacher_Registr::all();
    }

    public function show($id)
    {
        return teacher_Registr::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $teacher = teacher_Registr::findOrFail($id);
        $teacher->update($request->all());
        return response()->json($teacher, 200);
    }

    public function destroy($id)
    {
        teacher_Registr::findOrFail($id)->delete();
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

        $teacher = $this->getUserByUsername($request->input('username'));

        if (!$teacher || !Hash::check($request->input('password'), $teacher->password)) {
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
            "email" => "required|string|email|unique:teacher,email",
            "phone_number" => "required|numeric|unique:teacher,phone_number",
            "subject_taught" => "required|string|max:50",
            "class_section_assigned" => "required|string|max:50",
            "password" => "required|string|min:8",
            "role_id" => "required|numeric",
        ]);

        $teacher = teacher_Registr::create([
            "first_name" => $request->input('first_name'),
            "last_name" => $request->input('last_name'),
            "email" => $request->input('email'),
            "phone_number" => $request->input('phone_number'),
            "subject_taught" => $request->input('subject_taught'),
            "class_section_assigned" => $request->input('class_section_assigned'),
            "password" => bcrypt($request->input('password')),
            "role_id" => $request->input('role_id'),
        ]);

        $token = $teacher->createToken("teacherToken")->plainTextToken;

        return response()->json([
        "teacher" => $teacher,
        "teacher_token" => $token
    ], Response::HTTP_CREATED);
}
public function logout(Request $request): JsonResponse
{
    if ($request->user()->tokens()->delete()) {
        return $this->wrapResponse(Response::HTTP_OK, self::LOGOUT_SUCCESS);
    }
}

private function getUserByUsername(string $username): ?teacher_Registr
{
    return teacher_Registr::where('email', $username)->first();
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
