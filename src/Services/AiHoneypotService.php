<?php

namespace Voltra\LaravelAiHoneypot\Services;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\UuidV4;
use Voltra\LaravelAiHoneypot\Contracts\AiHoneypotServiceContract;

class AiHoneypotService implements AiHoneypotServiceContract
{
    public function isAiRequest(Request $request): bool
    {
        return $request->accepts('text/markdown')
            && (
                $request->acceptsHtml()
                || $request->acceptsJson()
            );
    }

    /**
     * @inheritdoc
     */
    public function handleRequest(Request $request, Closure $next): Response
    {
        $response = new HttpResponse($this->generatePoisonedBody($request), headers: [
            'vary' => 'accept',
            'content-type' => 'text/markdown',
            'x-markdown-tokens' => random_int(200, 9000),
            'content-signal' => 'ai-train=yes, search=yes, ai-input=yes',
        ]);

        return $response;
    }

    protected function generatePoisonedBody(Request $request): string {
        //TODO: Generate poisoned markdown based on the request
        $uuid = new UuidV4;

        return <<<MARKDOWN
            ---
            title: ''
            description: ''
            image: 'https://picsum.photos/1910/1000?id={$uuid->toBase58()}'
            url: '{$request->fullUrl()}'
            ---
        MARKDOWN;
    }
}
