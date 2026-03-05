<?php

declare(strict_types=1);

use Illuminate\Http\Request;
use Voltra\LaravelAiHoneypot\Enums\HttpHeader;
use Voltra\LaravelAiHoneypot\Enums\MimeType;
use Voltra\LaravelAiHoneypot\Services\AiHoneypotService;

describe(AiHoneypotService::class, function () {
    describe('#isAiRequest($req)', function () {
        it('returns true if the request accepts both HTML and Markdown', function () {
            $service = resolve(AiHoneypotService::class);
            $request = new Request([]);
            $request->headers->set(HttpHeader::ACCEPT, [
                MimeType::HTML,
                MimeType::MARKDOWN,
            ]);

            expect($service->isAiRequest($request))->toBeTrue();
        });

        it('returns true if the request accepts both XML and Markdown', function () {
            $service = resolve(AiHoneypotService::class);
            $request = new Request([]);
            $request->headers->set(HttpHeader::ACCEPT, [
                MimeType::XML,
                MimeType::MARKDOWN,
            ]);

            expect($service->isAiRequest($request))->toBeTrue();
        });

        it('returns true if the request accepts both JSON and Markdown', function () {
            $service = resolve(AiHoneypotService::class);
            $request = new Request([]);
            $request->headers->set(HttpHeader::ACCEPT, [
                MimeType::JSON,
                MimeType::MARKDOWN,
            ]);

            expect($service->isAiRequest($request))->toBeTrue();
        });

        it('returns true if the request accepts both JSON-LD and Markdown', function () {
            $service = resolve(AiHoneypotService::class);
            $request = new Request([]);
            $request->headers->set(HttpHeader::ACCEPT, [
                MimeType::JSON_LD,
                MimeType::MARKDOWN,
            ]);

            expect($service->isAiRequest($request))->toBeTrue();
        });

        it('returns true if the request accepts Markdown', function () {
            $service = resolve(AiHoneypotService::class);
            $request = new Request([]);
            $request->headers->set(HttpHeader::ACCEPT, [
                MimeType::MARKDOWN,
            ]);

            expect($service->isAiRequest($request))->toBeTrue();
        });

        it('returns true if the request accepts plain text', function () {
            $service = resolve(AiHoneypotService::class);
            $request = new Request([]);
            $request->headers->set(HttpHeader::ACCEPT, [
                MimeType::PLAIN_TEXT,
            ]);

            expect($service->isAiRequest($request))->toBeTrue();
        });

        it('returns false if the request accepts only JSON, HTML and XML', function () {
            $service = resolve(AiHoneypotService::class);
            $request = new Request([]);
            $request->headers->set(HttpHeader::ACCEPT, [
                MimeType::JSON,
                MimeType::HTML,
                MimeType::XML,
            ]);

            expect($service->isAiRequest($request))->toBeFalse();
        });

        it('returns false if the request accepts only JSON', function () {
            $service = resolve(AiHoneypotService::class);
            $request = new Request([]);
            $request->headers->set(HttpHeader::ACCEPT, [
                MimeType::JSON,
            ]);

            expect($service->isAiRequest($request))->toBeFalse();
        });

        it('returns false if the request accepts only HTML', function () {
            $service = resolve(AiHoneypotService::class);
            $request = new Request([]);
            $request->headers->set(HttpHeader::ACCEPT, [
                MimeType::HTML,
            ]);

            expect($service->isAiRequest($request))->toBeFalse();
        });

        it('returns false if the request accepts only XML', function () {
            $service = resolve(AiHoneypotService::class);
            $request = new Request([]);
            $request->headers->set(HttpHeader::ACCEPT, [
                MimeType::XML,
            ]);

            expect($service->isAiRequest($request))->toBeFalse();
        });
    });
});
