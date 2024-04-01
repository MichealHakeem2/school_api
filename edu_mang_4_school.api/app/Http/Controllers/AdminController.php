<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;

class AdminController extends Controller
{
    use \Laravel\Sanctum\HasApiTokens;

    public function index()
    {
        $admins = Admin::all();
        return $admins;
    }

    public function store(Request $request)
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

    public function show($id)
    {
        $admin = Admin::find($id);
        return $admin ? $admin : response()->json(["message" => "Admin not found"], Response::HTTP_NOT_FOUND);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            "name" => "required|string|min:3|max:255",
            "email" => "required|string|email|unique:admins,email," . $id,
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

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|string|email",
            "password" => "required|string|min:8",
        ]);

        $admin = Admin::where("email", $request->input('email'))->first();
        if (!$admin || !Hash::check($request->input('password'), $admin->password)) {
            return response()->json(["message" => "Incorrect email or password"], Response::HTTP_UNAUTHORIZED);
        }

        $token = $admin->createToken("adminToken")->plainTextToken;

        return response()->json([
            "admin" => $admin,
            "admin_token" => $token
        ], Response::HTTP_OK);
    }
}
