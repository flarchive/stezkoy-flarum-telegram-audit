# Telegram Audit для Flarum

![Flarum](https://img.shields.io/badge/Flarum-%5E2.0-26A5E4)
![PHP](https://img.shields.io/badge/PHP-%5E8.3-777BB4)
![License](https://img.shields.io/badge/license-MIT-green)
[![Latest Stable Version](https://img.shields.io/packagist/v/stezkoy/flarum-telegram-audit.svg)](https://packagist.org/packages/stezkoy/flarum-telegram-audit)
[![Total Downloads](https://img.shields.io/packagist/dt/stezkoy/flarum-telegram-audit.svg)](https://packagist.org/packages/stezkoy/flarum-telegram-naudit)

[English version](README.md)

Отправляет уведомления в Telegram о событиях модерации на форуме Flarum.

## Возможности

- Регистрация новых пользователей и подтверждение email
- Блокировка / разблокировка / удаление пользователей
- GDPR-удаление (требуется [flarum/gdpr](https://github.com/flarum/gdpr))
- Скрытие / восстановление / полное удаление / переименование тем
- Жалобы на темы (требуется [flarum/flags](https://github.com/flarum/flags))
- Снятие жалоб
- Переключатели для каждого типа событий
- Топики в группах Telegram в стиле форума
- Поддержка прокси

## Установка

```bash
composer require stezkoy/flarum-telegram-audit
php flarum cache:clear
```

## Требования

- PHP ^8.3
- Flarum ^2.0
- [flarum/flags](https://github.com/flarum/flags) ^2.0

## Настройка

Создайте бота через [@BotFather](https://t.me/BotFather), добавьте его администратором в группу/канал, затем откройте **Админ → Расширения → Telegram Audit** и настройте подключение и переключатели уведомлений.

## Лицензия

MIT · [Stezkoy](https://github.com/Stezkoy)
