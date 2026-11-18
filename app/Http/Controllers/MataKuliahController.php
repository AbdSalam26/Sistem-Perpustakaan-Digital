<?php

namespace App\Http\Controllers;

use App\Models\MataKuliah;
use Illuminate\Http\Request;

class MataKuliahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mataKuliah = MataKuliah::all();
        return response()->json($mataKuliah);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $mataKuliah = MataKuliah::create($request->all());
        return response()->json($mataKuliah, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(MataKuliah $mataKuliah)
    {
        return response()->json($mataKuliah);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MataKuliah $mataKuliah)
    {
        $mataKuliah->update($request->all());
        return response()->json($mataKuliah);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MataKuliah $mataKuliah)
    {
        $mataKuliah->delete();
        return response()->json(null, 204);
    }
}