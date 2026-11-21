<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var \App\Models\User|null $user */
        $user = $request->user();

        // 1. Pastikan user sudah login
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Periksa apakah user adalah admin
        if ($user->role !== 'admin') {
            abort(403, 'Akses Ditolak: Anda login sebagai User Biasa. Hanya Administrator yang berhak menambah atau mengubah data.');
        }

        return $next($request);
    }
}