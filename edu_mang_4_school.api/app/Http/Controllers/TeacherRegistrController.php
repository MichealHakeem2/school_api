<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
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
}
