<?php

declare(strict_types=1);

namespace Voltra\LaravelAiHoneypot\Support;

/**
 * @template T
 */
class IntrusiveOutput
{
    /**
     * @var ?T
     */
    private $output = null;

    private bool $wasSet = false;

    /**
     * @param  T  $out
     */
    public function setOutput($out)
    {
        $this->wasSet = true;
        $this->output = $out;
    }

    /**
     * @return ?T
     */
    public function getOutput()
    {
        return $this->output;
    }

    public function hasOutput(): bool
    {
        return $this->wasSet;
    }
}
