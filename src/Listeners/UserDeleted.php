<?php

namespace Stezkoy\FlarumTelegramAudit\Listeners;

use Flarum\Locale\Translator;
use Flarum\Settings\SettingsRepositoryInterface;
use Stezkoy\FlarumTelegramAudit\TelegramNotifier;

class UserDeleted
{
    public function __construct(
        private readonly TelegramNotifier $notifier,
        private readonly Translator $translator,
        private readonly SettingsRepositoryInterface $settings,
    ) {}

    public function handle(object $event): void
    {
        if (!in_array($this->settings->get('stezkoy-telegram-audit.notify_on_user_deleted'), [true, '1', 1], true)) {
            return;
        }

        $message = $this->translator->trans('stezkoy-telegram-audit.messages.user_deleted', [
            '{username}' => $event->user->display_name,
        ]);

        $this->notifier->dispatch($message);
    }
}
