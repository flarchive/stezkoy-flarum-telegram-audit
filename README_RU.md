# Telegram Audit

![Flarum](https://img.shields.io/badge/Flarum-%5E2.0-26A5E4)
![PHP](https://img.shields.io/badge/PHP-%5E8.3-777BB4)
![License](https://img.shields.io/badge/license-MIT-green)
[![Latest Stable Version](https://img.shields.io/packagist/v/stezkoy/flarum-telegram-audit.svg)](https://packagist.org/packages/stezkoy/flarum-telegram-audit)
[![Total Downloads](https://img.shields.io/packagist/dt/stezkoy/flarum-telegram-audit.svg)](https://packagist.org/packages/stezkoy/flarum-telegram-audit)

[English version](README.md)

Отправляет уведомления в Telegram о событиях модерации на форуме Flarum: новые пользователи, подтверждение email, жалобы на темы.

## Возможности

- Уведомления о регистрации новых пользователей
- Уведомления о подтверждении email
- Уведомления о жалобах на темы (flarum/flags)
- Переключатели для каждого типа событий
- Топики в группах с форумами (опционально)
- Поддержка прокси

## Установка

```bash
composer require stezkoy/flarum-telegram-audit
php flarum cache:clear
```

## Настройка

1. Создайте бота через [@BotFather](https://t.me/BotFather) и скопируйте токен
2. Добавьте бота администратором в вашу группу или канал
3. Откройте **Админ → Расширения → Telegram Audit** и настройте:

### Подключение

| Параметр      | Описание                                                        |
| ------------- | --------------------------------------------------------------- |
| Токен бота    | Токен от @BotFather                                             |
| ID чата       | `-1001234567890` для групп/каналов, `@username` для публичных   |
| Прокси        | Необязательный переключатель — если `api.telegram.org` недоступен с сервера |
| Режим топиков | Включите, чтобы отправлять сообщения в конкретный топик |

### Уведомления

| Переключатель              | Описание                                              |
| -------------------------- | ----------------------------------------------------- |
| Регистрация нового пользователя | Уведомлять о создании нового аккаунта            |
| Подтверждение email        | Уведомлять, когда пользователь подтверждает email     |
| Жалоба на тему             | Уведомлять, когда на тему поступает жалоба            |

Отправка идёт через очередь Flarum: с драйвером по умолчанию `sync` сообщения уходят сразу, с драйвером `database` — в фоне.

## Формат уведомлений

| Событие            | Пример сообщения                                               |
| ------------------ | -------------------------------------------------------------- |
| Новый пользователь | `Новый пользователь: <a href="...">Имя</a>\nEmail: user@example.com` |
| Email подтверждён   | `Email подтверждён: <a href="...">Имя</a>\nEmail: user@example.com` |
| Жалоба на тему     | `Жалоба на тему: <a href="...">Название темы</a>`              |

Сообщения поддерживают HTML-форматирование Telegram.

## Включение / отключение через терминал

```bash
# включить
php flarum extension:enable stezkoy-telegram-audit

# выключить
php flarum extension:disable stezkoy-telegram-audit

# применить изменения
php flarum cache:clear
```

## Требования

- PHP ^8.3
- Flarum ^2.0
- flarum/flags ^2.0

## Разработка

Пересоберите JavaScript админ-панели после изменений:

```bash
cd js && pnpm install && pnpm run build
```

## Автор

**Stezkoy** · Лицензия MIT
