<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\exam;
use Laravel\Sanctum\HasApiTokens;

class ExamController extends Controller
{
    public function store(Request $request)
    {
        $exam = Exam::create($request->all());
        return response()->json($exam, 201);
    }

    public function index()
    {
        return Exam::all();
    }

    public function show($id)
    {
        return Exam::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $exam = Exam::findOrFail($id);
        $exam->update($request->all());
        return response()->json($exam, 200);
    }

    public function destroy($id)
    {
        Exam::findOrFail($id)->delete();
        return response()->json(null, 204);
    }}
