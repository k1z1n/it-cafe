<?php

namespace App\Http\Middleware;

use App\Models\StatisticVisit;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RecordVisit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $today = Carbon::now()->toDateString();

        $visit = StatisticVisit::where('date', $today)->first();

        if ($visit) {
            $visit->increment('count');
        } else {
            $data = [
                'date' => $today,
                'count' => 1,
            ];
            StatisticVisit::create($data);
        }

        return $next($request);
    }
}
