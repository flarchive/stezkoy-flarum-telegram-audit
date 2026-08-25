<?php

namespace Stezkoy\FlarumTelegramAudit\Listeners;

use Flarum\Flags\Event\Created;
use Flarum\Http\UrlGenerator;
use Flarum\Locale\Translator;
use Flarum\Settings\SettingsRepositoryInterface;
use Stezkoy\FlarumTelegramAudit\TelegramNotifier;

class DiscussionFlagged
{
    public function __construct(
        private readonly TelegramNotifier $notifier,
        private readonly Translator $translator,
        private readonly SettingsRepositoryInterface $settings,
        private readonly UrlGenerator $url,
    ) {}

    public function handle(Created $event): void
    {
        if (!in_array($this->settings->get('stezkoy-telegram-audit.notify_on_flag'), [true, '1', 1], true)) {
            return;
        }

        $flag = $event->flag;
        $post = $flag->post;
        $discussion = $post->discussion;

        if ($post->number === 1) {
            $message = $this->translator->trans('stezkoy-telegram-audit.messages.discussion_flagged', [
                '{discussion_title}' => $discussion->title,
                '{discussion_url}' => $this->url->to('forum')->route('discussion', ['id' => $discussion->id, 'n' => $post->number]),
            ]);
        } else {
            $message = $this->translator->trans('stezkoy-telegram-audit.messages.reply_flagged', [
                '{discussion_title}' => $discussion->title,
                '{post_number}' => $post->number,
                '{post_url}' => $this->url->to('forum')->route('discussion', ['id' => $discussion->id, 'n' => $post->number]),
            ]);
        }

        $this->notifier->dispatch($message);
    }
}
