<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPanelAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Obtendo o painel atual
        $currentPanel = Filament::getCurrentPanel();

        // Verifica se o painel atual existe
        if ($currentPanel) {
            $panelId = $currentPanel->getId();

            // Aqui podes definir lógica baseada no painel
            if ($panelId === 'admin' && Auth::check()) {
                if(!$user->is_admin) {
                    return redirect('/')->with('error', 'Você não tem permissão para aceder ao painel de administração.');
                }
            }

            // Aqui podes definir lógica baseada no painel
            if ($panelId === 'attendance' && Auth::check()) {
                if(!$user->is_reception) {
                    return redirect('/')->with('error', 'Você não tem permissão para aceder ao painel de recepção.');
                }
            }

            // Aqui podes definir lógica baseada no painel
            if ($panelId === 'evaluation' && Auth::check()) {
                if(!$user->is_judge) {
                    return redirect('/')->with('error', 'Você não tem permissão para aceder ao painel de avaliação.');
                }
            }
        }

        return $next($request);
    }
}
