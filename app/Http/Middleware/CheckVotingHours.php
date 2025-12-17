<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class CheckVotingHours
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Define o timezone do Brasil
        $now = Carbon::now('America/Sao_Paulo');
        $currentHour = $now->hour;
        $currentMinute = $now->minute;

        // Horário permitido: 20:00 até 23:59
        $startHour = 20;
        $endHour = 23;
        $endMinute = 59;

        // Verifica se está fora do horário permitido
        if ($currentHour < $startHour || ($currentHour > $endHour) || ($currentHour == $endHour && $currentMinute > $endMinute)) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'A votação está disponível apenas das 20:00 às 23:59.'
                ], 403);
            }

            return redirect()->route('votacao.index')
                ->with('error', 'A votação está disponível apenas das 20:00 às 23:59.');
        }

        return $next($request);
    }
}
