<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckProfile
{
    public function handle($request, Closure $next)
    {
        $user =  Auth::user();
        
        if ($user->bagian != '-' && $user->jabatan != '-' && $user->nip != '-' && $user->ttd != 'qrcode.png') {
            return $next($request); // User has access to "pengajuan cuti" menu
        }
        
        // Redirect or handle unauthorized access here
        return redirect()->route('home')->with('error', 'Unauthorized access.');
    }
}
