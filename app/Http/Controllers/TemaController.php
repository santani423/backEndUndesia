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
    public function show($tema)
    {
        $tema = Tema::with([
            'assets.assetSizes.breakpoint',
            'assets.assetSizes.sizeTema',
            'themeColors',
        ])->where('code', $tema)->first();

        if (!$tema) {
            return response()->json([
                'message' => 'Tema tidak ditemukan',
            ], 404);
        }

        $assets = $tema->assets->map(function ($asset) {
            return [
                'id'     => $asset->id,
                'name'   => $asset->name,
                'src'    => $asset->path,
                'xMedia' => $asset->assetSizes->map(function ($assetSize) {
                    return [
                        'device' => $assetSize->breakpoint?->code,
                        'py'     => $assetSize->py,
                        'size'   => $assetSize->sizeTema?->value,
                    ];
                })->values(),
            ];
        })->values();

        return response()->json([
            'message' => 'Detail tema',
            'data'    => [
                'id'     => $tema->id,
                'code'   => $tema->code,
                'name'   => $tema->name,
                'assets' => $assets,
                'themeColors' => $tema->themeColors,
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {

        $validated = $request->validate([
            'asset_id'   => 'required|integer',
            'breakpoint' => 'required|string',
            'plesMinus'  => 'required|in:+,-',
            'type'       => 'required|string|in:top,bottom,right,left,w',
        ]);



        // Ambil breakpoint
        $breakpoint = BreackPoin::where('code', $validated['breakpoint'])->first();
        if (!$breakpoint) {
            return response()->json([
                'status' => false,
                'message' => 'Breakpoint tidak ditemukan',
            ], 404);
        }
        // return response()->json([
        //     'status' => true,
        //     'message' => '85', 
        // ]);
        // Ambil asset size
        $assetSize = AssetSize::where('asset_id', $validated['asset_id'])
            // ->where('type', $validated['type'])
            ->where('breack_poin_id', $breakpoint->id)
            ->get();

        if ($assetSize->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Asset size tidak ditemukan',
            ], 404);
        }

        $size = null;
        //  return response()->json([
        //         'status' => false,
        //         'message' => $assetSize,
        //     ], 200);
        // Ambil size sekarang
        foreach ($assetSize as $assetSizeItem) {
            $size = SizeTema::find($assetSizeItem->size_tema_id);
            if ($size && $size->type === $validated['type']) {
                $assetSize = $assetSizeItem;
                break;

            }
            
        }
         
        if (!$size) {
            return response()->json([
                'status' => false,
                'message' => 'Size tema tidak ditemukan',
            ], 404);
        }

        // Hitung no baru
        $updateNo = $validated['plesMinus'] === '+'
            ? $size->no + 1
            : $size->no - 1;

        // Ambil size tujuan
        $size2 = SizeTema::where('no', $updateNo)
            ->where('type', $size->type)
            ->first();

        if (!$size2) {
            return response()->json([
                'status' => false,
                'message' => 'Size tujuan tidak tersedia',
                'updateNo' => $updateNo,
            ], 400);
        }

        // Update
        $assetSize->size_tema_id = $size2->id;
        $assetSize->save();

        return response()->json([
            'status' => true,
            'message' => 'Size berhasil diupdate',
            'data' => [
                'asset_id' => $validated['asset_id'],
                'breakpoint' => $validated['breakpoint'],
                'old_size' => $size,
                'new_size' => $size2,
                'updateNo' => $updateNo,
            ],
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $tema = Tema::find($id);

        if (!$tema) {
            return response()->json([
                'status'  => false,
                'message' => 'Tema tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:200',
            'code' => 'sometimes|string|max:200|unique:temas,code,' . $tema->id,
        ]);

        $tema->fill($validated);
        $tema->save();

        return response()->json([
            'status'  => true,
            'message' => 'Tema berhasil diupdate',
            'data'    => $tema,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tema $tema)
    {
        //
    }
}
