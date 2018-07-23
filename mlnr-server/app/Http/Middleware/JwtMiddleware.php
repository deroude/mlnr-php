<?php
namespace App\Http\Middleware;

use App\User;
use Closure;
use Exception;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;

class JwtMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $token = trim($request->header('Authorization'));

        if (!$token || substr($token, 0, 6) != 'Bearer') {
            // Unauthorized response if token not there
            return response()->json([
                'error' => 'Token not provided as an Authorization Header with Bearer schema',
            ], 401);
        }
        try {
            $credentials = JWT::decode(substr($token, 7), env('JWT_SECRET', '0v9+i34LalcbnMdsGQZQzA=='), ['HS256']);
        } catch (ExpiredException $e) {
            return response()->json([
                'error' => 'Provided token is expired.',
            ], 400);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'An error while decoding token.',
            ], 400);
        }
        $user = User::find($credentials->sub);
        // Now let's put the user in the request class so that you can grab it from there
        $request->auth = $user;
        return $next($request);
    }
}
