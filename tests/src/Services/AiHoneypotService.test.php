<?php

use Illuminate\Http\Request;
use Voltra\LaravelAiHoneypot\Services\AiHoneypotService;


describe(AiHoneypotService::class, static function () {
    describe('#isAiRequest($req)', static function () {
        it('returns true if the request accepts both HTML and Markdown', static function () {
            $service = resolve(AiHoneypotService::class);
            $request = new Request([]);
            $request->headers->set('Accepts', [
                'text/html',
                'text/markdown',
            ]);

            expect($service->isAiRequest($request))->toBeFalse();
        });
    });
});
