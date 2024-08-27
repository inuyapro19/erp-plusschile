<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $permission = null)
    {
        // Verifica si el usuario está logueado y tiene el permiso necesario
        if (Auth::guest() || !$request->user()->can($permission)) {
            // Aquí puedes redirigir al usuario a donde consideres adecuado
            // Por ejemplo, a una página de error o la página principal
            return redirect('/404')->with('error', 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}
