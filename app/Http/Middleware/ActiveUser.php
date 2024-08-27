<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ActiveUser
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
        if (auth()->user()->deleted_at) {
            $user = auth()->user();
            auth()->logout();
            return redirect()->route('login')
                ->withError('Tu usuario ha sido bloqueda' . $user->deleted_at);
        }

        return $next($request);
    }
}
