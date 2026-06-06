<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AssetController extends Controller
{
    /**
     * Upload gambar aset.
     * POST /api/upload-asset
     * Body: multipart/form-data
     *   - file      : gambar (wajib)
     *   - tema_name : nama/kode tema (opsional, default "default")
     * Response: { url: "/storage/themes/{tema}/file.jpg", path: "themes/{tema}/file.jpg" }
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file'      => ['required', 'file', 'image', 'max:5120'],
            'tema_name' => ['nullable', 'string', 'max:100'],
        ]);

        $file = $request->file('file');
        $ext  = $file->getClientOriginalExtension();

        // Sanitasi nama tema: hanya huruf, angka, strip, underscore
        $rawName  = $request->input('tema_name', 'default');
        $temeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', trim($rawName)) ?: 'default';

        $folder = 'themes/' . $temeName;

        // Pastikan direktori ada
        $diskPath = Storage::disk('public')->path($folder);
        if (!is_dir($diskPath)) {
            mkdir($diskPath, 0755, true);
        }

        $filename   = Str::uuid() . '.' . $ext;
        $storedPath = $file->storeAs($folder, $filename, 'public');

        return response()->json([
            'url'  => Storage::disk('public')->url($storedPath),
            'path' => $storedPath,
        ]);
    }

    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Asset $asset)
    {
        //
    }

    public function update(Request $request, Asset $asset)
    {
        //
    }

    public function destroy(Asset $asset)
    {
        //
    }
}
