<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use MioNext\Jesponse\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $headers = [
            'Access-Control-Allow-Origin' => env('CORS_ORIGINS', $request->headers->get('Origin', '*')),
            'Access-Control-Allow-Headers' => env('CORS_ALLOW_HEADERS', 'X-Requested-With, Content-Type, X-Request-Id, Accept, Origin, Authorization, X-Build'),
            'Access-Control-Allow-Methods' => env('CORS_ALLOW_METHODS', 'GET, POST, PATCH, PUT, DELETE, OPTIONS')
        ];

        if ($request->isMethod('OPTIONS')) {
            return Response::make(204, null, 'OK', 204, $headers);
        }

        /** @var JsonResponse $response */
        $response = $next($request);
        foreach ($headers as $key => $value) {
            $response->headers->set($key, $value);
        }

        return $response;
    }
}
