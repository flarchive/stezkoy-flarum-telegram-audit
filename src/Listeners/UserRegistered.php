<?php

namespace Stezkoy\FlarumTelegramAudit\Listeners;

use Flarum\Http\UrlGenerator;
use Flarum\Locale\Translator;
use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\Event\Registered;
use Stezkoy\FlarumTelegramAudit\TelegramNotifier;

class UserRegistered
{
    public function __construct(
        private readonly TelegramNotifier $notifier,
        private readonly Translator $translator,
        private readonly SettingsRepositoryInterface $settings,
        private readonly UrlGenerator $url,
    ) {}

    public function handle(Registered $event): void
    {
        if (!in_array($this->settings->get('stezkoy-telegram-audit.notify_on_register'), [true, '1', 1], true)) {
            return;
        }

        $user = $event->user;

        $message = $this->translator->trans('stezkoy-telegram-audit.messages.user_registered', [
            '{username}' => $user->display_name,
            '{email}' => $user->email,
            '{profile_url}' => $this->url->to('forum')->route('user', ['username' => $user->username]),
        ]);

        $this->notifier->dispatch($message);
    }
}
