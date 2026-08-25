<?php

namespace Stezkoy\FlarumTelegramAudit\Listeners;

use Flarum\Discussion\Event\Renamed;
use Flarum\Http\UrlGenerator;
use Flarum\Locale\Translator;
use Flarum\Settings\SettingsRepositoryInterface;
use Stezkoy\FlarumTelegramAudit\TelegramNotifier;

class DiscussionRenamed
{
    public function __construct(
        private readonly TelegramNotifier $notifier,
        private readonly Translator $translator,
        private readonly SettingsRepositoryInterface $settings,
        private readonly UrlGenerator $url,
    ) {}

    public function handle(Renamed $event): void
    {
        if (!in_array($this->settings->get('stezkoy-telegram-audit.notify_on_discussion_renamed'), [true, '1', 1], true)) {
            return;
        }

        $discussion = $event->discussion;

        $message = $this->translator->trans('stezkoy-telegram-audit.messages.discussion_renamed', [
            '{old_title}' => $event->oldTitle,
            '{new_title}' => $discussion->title,
            '{discussion_url}' => $this->url->to('forum')->route('discussion', ['id' => $discussion->id]),
        ]);

        $this->notifier->dispatch($message);
    }
}
