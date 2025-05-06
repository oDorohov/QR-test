<p align="center">
    <h1 align="center">Сервис коротких ссылок на Yii2</h1>
</p>

Простой и быстрый сервис коротких ссылок, разработанный на фреймворке [Yii2](https://www.yiiframework.com/).  
Поддерживает генерацию QR-кодов и ведёт статистику переходов.

## Возможности

- Генерация коротких ссылок
- Создание QR-кодов для ссылок
- Учёт переходов по коротким URL
- Веб-интерфейс для просмотра и управления

## Требования

- PHP 7.4 или выше
- MySQL
- Composer

## Установка

1. **Клонируйте репозиторий:**

```bash
git clone https://github.com/oDorohov/QR-test
cd QR-test
```

2. **Установите зависимости:**

```bash
composer create-project --repository='{"type":"vcs", "url":"https://github.com/oDorohov/QR-test"}' odorohov/qr-test my-app --stability=dev
```

3. **Создайте базу данных** и настройте подключение в `config/db.php`:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=short_links',
    'username' => 'root',
    'password' => 'ваш_пароль',
    'charset' => 'utf8',
];
```

4. **Примените миграции:**

```bash
php yii migrate
```

5. **Настройте ключ валидации cookies в `config/web.php`:**

```php
'request' => [
    'cookieValidationKey' => 'вставьте_секретный_ключ_сюда',
],
```

6. **Запустите встроенный сервер Yii2 (для разработки):**

```bash
php yii serve
```

Откройте в браузере:

```
http://localhost:8080
```

## Примеры

- Короткая ссылка: `http://localhost:8080/redirect?code=1Q1ZKh`
- QR-код доступен при создании ссылки и отображается на веб-странице
- Статистика просмотров доступна в админке

## Используемые библиотеки

- [yii2](https://github.com/yiisoft/yii2)
- [Endroid/qr-code](https://github.com/endroid/qr-code) — генерация QR-кодов

## Скриншоты

*(Добавь сюда изображения интерфейса при желании)*

## Лицензия

MIT