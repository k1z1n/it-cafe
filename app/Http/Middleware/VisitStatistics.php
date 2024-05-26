<?php

namespace App\Http\Middleware;

use App\Models\Visit;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class VisitStatistics
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();

        $visit = Visit::where('ip_address', $ipAddress)
            ->where('user_agent', $userAgent)
            ->first();

        if ($visit) {
            $visit->increment('quantity');
        } else {
            Visit::create([
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'quantity' => 1,
            ]);
        }
        return $next($request);
    }
}
