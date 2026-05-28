<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetSize;
use App\Models\BreackPoin;
use App\Models\SizeTema;
use App\Models\Tema;
use App\Models\ThemeColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $validated = $request->validate([
            'name'                              => 'required|string|max:200',
            'code'                              => 'required|string|max:200|unique:temas,code',
            'assets'                            => 'nullable|array',
            'assets.*.name'                     => 'required_with:assets|string',
            'assets.*.path'                     => 'required_with:assets|string',
            'assets.*.type'                     => 'nullable|string',
            'assets.*.sizes'                    => 'nullable|array',
            'assets.*.sizes.*.breakpoint_code'  => 'required_with:assets.*.sizes|string|exists:breack_poins,code',
            'assets.*.sizes.*.size_tema_id'     => 'required_with:assets.*.sizes|integer|exists:size_temas,id',
            'theme_colors'                      => 'nullable|array',
            'theme_colors.*.key'                => 'required_with:theme_colors|string',
            'theme_colors.*.value'              => 'required_with:theme_colors|string|max:50',
            'theme_colors.*.label'              => 'nullable|string',
            'theme_colors.*.group'              => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $tema = Tema::create([
                'name' => $validated['name'],
                'code' => $validated['code'],
            ]);

            foreach ($validated['assets'] ?? [] as $assetData) {
                $asset = Asset::create([
                    'tema_id' => $tema->id,
                    'name'    => $assetData['name'],
                    'path'    => $assetData['path'],
                    'type'    => $assetData['type'] ?? null,
                ]);

                foreach ($assetData['sizes'] ?? [] as $sizeData) {
                    $breakpoint = BreackPoin::where('code', $sizeData['breakpoint_code'])->first();
                    AssetSize::create([
                        'asset_id'      => $asset->id,
                        'breack_poin_id' => $breakpoint->id,
                        'size_tema_id'  => $sizeData['size_tema_id'],
                    ]);
                }
            }

            foreach ($validated['theme_colors'] ?? [] as $colorData) {
                ThemeColor::create([
                    'tema_id' => $tema->id,
                    'key'     => $colorData['key'],
                    'value'   => $colorData['value'],
                    'label'   => $colorData['label'] ?? null,
                    'group'   => $colorData['group'] ?? null,
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Gagal membuat tema: ' . $e->getMessage(),
            ], 500);
        }

        $tema->load(['assets.assetSizes.breakpoint', 'assets.assetSizes.sizeTema', 'themeColors']);

        return response()->json([
            'status'  => true,
            'message' => 'Tema berhasil dibuat',
            'data'    => $tema,
        ], 201);
    }

    /**
     * Update seluruh data tema beserta assets, asset_sizes, dan theme_colors.
     */
    public function updateByCode(Request $request, string $code)
    {
        $tema = Tema::where('code', $code)->first();

        if (!$tema) {
            return response()->json([
                'status'  => false,
                'message' => 'Tema tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'name'                              => 'sometimes|string|max:200',
            'code'                              => 'sometimes|string|max:200|unique:temas,code,' . $tema->id,
            'assets'                            => 'nullable|array',
            'assets.*.id'                       => 'nullable|integer|exists:assets,id',
            'assets.*.name'                     => 'required_with:assets|string',
            'assets.*.path'                     => 'required_with:assets|string',
            'assets.*.type'                     => 'nullable|string',
            'assets.*.sizes'                    => 'nullable|array',
            'assets.*.sizes.*.breakpoint_code'  => 'required_with:assets.*.sizes|string|exists:breack_poins,code',
            'assets.*.sizes.*.size_tema_id'     => 'required_with:assets.*.sizes|integer|exists:size_temas,id',
            'theme_colors'                      => 'nullable|array',
            'theme_colors.*.id'                 => 'nullable|integer|exists:theme_colors,id',
            'theme_colors.*.key'                => 'required_with:theme_colors|string',
            'theme_colors.*.value'              => 'required_with:theme_colors|string|max:50',
            'theme_colors.*.label'              => 'nullable|string',
            'theme_colors.*.group'              => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $tema->fill(array_filter([
                'name' => $validated['name'] ?? null,
                'code' => $validated['code'] ?? null,
            ], fn($v) => $v !== null));
            $tema->save();

            if (array_key_exists('assets', $validated)) {
                $incomingAssetIds = collect($validated['assets'])->pluck('id')->filter()->values()->all();
                // Hapus asset yang tidak ada di request
                $tema->assets()->whereNotIn('id', $incomingAssetIds)->each(function ($asset) {
                    $asset->assetSizes()->delete();
                    $asset->delete();
                });

                foreach ($validated['assets'] as $assetData) {
                    if (!empty($assetData['id'])) {
                        $asset = Asset::find($assetData['id']);
                        $asset->update([
                            'name' => $assetData['name'],
                            'path' => $assetData['path'],
                            'type' => $assetData['type'] ?? $asset->type,
                        ]);
                    } else {
                        $asset = Asset::create([
                            'tema_id' => $tema->id,
                            'name'    => $assetData['name'],
                            'path'    => $assetData['path'],
                            'type'    => $assetData['type'] ?? null,
                        ]);
                    }

                    if (array_key_exists('sizes', $assetData)) {
                        $asset->assetSizes()->delete();
                        foreach ($assetData['sizes'] ?? [] as $sizeData) {
                            $breakpoint = BreackPoin::where('code', $sizeData['breakpoint_code'])->first();
                            AssetSize::create([
                                'asset_id'       => $asset->id,
                                'breack_poin_id' => $breakpoint->id,
                                'size_tema_id'   => $sizeData['size_tema_id'],
                            ]);
                        }
                    }
                }
            }

            if (array_key_exists('theme_colors', $validated)) {
                $incomingColorIds = collect($validated['theme_colors'])->pluck('id')->filter()->values()->all();
                ThemeColor::where('tema_id', $tema->id)->whereNotIn('id', $incomingColorIds)->delete();

                foreach ($validated['theme_colors'] as $colorData) {
                    if (!empty($colorData['id'])) {
                        ThemeColor::where('id', $colorData['id'])->update([
                            'key'   => $colorData['key'],
                            'value' => $colorData['value'],
                            'label' => $colorData['label'] ?? null,
                            'group' => $colorData['group'] ?? null,
                        ]);
                    } else {
                        ThemeColor::create([
                            'tema_id' => $tema->id,
                            'key'     => $colorData['key'],
                            'value'   => $colorData['value'],
                            'label'   => $colorData['label'] ?? null,
                            'group'   => $colorData['group'] ?? null,
                        ]);
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Gagal mengupdate tema: ' . $e->getMessage(),
            ], 500);
        }

        $tema->load(['assets.assetSizes.breakpoint', 'assets.assetSizes.sizeTema', 'themeColors']);

        return response()->json([
            'status'  => true,
            'message' => 'Tema berhasil diupdate',
            'data'    => $tema,
        ]);
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
     * Duplicate tema beserta assets, asset_sizes, dan theme_colors dari tema sumber.
     */
    public function duplicate(Request $request, string $sourceCode)
    {
        $source = Tema::with([
            'assets.assetSizes',
            'themeColors',
        ])->where('code', $sourceCode)->first();

        if (!$source) {
            return response()->json([
                'status'  => false,
                'message' => 'Tema sumber tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:200',
            'code' => 'required|string|max:200|unique:temas,code',
        ]);

        DB::beginTransaction();
        try {
            $newTema = Tema::create([
                'name' => $validated['name'],
                'code' => $validated['code'],
            ]);

            foreach ($source->assets as $asset) {
                $newAsset = Asset::create([
                    'tema_id' => $newTema->id,
                    'name'    => $asset->name,
                    'path'    => $asset->path,
                    'type'    => $asset->type,
                ]);

                foreach ($asset->assetSizes as $assetSize) {
                    AssetSize::create([
                        'asset_id'       => $newAsset->id,
                        'breack_poin_id' => $assetSize->breack_poin_id,
                        'size_tema_id'   => $assetSize->size_tema_id,
                    ]);
                }
            }

            foreach ($source->themeColors as $color) {
                ThemeColor::create([
                    'tema_id' => $newTema->id,
                    'key'     => $color->key,
                    'value'   => $color->value,
                    'label'   => $color->label,
                    'group'   => $color->group,
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => 'Gagal menduplikasi tema: ' . $e->getMessage(),
            ], 500);
        }

        $newTema->load(['assets.assetSizes.breakpoint', 'assets.assetSizes.sizeTema', 'themeColors']);

        return response()->json([
            'status'  => true,
            'message' => 'Tema berhasil diduplikasi',
            'data'    => $newTema,
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $code)
    {
        $tema = Tema::where('code', $code)->first();

        if (!$tema) {
            return response()->json(['status' => false, 'message' => 'Tema tidak ditemukan'], 404);
        }

        DB::beginTransaction();
        try {
            foreach ($tema->assets as $asset) {
                $asset->assetSizes()->delete();
                $asset->delete();
            }
            ThemeColor::where('tema_id', $tema->id)->delete();
            $tema->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => false, 'message' => 'Gagal menghapus: ' . $e->getMessage()], 500);
        }

        return response()->json(['status' => true, 'message' => 'Tema berhasil dihapus']);
    }
}
