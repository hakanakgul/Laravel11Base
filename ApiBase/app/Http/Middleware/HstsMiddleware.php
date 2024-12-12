<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HstsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        //Strict-Transport-Security (HSTS): Tarayıcıyı yalnızca HTTPS üzerinden bağlanmaya zorlar.
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

        return $response;
    }
}