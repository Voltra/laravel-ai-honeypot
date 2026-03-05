<?php

declare(strict_types=1);

namespace Voltra\LaravelAiHoneypot\Contracts;

use Illuminate\Http\Request;

interface AiRequestChecker
{
    /**
     * Process the AI request check on the given request
     *
     * @param  \Closure(\Illuminate\Http\Request): bool  $next
     * @return bool - FALSE if it's estimated to be an AI request, TRUE otherwise
     */
    public function __invoke(Request $request, \Closure $next): bool;
}
