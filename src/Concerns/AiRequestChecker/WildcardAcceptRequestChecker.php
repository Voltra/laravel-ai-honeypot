<?php

declare(strict_types=1);

namespace Voltra\LaravelAiHoneypot\Concerns\AiRequestChecker;

use Illuminate\Http\Request;
use Voltra\LaravelAiHoneypot\Concerns\AbstractAiRequestChecker;
use Voltra\LaravelAiHoneypot\Enums\MimeType;

class WildcardAcceptRequestChecker extends AbstractAiRequestChecker
{
    /**
     * {@inheritdoc}
     */
    public function precondition(Request $request): bool
    {
        return $request->acceptsAnyContentType();
    }

    /**
     * {@inheritdoc}
     */
    public function process(Request $request): bool
    {
        if ($request->prefers(MimeType::MARKDOWN)) {
            return false;
        }

        return true;
    }
}
