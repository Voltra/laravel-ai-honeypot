<?php

declare(strict_types=1);

namespace Voltra\LaravelAiHoneypot\Concerns\AiRequestChecker;

use Illuminate\Http\Request;
use Voltra\LaravelAiHoneypot\Contracts\AiRequestChecker;
use Voltra\LaravelAiHoneypot\Enums\MimeType;

class MarkdownRequestChecker implements AiRequestChecker
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(Request $request, \Closure $next): bool
    {
        if ($request->accepts(MimeType::MARKDOWN)) {
            return false;
        }

        return $next($request);
    }
}
