<?php

declare(strict_types=1);

namespace Voltra\LaravelAiHoneypot\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static bool isAiRequest(\Illuminate\Http\Request $request)
 * @method static \Symfony\Component\HttpFoundation\Response handleRequest(\Illuminate\Http\Request $request, \Closure $next)
 *
 * @see \Voltra\LaravelAiHoneypot\Contracts\AiHoneypotServiceContract
 */
class LaravelAiHoneypot extends Facade
{
    /**
     * {@inheritDoc}
     *
     * @return class-string<\Voltra\LaravelAiHoneypot\Contracts\AiHoneypotServiceContract>
     */
    protected static function getFacadeAccessor()
    {
        return \Voltra\LaravelAiHoneypot\Contracts\AiHoneypotServiceContract::class;
    }
}
