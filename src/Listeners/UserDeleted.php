<?php

namespace Stezkoy\FlarumTelegramAudit\Listeners;

use Flarum\Http\UrlGenerator;
use Flarum\Locale\Translator;
use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\Event\Deleted;
use Stezkoy\FlarumTelegramAudit\TelegramNotifier;

class UserDeleted
{
    public function __construct(
        private readonly TelegramNotifier $notifier,
        private readonly Translator $translator,
        private readonly SettingsRepositoryInterface $settings,
    ) {}

    public function handle(Deleted $event): void
    {
        if (!in_array($this->settings->get('stezkoy-telegram-audit.notify_on_user_deleted'), [true, '1', 1], true)) {
            return;
        }

        $user = $event->user;

        $message = $this->translator->trans('stezkoy-telegram-audit.messages.user_deleted', [
            '{username}' => $user->display_name,
        ]);

        $this->notifier->dispatch($message);
    }
}
