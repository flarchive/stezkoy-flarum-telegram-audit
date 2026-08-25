<?php

namespace Stezkoy\FlarumTelegramAudit\Listeners;

use Flarum\Http\UrlGenerator;
use Flarum\Locale\Translator;
use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\Event\Activated;
use Stezkoy\FlarumTelegramAudit\TelegramNotifier;

class EmailConfirmed
{
    public function __construct(
        private readonly TelegramNotifier $notifier,
        private readonly Translator $translator,
        private readonly SettingsRepositoryInterface $settings,
        private readonly UrlGenerator $url,
    ) {}

    public function handle(Activated $event): void
    {
        if (!in_array($this->settings->get('stezkoy-telegram-audit.notify_on_email_confirmed'), [true, '1', 1], true)) {
            return;
        }

        $user = $event->user;

        $message = $this->translator->trans('stezkoy-telegram-audit.messages.email_confirmed', [
            '{username}' => $user->display_name,
            '{email}' => $user->email,
            '{profile_url}' => $this->url->to('forum')->route('user', ['username' => $user->username]),
        ]);

        $this->notifier->dispatch($message);
    }
}
