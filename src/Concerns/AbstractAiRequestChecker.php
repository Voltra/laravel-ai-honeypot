<?php

declare(strict_types=1);

namespace Voltra\LaravelAiHoneypot\Concerns;

use Illuminate\Http\Request;
use Voltra\LaravelAiHoneypot\Contracts\AiRequestChecker;

abstract class AbstractAiRequestChecker implements AiRequestChecker
{
    /**
     * {@inheritdoc}
     */
    public function __invoke(Request $request, \Closure $next): bool
    {
        if (! $this->precondition($request)) {
            return $next($request);
        }

        return $this->process($request);
    }

    /**
     * The precondition to fulfill for this check to be taken into account
     *
     * @return bool - TRUE if the process method should be invoked, FALSE otherwise
     */
    abstract public function precondition(Request $request): bool;

    /**
     * @precondition $this->precondition == true
     * Process the AI request check on the given request
     *
     * @return bool - FALSE if it's estimated to be an AI request, TRUE otherwise
     */
    abstract public function process(Request $request): bool;
}
