# Telegram Audit

![Flarum](https://img.shields.io/badge/Flarum-%5E2.0-26A5E4)
![PHP](https://img.shields.io/badge/PHP-%5E8.3-777BB4)
![License](https://img.shields.io/badge/license-MIT-green)
[![Latest Stable Version](https://img.shields.io/packagist/v/stezkoy/flarum-telegram-audit.svg)](https://packagist.org/packages/stezkoy/flarum-telegram-audit)
[![Total Downloads](https://img.shields.io/packagist/dt/stezkoy/flarum-telegram-audit.svg)](https://packagist.org/packages/stezkoy/flarum-telegram-audit)

[Русская версия](README_RU.md)

Sends Telegram notifications about moderation and audit events on your Flarum forum: new users, email confirmations, and discussion flags.

## Features

- New user registration notifications
- Email confirmation notifications
- Discussion flag (report) notifications
- Per-event toggle switches
- Topics in forum-style groups (optional)
- Proxy support

## Installation

```bash
composer require stezkoy/flarum-telegram-audit
php flarum cache:clear
```

## Setup

1. Create a bot via [@BotFather](https://t.me/BotFather) and copy the token
2. Add the bot to your group or channel as an administrator
3. Open **Admin → Extensions → Telegram Audit** and configure:

### Connection

| Setting        | Description                                        |
| -------------- | -------------------------------------------------- |
| Bot token      | Token from @BotFather                              |
| Chat ID        | `-1001234567890` for groups/channels, `@username` for public channels |
| Proxy          | Optional toggle — if `api.telegram.org` is unreachable from your server |
| Topic switch   | Enable to send messages into a specific group topic |

### Notifications

| Toggle                    | Description                                      |
| ------------------------- | ------------------------------------------------ |
| New user registration     | Notify when a new user creates an account        |
| Email confirmed           | Notify when a user confirms their email address  |
| Discussion flagged        | Notify when a discussion receives a flag (report) |

Messages are sent through the Flarum queue: with the default `sync` driver they go out immediately, with the `database` driver — in the background.

## Notification formats

| Event              | Message example                                           |
| ------------------ | --------------------------------------------------------- |
| New user           | `New user: <a href="...">Username</a>\nEmail: user@example.com` |
| Email confirmed    | `Email confirmed: <a href="...">Username</a>\nEmail: user@example.com` |
| Discussion flagged | `Discussion flagged: <a href="...">Discussion title</a>`  |

Messages support Telegram HTML formatting.

## Enable / disable via terminal

```bash
# enable
php flarum extension:enable stezkoy-telegram-audit

# disable
php flarum extension:disable stezkoy-telegram-audit

# apply changes
php flarum cache:clear
```

## Requirements

- PHP ^8.3
- Flarum ^2.0
- flarum/flags ^2.0

## Development

Rebuild the admin panel JavaScript after changes:

```bash
cd js && pnpm install && pnpm run build
```

## Author

**Stezkoy** · MIT License
