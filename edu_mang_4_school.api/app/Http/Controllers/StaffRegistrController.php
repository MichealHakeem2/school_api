<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\staff_Registr;
use Laravel\Sanctum\HasApiTokens;

class StaffRegistrController extends Controller
{
    // Create new staff
    public function store(Request $request)
    {
        $staff = staff_Registr::create($request->all());
        return response()->json($staff, 201);
    }

    // Get all staff_Registr
    public function index()
    {
        return staff_Registr::all();
    }

    // Get a specific staff_Registr
    public function show($id)
    {
        return staff_Registr::findOrFail($id);
    }

    // Update a staff_Registr
    public function update(Request $request, $id)
    {
        $staff = staff_Registr::findOrFail($id);
        $staff->update($request->all());
        return response()->json($staff, 200);
    }

    // Delete a staff_Registr
    public function destroy($id)
    {
        staff_Registr::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
