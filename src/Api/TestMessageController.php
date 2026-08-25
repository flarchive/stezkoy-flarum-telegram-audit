<?php

namespace Stezkoy\FlarumTelegramAudit\Api;

use Flarum\Http\RequestUtil;
use Flarum\Locale\Translator;
use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Stezkoy\FlarumTelegramAudit\TelegramNotifier;

class TestMessageController implements RequestHandlerInterface
{
    public function __construct(
        private readonly TelegramNotifier $notifier,
        private readonly Translator $translator,
    ) {}

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $actor = RequestUtil::getActor($request);
        $actor->assertAdmin();

        $message = (string) $this->translator->trans('stezkoy-telegram-audit.admin.test_message', [
            '{username}' => $actor->display_name ?? $actor->username ?? 'Admin',
        ]);

        return new JsonResponse($this->notifier->send($message));
    }
}
