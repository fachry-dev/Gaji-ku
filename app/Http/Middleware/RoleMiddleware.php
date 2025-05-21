<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) { // Jika belum login
            return redirect('login');
        }

        $user = Auth::user();
        if (!in_array($user->role, $roles)) {
            // Redirect ke halaman yang sesuai jika role tidak cocok
            if ($user->isAdmin()) {
                return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            } elseif ($user->isKaryawan()) {
                return redirect()->route('karyawan.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
            }
            // Default jika tidak ada role cocok (seharusnya tidak terjadi jika login berhasil)
            Auth::logout();
            return redirect('login')->with('error', 'Akses ditolak.');
        }

        return $next($request);
    }
}