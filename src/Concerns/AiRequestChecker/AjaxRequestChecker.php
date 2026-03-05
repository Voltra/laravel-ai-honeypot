<?php

declare(strict_types=1);

namespace Voltra\LaravelAiHoneypot\Concerns\AiRequestChecker;

use Illuminate\Http\Request;
use Voltra\LaravelAiHoneypot\Contracts\AiRequestChecker;

class AjaxRequestChecker implements AiRequestChecker
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(Request $request, \Closure $next): bool
    {
        if ($request->ajax() || $request->pjax()) {
            return false;
        }

        return $next($request);
    }
}
