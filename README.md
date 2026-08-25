# Telegram Audit for Flarum

![Flarum](https://img.shields.io/badge/Flarum-%5E2.0-26A5E4)
![PHP](https://img.shields.io/badge/PHP-%5E8.3-777BB4)
![License](https://img.shields.io/badge/license-MIT-green)
[![Latest Stable Version](https://img.shields.io/packagist/v/stezkoy/flarum-telegram-audit.svg)](https://packagist.org/packages/stezkoy/flarum-telegram-audit)
[![Total Downloads](https://img.shields.io/packagist/dt/stezkoy/flarum-telegram-audit.svg)](https://packagist.org/packages/stezkoy/flarum-telegram-naudit)

[Русская версия](README_RU.md)

Sends Telegram notifications about moderation and audit events on your Flarum forum.

## Features

- New user registration and email confirmation
- User suspended / unsuspended / deleted
- GDPR erasure (requires [flarum/gdpr](https://github.com/flarum/gdpr))
- Discussion hidden / restored / permanently deleted / renamed
- Discussion flagged (requires [flarum/flags](https://github.com/flarum/flags))
- Flag dismissed
- Per-event toggle switches
- Topic mode for forum-style Telegram groups
- Proxy support

## Installation

```bash
composer require stezkoy/flarum-telegram-audit
php flarum cache:clear
```

## Requirements

- PHP ^8.3
- Flarum ^2.0
- [flarum/flags](https://github.com/flarum/flags) ^2.0

## Setup

Create a bot via [@BotFather](https://t.me/BotFather), add it as admin to your group/channel, then open **Admin → Extensions → Telegram Audit** and configure the connection and notification toggles.

## License

MIT · [Stezkoy](https://github.com/Stezkoy)
