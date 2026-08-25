<?php

namespace Stezkoy\FlarumTelegramAudit\Listeners;

use Flarum\Http\UrlGenerator;
use Flarum\Locale\Translator;
use Flarum\Settings\SettingsRepositoryInterface;
use Stezkoy\FlarumTelegramAudit\TelegramNotifier;

class UserGdprErased
{
    public function __construct(
        private readonly TelegramNotifier $notifier,
        private readonly Translator $translator,
        private readonly SettingsRepositoryInterface $settings,
        private readonly UrlGenerator $url,
    ) {}

    public function handle(object $event): void
    {
        if (!in_array($this->settings->get('stezkoy-telegram-audit.notify_on_user_gdpr_erased'), [true, '1', 1], true)) {
            return;
        }

        $user = $event->user;
        $mode = $event->mode ?? 'unknown';

        if ($mode === 'anonymization') {
            $message = $this->translator->trans('stezkoy-telegram-audit.messages.user_gdpr_anonymized', [
                '{username}' => $user->username,
            ]);
        } else {
            $message = $this->translator->trans('stezkoy-telegram-audit.messages.user_gdpr_deleted', [
                '{username}' => $user->username,
            ]);
        }

        $this->notifier->dispatch($message);
    }
}
