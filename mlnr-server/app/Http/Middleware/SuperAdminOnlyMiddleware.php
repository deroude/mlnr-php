<?php
namespace App\Http\Middleware;

use App\Domain\User;
use Closure;
use Exception;
use Illuminate\Http\Response;

class SuperAdminOnlyMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        if($request->auth->role!='SUPERADMIN'){
            abort(Response::HTTP_FORBIDDEN,'SUPERADMIN_ONLY');
        }
        return $next($request);
    }
}
