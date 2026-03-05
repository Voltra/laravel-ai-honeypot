<?php

declare(strict_types=1);

namespace Voltra\LaravelAiHoneypot\Contracts;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

interface AiHoneypotServiceContract
{
    /**
     * Detect whether the incoming request is from an AI agent/bot/crawler
     *
     * @return bool TRUE if it does, FALSE othewise
     */
    public function isAiRequest(Request $request): bool;

    /**
     * Handle the incoming AI agent/bot/crawler's request
     *
     * @param  \Closure(\Illuminate\Http\Request): \Symfony\Component\HttpFoundation\Response  $next
     */
    public function handleRequest(Request $request, \Closure $next): Response;
}
