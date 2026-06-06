<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AssetController extends Controller
{
    /**
     * Upload gambar aset dan simpan ke storage/app/public/assets.
     * POST /api/upload-asset
     * Body: multipart/form-data, field "file"
     * Response: { url: "/storage/assets/xxx.jpg", path: "assets/xxx.jpg" }
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'image', 'max:5120'], // maks 5 MB
        ]);

        $file      = $request->file('file');
        $ext       = $file->getClientOriginalExtension();
        $filename  = Str::uuid() . '.' . $ext;
        $storedPath = $file->storeAs('assets', $filename, 'public');

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
