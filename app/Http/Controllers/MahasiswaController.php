<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswa = Mahasiswa::all();
        return response()->json($mahasiswa);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $mahasiswa = Mahasiswa::create($request->all());
        return response()->json($mahasiswa, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Mahasiswa $mahasiswa)
    {
        return response()->json($mahasiswa);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $mahasiswa->update($request->all());
        return response()->json($mahasiswa);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();
        return response()->json(null, 204);
    }
}