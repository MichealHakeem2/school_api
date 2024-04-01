<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\parent_Registr;
use Laravel\Sanctum\HasApiTokens;

class ParentRegistrController extends Controller
{
    // Create new parent
    public function store(Request $request)
    {
        $parent = parent_Registr::create($request->all());
        return response()->json($parent, 201);
    }

    // Get all parent_Registrs
    public function index()
    {
        return parent_Registr::all();
    }

    // Get a specific parent_Registr
    public function show($id)
    {
        return parent_Registr::findOrFail($id);
    }

    // Update a parent_Registr
    public function update(Request $request, $id)
    {
        $parent = parent_Registr::findOrFail($id);
        $parent->update($request->all());
        return response()->json($parent, 200);
    }

    // Delete a parent_Registr
    public function destroy($id)
    {
        parent_Registr::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
