<?php

namespace App\Http\Controllers;

use App\Models\ProgramStudi;
use Illuminate\Http\Request;

class ProgramStudiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programStudi = ProgramStudi::all();
        return response()->json($programStudi);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $programStudi = ProgramStudi::create($request->all());
        return response()->json($programStudi, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProgramStudi $programStudi)
    {
        return response()->json($programStudi);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProgramStudi $programStudi)
    {
        $programStudi->update($request->all());
        return response()->json($programStudi);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgramStudi $programStudi)
    {
        $programStudi->delete();
        return response()->json(null, 204);
    }
}