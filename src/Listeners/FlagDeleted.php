<?php

namespace Stezkoy\FlarumTelegramAudit\Listeners;

use Flarum\Flags\Event\Deleting;
use Flarum\Http\UrlGenerator;
use Flarum\Locale\Translator;
use Flarum\Settings\SettingsRepositoryInterface;
use Stezkoy\FlarumTelegramAudit\TelegramNotifier;

class FlagDeleted
{
    public function __construct(
        private readonly TelegramNotifier $notifier,
        private readonly Translator $translator,
        private readonly SettingsRepositoryInterface $settings,
        private readonly UrlGenerator $url,
    ) {}

    public function handle(Deleting $event): void
    {
        if (!in_array($this->settings->get('stezkoy-telegram-audit.notify_on_flag_deleted'), [true, '1', 1], true)) {
            return;
        }

        $flag = $event->flag;
        $post = $flag->post;
        $discussion = $post->discussion;

        $message = $this->translator->trans('stezkoy-telegram-audit.messages.flag_deleted', [
            '{discussion_title}' => $discussion->title,
            '{discussion_url}' => $this->url->to('forum')->route('discussion', ['id' => $discussion->id]),
        ]);

        $this->notifier->dispatch($message);
    }
}
