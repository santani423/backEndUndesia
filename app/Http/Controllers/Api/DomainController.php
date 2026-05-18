<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
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
        $domain = Order::with('getUser.getMempelai')->where('domain', $id)->first();

        if (!$domain) {
            return response()->json([
                'message' => 'Domain not found',
            ], 404);
        }
        return response()->json([
            'message' => 'Domain details',
            'data' => $domain,
        ]);
    }
}
