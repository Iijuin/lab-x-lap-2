<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\UserResponse;

class CheckUserResponseOwnership
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $userResponse = $request->route('userResponse');
        
        // Jika user tidak terautentikasi
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Jika user mencoba mengakses data yang bukan miliknya
        if ($userResponse && $userResponse->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
} 