<?php

namespace Application\Lumen53\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Application\Lumen53\Exceptions\ApplicationException;

class JWTMiddleware
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($this->auth->guard($guard)->guest()) {
            throw new ApplicationException('Unauthorized',401);
        }
        return $next($request);
    }
}