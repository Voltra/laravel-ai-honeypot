<?php

declare(strict_types=1);

namespace Voltra\LaravelAiHoneypot\Support;

/**
 * @template Input
 * @template ReturnType
 */
class Pipeline
{
    /**
     * @param  Input  $input
     * @param  array<(callable(Input): ReturnType)>  $pipes
     */
    private function __construct(private $input, private array $pipes = []) {}

    /**
     * @param  Input  $input  - The Data to send through the pipe
     */
    public static function send($input): self
    {
        return new self($input);
    }

    /**
     * Set the pipes to send the data through
     *
     * @param  array<(callable(Input): ReturnType)>  $pipes
     * @return $this
     */
    public function through(array $pipes): static
    {
        $this->pipes = $pipes;

        return $this;
    }

    /**
     * Execute the pipe, then call the completion handler
     *
     * @template Output
     *
     * @param  (callable(Input, ReturnType): Output)  $completionHandler
     */
    public function then(callable $completionHandler)
    {
        if (empty($this->pipes)) {
            throw new \InvalidArgumentException('No pipe to go through was provided to the Pipeline');
        }

        return static::applyPipeline($this->input, $this->pipes, $completionHandler);
    }

    /**
     * Execute the pipe, then return the result
     *
     * @return ReturnType
     */
    public function thenReturn($defaultValue = null)
    {
        return $this->then(fn ($input, $ret) => $ret ?? $defaultValue);
    }

    /**
     * @return Input
     */
    public function thenInput()
    {
        return $this->then(fn ($input, $ret) => $input);
    }

    /**
     * @template Output
     *
     * @param  Input  $input
     * @param  array<(callable(Input): ReturnType)>  $pipes
     * @param  (callable(Input, ReturnType): Output)  $completionHandler
     * @return (callable(): Output)
     */
    protected static function applyPipeline($input, array $pipes, callable $completionHandler)
    {
        // Pipe = (Input, (Input => ReturnType)) => ReturnType
        // Completion = (Input, ReturnType) => Output
        // Pipes = Pipe[]

        // How to craft a stack-like structure that invokes the next pipe as we go?
        $invoke = function ($callable, ...$arguments) {
            if (is_callable($callable)) {
                return $callable(...$arguments);
            }

            $instance = is_object($callable) ? $callable : resolve($callable);

            return $instance(...$arguments);
        };

        $pipeline = array_reduce(
            array_reverse($pipes),
            function ($next, $pipe) use ($invoke) {
                return function ($input) use ($invoke, $next, $pipe) {
                    return $invoke($pipe, $input, $next);
                };
            },
            function ($input) use ($completionHandler) {
                return $completionHandler($input, null);
            }
        );

        return $pipeline($input);
    }
}
