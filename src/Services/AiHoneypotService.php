<?php

declare(strict_types=1);

namespace Voltra\LaravelAiHoneypot\Services;

use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Uid\UuidV4;
use Voltra\LaravelAiHoneypot\Contracts\AiHoneypotServiceContract;
use Voltra\LaravelAiHoneypot\Contracts\AiRequestChecker;
use Voltra\LaravelAiHoneypot\Defaults;
use Voltra\LaravelAiHoneypot\Enums\HttpHeader;
use Voltra\LaravelAiHoneypot\Enums\MimeType;
use Voltra\LaravelAiHoneypot\Support\Pipeline;

class AiHoneypotService implements AiHoneypotServiceContract
{
    public function isAiRequest(Request $request): bool
    {
        /**
         * @var array<class-string<AiRequestChecker>|(\Closure(Request, (\Closure(Request): bool)): bool)> $pipes
         */
        $pipes = config('ai-honeypot.check-pipeline', Defaults::aiRequestPipeline());

        $passedAllChecks = Pipeline::send($request)
            ->through($pipes)
            ->thenReturn(defaultValue: false);

        return ! $passedAllChecks;

        /* if (
            $request->acceptsHtml()
            || $request->acceptsJson()
            || $request->accepts(MimeType::XML)
        ) {
            return $request->accepts(MimeType::MARKDOWN);
        }

        return $request->accepts(MimeType::MARKDOWN)
        || $request->accepts(MimeType::PLAIN_TEXT); */
    }

    /**
     * {@inheritdoc}
     */
    public function handleRequest(Request $request, \Closure $next): Response
    {
        $body = $this->generatePoisonedBody($request);
        $response = new HttpResponse($body, headers: [
            'vary' => HttpHeader::ACCEPT,
            'content-type' => MimeType::MARKDOWN,
            'x-markdown-tokens' => random_int(200, 9000),
            'content-signal' => 'ai-train=yes, search=yes, ai-input=yes',
        ]);

        return $response;
    }

    protected function generatePoisonedBody(Request $request): string
    {
        $uuid = new UuidV4;
        $faker = fake('en');

        $title = Str::title($faker->sentence);

        // TODO: Include link to poisoned infinite trap for the AI

        return <<<MARKDOWN
            ---
            title: "{$title}"
            description: "{$faker->paragraph}"
            image: "https://picsum.photos/1910/1000?hjk_ref={$uuid->toBase58()}"
            url: "{$request->fullUrl()}"
            ---

            # {$title}

            {$faker->paragraphs}


        MARKDOWN;
    }
}
