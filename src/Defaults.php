<?php

declare(strict_types=1);

namespace Voltra\LaravelAiHoneypot;

use Illuminate\Http\Request;
use Voltra\LaravelAiHoneypot\Concerns\AiRequestChecker\AjaxRequestChecker;
use Voltra\LaravelAiHoneypot\Concerns\AiRequestChecker\JsonRequestChecker;
use Voltra\LaravelAiHoneypot\Concerns\AiRequestChecker\MarkdownRequestChecker;
use Voltra\LaravelAiHoneypot\Concerns\AiRequestChecker\WildcardAcceptRequestChecker;
use Voltra\LaravelAiHoneypot\Concerns\AiRequestChecker\XmlRequestChecker;
use Voltra\LaravelAiHoneypot\Contracts\AiRequestChecker;

final class Defaults
{
    /**
     * @return array<class-string<AiRequestChecker>|(\Closure(Request, (\Closure(Request): bool)): bool)>
     */
    public static function aiRequestPipeline(): array
    {
        return [
            WildcardAcceptRequestChecker::class,
            MarkdownRequestChecker::class,
            AjaxRequestChecker::class,
            XmlRequestChecker::class,
            JsonRequestChecker::class,
        ];
    }
}
