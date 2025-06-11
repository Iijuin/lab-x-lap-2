<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\AuditLog;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            AuditLog::log('admin_access', 'failed', [
                'reason' => 'not_authenticated',
                'path' => $request->path()
            ]);
            
            // Tampilkan view admin.login_required
            return response()->view('admin.login_required');
        }

        if (!auth()->user()->is_admin) {
            AuditLog::log('admin_access', 'failed', [
                'reason' => 'not_admin',
                'user_id' => auth()->id(),
                'path' => $request->path()
            ]);
            
            return redirect()->route('home')->with('error', 'Akses ditolak. Anda bukan admin.');
        }

        AuditLog::log('admin_access', 'success', [
            'user_id' => auth()->id(),
            'path' => $request->path()
        ]);

        return $next($request);
    }
}
   