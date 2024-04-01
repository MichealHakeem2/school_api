<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\attendance;
use Laravel\Sanctum\HasApiTokens;

class AttendanceController extends Controller
{
    // Create new attendance record
    public function store(Request $request)
    {
        $attendance = Attendance::create($request->all());
        return response()->json($attendance, 201);
    }

    // Get all attendance records
    public function index()
    {
        return Attendance::all();
    }

    // Get a specific attendance record
    public function show($id)
    {
        return Attendance::findOrFail($id);
    }

    // Update an attendance record
    public function update(Request $request, $id)
    {
        $attendance = Attendance::findOrFail($id);
        $attendance->update($request->all());
        return response()->json($attendance, 200);
    }

    // Delete an attendance record
    public function destroy($id)
    {
        Attendance::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
