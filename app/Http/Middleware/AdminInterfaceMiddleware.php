<?php

namespace App\Http\Middleware;

use App\Enums\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminInterfaceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        return \response()->json([]);
        //abort(404);
        if ($request->is('admin/*')) {
            $user = $request->user();
            if (!empty($user) && $user->role === Role::ADMIN) {
                return $next($request);
            }

            abort(401);
        }
        return $next($request);
    }
}
