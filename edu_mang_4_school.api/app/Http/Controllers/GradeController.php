<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\grade;
use Laravel\Sanctum\HasApiTokens;

class GradeController extends Controller
{
    public function store(Request $request)
    {
        $grade = Grade::create($request->all());
        return response()->json($grade, 201);
    }

    public function index()
    {
        return Grade::all();
    }

    public function show($id)
    {
        return Grade::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $grade = Grade::findOrFail($id);
        $grade->update($request->all());
        return response()->json($grade, 200);
    }

    public function destroy($id)
    {
        Grade::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
