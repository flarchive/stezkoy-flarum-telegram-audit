<?php

use Flarum\Discussion\Event\Deleted as DiscussionDeletedEvent;
use Flarum\Discussion\Event\Hidden;
use Flarum\Discussion\Event\Renamed;
use Flarum\Discussion\Event\Restored;
use Flarum\Extend;
use Flarum\Flags\Event\Created as FlagCreated;
use Flarum\Flags\Event\Deleting as FlagDeleting;
use Flarum\User\Event\Activated;
use Flarum\User\Event\Deleted as UserDeleted;
use Flarum\User\Event\Registered;
use Flarum\User\Event\Saving;
use Stezkoy\FlarumTelegramAudit\Api\TestMessageController;
use Stezkoy\FlarumTelegramAudit\Listeners\DiscussionDeleted;
use Stezkoy\FlarumTelegramAudit\Listeners\DiscussionFlagged;
use Stezkoy\FlarumTelegramAudit\Listeners\DiscussionLocked;
use Stezkoy\FlarumTelegramAudit\Listeners\DiscussionRenamed;
use Stezkoy\FlarumTelegramAudit\Listeners\DiscussionUnlocked;
use Stezkoy\FlarumTelegramAudit\Listeners\EmailConfirmed;
use Stezkoy\FlarumTelegramAudit\Listeners\FlagDeleted as FlagDeletedListener;
use Stezkoy\FlarumTelegramAudit\Listeners\UserDeleted as UserDeletedListener;
use Stezkoy\FlarumTelegramAudit\Listeners\UserGdprErased;
use Stezkoy\FlarumTelegramAudit\Listeners\UserRegistered;
use Stezkoy\FlarumTelegramAudit\Listeners\UserSuspended;
use Stezkoy\FlarumTelegramAudit\TelegramServiceProvider;

return [
    new Extend\ServiceProvider(TelegramServiceProvider::class),

    (new Extend\Event())
        ->listen(Registered::class, UserRegistered::class)
        ->listen(Activated::class, EmailConfirmed::class)
        ->listen(FlagCreated::class, DiscussionFlagged::class)
        ->listen(FlagDeleting::class, FlagDeletedListener::class)
        ->listen(Saving::class, UserSuspended::class)
        ->listen(UserDeleted::class, UserDeletedListener::class)
        ->listen(DiscussionDeletedEvent::class, DiscussionDeleted::class)
        ->listen(Renamed::class, DiscussionRenamed::class)
        ->listen(Hidden::class, DiscussionLocked::class)
        ->listen(Restored::class, DiscussionUnlocked::class)
        ->listen('Flarum\Gdpr\Events\Erased', UserGdprErased::class),

    (new Extend\Routes('api'))
        ->post('/telegram-audit/test', 'stezkoy-telegram-audit.test', TestMessageController::class),

    (new Extend\Frontend('admin'))
        ->js(__DIR__ . '/js/dist/admin.js')
        ->css(__DIR__ . '/less/admin.less'),

    (new Extend\Settings())
        ->default('stezkoy-telegram-audit.notify_on_register', '')
        ->default('stezkoy-telegram-audit.notify_on_email_confirmed', '')
        ->default('stezkoy-telegram-audit.notify_on_user_suspended', '')
        ->default('stezkoy-telegram-audit.notify_on_user_unsuspended', '')
        ->default('stezkoy-telegram-audit.notify_on_user_deleted', '')
        ->default('stezkoy-telegram-audit.notify_on_user_gdpr_erased', '')
        ->default('stezkoy-telegram-audit.notify_on_flag', '')
        ->default('stezkoy-telegram-audit.notify_on_flag_deleted', '')
        ->default('stezkoy-telegram-audit.notify_on_discussion_renamed', '')
        ->default('stezkoy-telegram-audit.notify_on_discussion_locked', '')
        ->default('stezkoy-telegram-audit.notify_on_discussion_unlocked', '')
        ->default('stezkoy-telegram-audit.notify_on_discussion_deleted', ''),

    new Extend\Locales(__DIR__ . '/locale'),
];
