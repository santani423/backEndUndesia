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

        if (isset($validated['type'])) {
            $query->where('type', $validated['type']);
        }

        if (isset($validated['no'])) {
            $query->where('no', $validated['no']);
        }

        $data = $query->get();

        $isEmpty = $data->isEmpty();

        return response()->json([
            'status'  => !$isEmpty,
            'message' => $isEmpty ? 'Data tidak ditemukan' : 'List of themes',
            'data'    => $data,
        ], $isEmpty ? 404 : 200);
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
