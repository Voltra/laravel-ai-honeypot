<?php

declare(strict_types=1);

namespace Voltra\LaravelAiHoneypot\Concerns\AiRequestChecker;

use Illuminate\Http\Request;
use Voltra\LaravelAiHoneypot\Contracts\AiRequestChecker;
use Voltra\LaravelAiHoneypot\Enums\MimeType;

class XmlRequestChecker implements AiRequestChecker
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(Request $request, \Closure $next): bool
    {
        if ($request->accepts(MimeType::XML)) {
            return false;
        }

        return $next($request);
    }
}
