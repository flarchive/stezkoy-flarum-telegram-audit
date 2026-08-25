<?php

namespace Stezkoy\FlarumTelegramAudit\Listeners;

use Flarum\Http\UrlGenerator;
use Flarum\Locale\Translator;
use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\Event\Saving;
use Stezkoy\FlarumTelegramAudit\TelegramNotifier;

class UserSuspended
{
    public function __construct(
        private readonly TelegramNotifier $notifier,
        private readonly Translator $translator,
        private readonly SettingsRepositoryInterface $settings,
        private readonly UrlGenerator $url,
    ) {}

    public function handle(Saving $event): void
    {
        $user = $event->user;
        $was = $user->getOriginal('suspended_until');
        $now = $user->suspended_until;

        $wasSuspension = $was !== null && $was !== '';
        $isSuspension = $now !== null && $now !== '';

        if ($wasSuspension === $isSuspension) {
            return;
        }

        if ($isSuspension && in_array($this->settings->get('stezkoy-telegram-audit.notify_on_user_suspended'), [true, '1', 1], true)) {
            $message = $this->translator->trans('stezkoy-telegram-audit.messages.user_suspended', [
                '{username}' => $user->display_name,
                '{profile_url}' => $this->url->to('forum')->route('user', ['username' => $user->username]),
            ]);

            $this->notifier->dispatch($message);
        }

        if (!$isSuspension && in_array($this->settings->get('stezkoy-telegram-audit.notify_on_user_unsuspended'), [true, '1', 1], true)) {
            $message = $this->translator->trans('stezkoy-telegram-audit.messages.user_unsuspended', [
                '{username}' => $user->display_name,
                '{profile_url}' => $this->url->to('forum')->route('user', ['username' => $user->username]),
            ]);

            $this->notifier->dispatch($message);
        }
    }
}
