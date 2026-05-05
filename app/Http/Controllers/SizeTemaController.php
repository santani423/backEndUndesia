<?php

namespace App\Http\Controllers;

use App\Models\SizeTema;
use Illuminate\Http\Request;

class SizeTemaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $validated = $request->validate([
            'type' => 'nullable|string|in:top,bottom,left,right',
            'no'   => 'nullable|integer|min:1',
        ]);

        $query = SizeTema::query();

        if (!empty($validated['type'])) {
            $query->where('type', $validated['type']);
        }

        if (!empty($validated['no'])) {
            $query->where('no', $validated['no']);
        }

        $data = $query->get();

        if ($data->isEmpty()) {
            return response()->json([
                'message' => 'Data tidak ditemukan',
                'data' => [],
            ], 404);
        }

        return response()->json([
            'message' => 'List of themes',
            'data' => $data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SizeTema $sizeTema)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SizeTema $sizeTema)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SizeTema $sizeTema)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SizeTema $sizeTema)
    {
        //
    }
}
