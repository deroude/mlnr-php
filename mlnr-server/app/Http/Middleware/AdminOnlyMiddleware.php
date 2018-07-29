<?php
namespace App\Http\Middleware;

use App\Domain\User;
use Closure;
use Exception;
use Illuminate\Http\Response;

class AdminOnlyMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        if($request->auth->role!='ADMIN'){
            abort(Response::HTTP_FORBIDDEN,'ADMIN_ONLY');
        }
        return $next($request);
    }
}
