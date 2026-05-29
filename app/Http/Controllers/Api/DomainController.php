<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Komen;
use App\Models\Order;
use App\Models\Rsvp;
use App\Models\Tamu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
            'user.dressCode',
            'user.dressCode.codeItem',
            'user.dressCode.codePalette'
        )->where('domain', $id)->first();

        if (!$domain) {
            return response()->json([
                'message' => 'Domain not found',
            ], 404); 
        }
  
        $slug = $request->query('slug');
        $tamu = Tamu::with('rsvp')->where('nama_slug', $slug)->where('id_user', $domain->id_user)->first();
            
        // if (!$tamu) {
        //     return response()->json([
        //         'message' => 'Tamu not found',
        //     ], 404);
        // }

        if (!$domain) {
            return response()->json([
                'message' => 'Domain not found',
            ], 404); 
        }
        return response()->json([
            'message' => 'Domain details',
            'data' => $domain,
            'tamu' => $tamu ,
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

    public function komentarAll(Request $request)
    {
        try {
            $komentar = Komen::where('id_user', $request->id_user)->orderBy('created_at', 'desc')->get();

            return response()->json([
                'message' => $komentar->isEmpty() ? 'Tidak ada komentar untuk user ini' : 'List komentar',
                'total' => $komentar->count(),
                'data' => $komentar,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengambil komentar',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function tamu(Request $request, $id, $slug)
    {
        $tamu = Tamu::where('nama_slug', $slug)->where('id_user', $id)->first();

        if (!$tamu) {
            return response()->json([
                'message' => 'Tamu not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Tamu details',
            'data' => $tamu,
        ]);
    }

    public function rsvpAdd(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_user' => 'required|integer',
            'slug' => 'nullable|string|max:255',
            'nama' => 'required|string|max:255',
            'kehadiran' => 'required|in:Hadir,Tidak Hadir',
            'massage' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validasi gagal',
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $tamu = null;

            if ($request->slug) {
                $tamu = Tamu::where('nama_slug', $request->slug)
                    ->where('id_user', $request->id_user)
                    ->first();

                if ($tamu) {
                    $tamu->update([
                        'status' => $request->kehadiran,
                    ]);
                }
            }
            if ($tamu) {
                $rsvp = $tamu->rsvp;

                if ($rsvp) {
                    $rsvp->update(['massage' => $request->massage]);
                } else {
                    $rsvp = Rsvp::create([
                        'tamu_id' => $tamu->id_tamu,
                        'massage' => $request->massage,
                    ]);
                }
            } else {
                $rsvp = Rsvp::create([
                    'tamu_id' => null,
                    'massage' => $request->massage,
                ]);
            }

            return response()->json([
                'message' => 'RSVP berhasil ditambahkan',
                'data' => $rsvp,
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal menambahkan RSVP',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
