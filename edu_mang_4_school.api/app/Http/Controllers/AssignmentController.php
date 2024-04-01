<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\assignment;
use Laravel\Sanctum\HasApiTokens;

class AssignmentController extends Controller
{
        // Create new assignment
        public function store(Request $request)
        {
            $assignment = Assignment::create($request->all());
            return response()->json($assignment, 201);
        }

        // Get all assignments
        public function index()
        {
            return Assignment::all();
        }

        // Get a specific assignment
        public function show($id)
        {
            return Assignment::findOrFail($id);
        }

        // Update an assignment
        public function update(Request $request, $id)
        {
            $assignment = Assignment::findOrFail($id);
            $assignment->update($request->all());
            return response()->json($assignment, 200);
        }

        // Delete an assignment
        public function destroy($id)
        {
            Assignment::findOrFail($id)->delete();
            return response()->json(null, 204);
        }
}
