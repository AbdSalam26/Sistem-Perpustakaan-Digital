<?php
namespace App\Http\Controllers;

use App\Models\Krs;
use Illuminate\Http\Request;

class KrsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $krs = Krs::all();
        return response()->json($krs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $krs = Krs::create($request->all());
        return response()->json($krs, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Krs $krs)
    {
        return response()->json($krs);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Krs $krs)
    {
        $krs->update($request->all());
        return response()->json($krs);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Krs $krs)
    {
        $krs->delete();
        return response()->json(null, 204);
    }
}