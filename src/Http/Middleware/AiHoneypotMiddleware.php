<?php

namespace Voltra\LaravelAiHoneypot\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Voltra\LaravelAiHoneypot\Facades\LaravelAiHoneypot;

class AiHoneypotMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (LaravelAiHoneypot::isAiRequest($request)) {
            return LaravelAiHoneypot::handleRequest($request, $next);
        }

        return $next($request);
    }
}
