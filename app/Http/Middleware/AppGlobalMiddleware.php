<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class AppGlobalMiddleware
{
    const RequestIdKey = 'X-Request-Id';
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $uuid = $request->headers->get(self::RequestIdKey);
        if (empty($uuid)) {
            $request->headers->set(self::RequestIdKey, $uuid = Str::uuid());
        }

        /** @var Response $response */
        $response = $next($request);
        $response->headers->set(self::RequestIdKey, $uuid);
        $response->headers->set('X-Via', gethostname());

        return $response;
    }
}
