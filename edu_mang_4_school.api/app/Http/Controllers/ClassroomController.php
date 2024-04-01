<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\classroom;
use Laravel\Sanctum\HasApiTokens;

class ClassroomController extends Controller
{
    // Create new classroom
    public function store(Request $request)
    {
        $classroom = Classroom::create($request->all());
        return response()->json($classroom, 201);
    }

    // Get all classrooms
    public function index()
    {
        return Classroom::all();
    }

    // Get a specific classroom
    public function show($id)
    {
        return Classroom::findOrFail($id);
    }

    // Update a classroom
    public function update(Request $request, $id)
    {
        $classroom = Classroom::findOrFail($id);
        $classroom->update($request->all());
        return response()->json($classroom, 200);
    }

    // Delete a classroom
    public function destroy($id)
    {
        Classroom::findOrFail($id)->delete();
        return response()->json(null, 204);
    }}
