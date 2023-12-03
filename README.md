## Что это?

Выполненное ТЗ на позицию Laravel-разработчика (housevl.ru). Его суть
заключалась в создании API магазина: с каталогом товаров, созданием заказов для анонимных и
авторизованных пользоватей и пр. (суммарно - свыше десятка эндпоинтов).

ТЗ можно почитать тут: https://docs.google.com/document/d/1BRLldrmxi_p8P7qJ4avUEkGMgJMDtgsy/edit?usp=drive_link&ouid=103092881824268936467&rtpof=true&sd=true

### Как запустить?

1. Запустить контейнеры через docker compose up;
2. Запустить start.sh - shell-скрипт, который запустит все миграции и сидеры.

### Используемые технологии

1. Laravel 10 (PHP 8.2);
2. Postgres;
3. Nginx;
4. Docker и Docker Compose (для развертывания);
5. PHPUnit;
6. Postman (для краткого документирования эндпоинтов);
7. XDebug (для локальной отладки кода приложения и тестов).

### Зависимости приложения

1. Laravel Modules (для организации модульного монолита);
2. Laravel Sanctum (для token-based авторизации);
3. Laravel Data (для имплементации DTO);
4. Eloquent Filter (для создания фильтров каталога);

### Зависимости разработки

1. Php Insights (стиль кода, архитектуры и т.д., проверяемые перед каждым коммитом);
2. Laravel Api To Postman (генерирование postman-коллекции на основе роутов приложения);
3. Branch Name Lint (чтобы названия веток соответствовали conventional commits; + ограничения при работе с ветками);
4. Husky (работа с pre-commit и другими хуками);

### Документация

Лежит в папке docs, и на данный момент содержит postman-коллекцию, полностью заполненную примерами тел запросов, хедеров и т.п.

### Тесты

Feature-тесты написаны под все имеющиеся эндпоинты. Однако unit-тесты были написаны лишь
для части классов.

Все они стандартно запускаются через php artisan test изнутри запущенного контейнера.
