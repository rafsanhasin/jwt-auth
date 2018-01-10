<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\JWTAuth;

class JWTAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    protected $jwt;

    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;
    }

    public function handle($request, Closure $next)
    {
        try {
            $this->jwt->setToken($this->jwt->getToken());
            if (! $user = $this->jwt->authenticate()) {
                return response()->json(['authentication failed'], 404);
            }

            $request['client_id'] = $this->jwt->parseToken()->getPayload()->get('client_id');

            return $next($request);


        } catch (\Exception $e){

            return response()->json(['Invalid token'], 404);
        }
    }
}
