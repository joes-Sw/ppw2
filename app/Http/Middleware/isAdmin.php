<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (Auth::check() && Auth::user()->level === 'admin') {
        //     return $next($request); // Jika admin, lanjut ke request berikutnya
        // }

        // // Jika bukan admin, redirect ke logout
        // Auth::logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        // return redirect()->route('login')->with('error', 'Anda bukan admin!');
        if(auth()->user() && auth()->user()->level !== 'admin'){
            return redirect('/posts')->with('error','Anda Tidak memiliki akses ke halaman admin');
        }
        return $next($request);
    }
}
