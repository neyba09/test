# Проект Laravel

## Стэк

- PHP >= 8.1
- Composer
- PostgreSQL
- RabbitMQ
- Docker & Docker Compose

---

## Установка

1. **Клонируем репозиторий**

```bash
git clone https://github.com/username/project.git

```
2. **Создаём файл окружения**

```bashcp 
.env.example .env

```
3.  **Создаём файл окружения**

```bash
cp .env.example .env

```
4. **Настройка .env для Docker Compose**

```bash
cp .env.example .env

```

5. **Запускаем контейнеры через Docker Compose**
```bash
docker-compose up -d

```

5. **Устанавливаем зависимости Composer (в контейнере app)**
```bash
composer install

```

5. **Генерация ключа приложения**
```bash
php artisan key:generate

```

## Миграции и сидеры

1. **Запуск миграций**
```bash
php artisan migrate
```

2. **Запуск сидеров**
```bash
php artisan db:seed

```
## Тестирование

1. **Запуск всех тестов**
```bash
php artisan test
```

## Очереди

1. **Запуск обработчика очередей**
```bash
php artisan queue:work
```

## Schedulers

1. **Запуск обработчика очередей**
```bash
php artisan schedule:run
```
