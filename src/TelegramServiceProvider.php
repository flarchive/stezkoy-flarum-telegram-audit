<?php

namespace Stezkoy\FlarumTelegramAudit;

use Flarum\Foundation\AbstractServiceProvider;

class TelegramServiceProvider extends AbstractServiceProvider
{
    public function register(): void
    {
        $this->container->singleton(TelegramNotifier::class);
    }
}
