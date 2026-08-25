<?php

namespace Stezkoy\FlarumTelegramAudit\Listeners;

use Flarum\Discussion\Event\Deleted;
use Flarum\Http\UrlGenerator;
use Flarum\Locale\Translator;
use Flarum\Settings\SettingsRepositoryInterface;
use Stezkoy\FlarumTelegramAudit\TelegramNotifier;

class DiscussionDeleted
{
    public function __construct(
        private readonly TelegramNotifier $notifier,
        private readonly Translator $translator,
        private readonly SettingsRepositoryInterface $settings,
        private readonly UrlGenerator $url,
    ) {}

    public function handle(Deleted $event): void
    {
        if (!in_array($this->settings->get('stezkoy-telegram-audit.notify_on_discussion_deleted'), [true, '1', 1], true)) {
            return;
        }

        $discussion = $event->discussion;

        $message = $this->translator->trans('stezkoy-telegram-audit.messages.discussion_permanently_deleted', [
            '{discussion_title}' => $discussion->title,
        ]);

        $this->notifier->dispatch($message);
    }
}
