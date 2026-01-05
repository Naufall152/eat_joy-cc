<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogVisitMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // skip asset / admin (optional)
        $path = $request->path();
        if (!str_starts_with($path, 'admin')) {
            DB::table('visits')->insert([
                'path' => '/' . $path,
                'ip' => $request->ip(),
                'user_agent' => substr((string)$request->userAgent(), 0, 255),
                'user_id' => auth()->id(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return $next($request);
    }
}
