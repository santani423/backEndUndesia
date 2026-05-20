<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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

        $tamu = Tamu::where('nama_slig', $request->slig)->where('user_id', $domain->user->id)->first();

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
}
