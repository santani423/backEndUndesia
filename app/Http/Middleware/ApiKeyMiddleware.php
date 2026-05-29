<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (config('app.debug')) {
            return $next($request);
        }

        $encryptedKey = $request->header('X-API-Key') ?? $request->query('api_key');

        if (!$encryptedKey) {
            return response()->json(['message' => 'Unauthorized: API key missing.'], 401);
        }

        $decrypted = $this->decrypt($encryptedKey);

        if ($decrypted === null || $decrypted !== config('app.api_key')) {
            return response()->json(['message' => 'Unauthorized: Invalid API key.'], 401);
        }

        return $next($request);
    }

    private function decrypt(string $encryptedKey): ?string
    {
        try {
            $secret = config('app.api_secret');
            $secretKey = hash('sha256', $secret, true); // 32 bytes key

            $data = base64_decode($encryptedKey);
            if ($data === false || strlen($data) < 16) {
                return null;
            }

            $iv        = substr($data, 0, 16);
            $ciphertext = substr($data, 16);

            $decrypted = openssl_decrypt($ciphertext, 'AES-256-CBC', $secretKey, OPENSSL_RAW_DATA, $iv);

            return $decrypted === false ? null : $decrypted;
        } catch (\Throwable) {
            return null;
        }
    }
}
