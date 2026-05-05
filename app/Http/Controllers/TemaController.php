<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetSize;
use App\Models\BreackPoin;
use App\Models\SizeTema;
use App\Models\Tema;
use Illuminate\Http\Request;

class TemaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $validated = $request->validate([
        //     'code' => 'nullable|string|in:top,bottom,left,right',
        // ]);

        $query = Tema::with([
            'assets.assetSizes.breakpoint',
            'assets.assetSizes.sizeTema'
        ])->where('code', 'TEMA1')->get();

        return response()->json([
            'message' => 'List of themes',
            'data' => $query,
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
    public function show(Tema $tema)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {   $breakpoint = BreackPoin::where('code',$request->breakpoint)->first();
        $assetSize = AssetSize::where('asset_id',$request->asset_id) 
        ->where('breack_poin_id',$breakpoint->id)
        ->first();
        $size = SizeTema::find($assetSize->size_tema_id);
        
        return response()->json([
            'message' => 'List of themes',
            'data' => $request->all(),
            'assetSize' => $assetSize,
            'size' => $size,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tema $tema)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tema $tema)
    {
        //
    }
}
