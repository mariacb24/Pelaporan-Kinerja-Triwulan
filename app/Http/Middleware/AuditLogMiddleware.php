<?php

namespace App\Http\Middleware;

use App\Models\AuditLog;
use Closure;
use Illuminate\Http\Request;

class AuditLogMiddleware
{
    public function handle(Request $request, Closure $next): mixed
    {
        $response = $next($request);

        if (auth()->check() && in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            try {
                AuditLog::create([
                    'user_id'    => auth()->id(),
                    'action'     => $request->method() . ' ' . $request->path(),
                    'ip_address' => $request->ip(),
                    'user_agent' => substr($request->userAgent() ?? '', 0, 255),
                ]);
            } catch (\Throwable $e) {
                // Jangan gagalkan request karena audit log
            }
        }

        return $response;
    }
}
