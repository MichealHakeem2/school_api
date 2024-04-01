<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
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
}
