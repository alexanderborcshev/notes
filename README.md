Краткая инструкция по запуску и проверке проекта (бекенд Laravel + SPA на Vue 3).

### Требования
- Docker + Docker Compose
- Node.js + npm (для фронтенда / Vite)
- PHP ≥ 8.4 (для локального запуска тестов)

### Быстрый старт (Docker)
1. Установить npm-зависимости (один раз):
   ```bash
   cd frontend
   npm install
   npm run build
   ```
2. Поднять контейнеры (Laravel + Postgres + Nginx + PHP-FPM):
   ```bash
   docker compose up -d
   ```
3. Выполнить миграции и сиды внутри php-контейнера:
   ```bash
   docker compose exec notes-app php artisan migrate
   ```
   ```
4. Открыть приложение в браузере на домене/порту, настроенном в docker/nginx (по умолчанию http://localhost:8080).
