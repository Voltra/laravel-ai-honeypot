<?php

declare(strict_types=1);

// config for voltra/laravel-ai-honeypot

use Illuminate\Http\Request;
use Voltra\LaravelAiHoneypot\Contracts\AiRequestChecker;
use Voltra\LaravelAiHoneypot\Defaults;

return [
    /**
     * @var array<number, AiRequestChecker|(\Closure(Request, (\Closure(Request): bool)): bool)> config('ai-honeypot.check-pipeline')
     */
    'check-pipeline' => Defaults::aiRequestPipeline(),
];
