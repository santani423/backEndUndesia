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
        $domain = Order::where('domain', $id)->first();
        return response()->json([
            'message' => 'Domain details',
            'data' => $domain,
        ]);
    }
}
