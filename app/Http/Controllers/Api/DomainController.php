<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Komen;
use App\Models\Order;
use App\Models\Tamu;
use Illuminate\Http\Request;

class DomainController extends Controller
{
    public function index(Request $request)
    {
        return response()->json([
            'message' => 'List of domains',
            'data' => [],
        ]);
    }

    public function show(Request $request, $id)
    {
        $domain = Order::with(
            'user.mempelai',
            'user.album',
            'user.cerita',
            'user.quote',
            'user.data',
            'user.acara',
            'user.rekening',
            'user.rules',
        )->where('domain', $id)->first();

        $tamu = Tamu::where('nama_slug', $request->slig)->where('id_user', $domain->user->id)->first();

        if (!$domain) {
            return response()->json([
                'message' => 'Domain not found',
            ], 404);
        }
        return response()->json([
            'message' => 'Domain details',
            'data' => $domain,
            'tamu' => $tamu,
        ]);
    }

    public function komentar(Request $request)
    {
        $request->validate([
            'id_user' => 'required',
            'nama' => 'required|string|max:255',
            'komen' => 'required|string',
        ]);

        try {
            $komen = Komen::create([
                'id_user' => $request->id_user,
                'nama_komentar' => $request->nama,
                'isi_komentar' => $request->komen,
            ]);

            return response()->json([
                'message' => 'Komentar berhasil ditambahkan',
                'data' => $komen,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menambahkan komentar',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
