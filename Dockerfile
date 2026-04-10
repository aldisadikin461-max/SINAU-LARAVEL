# ── Stage 1: Node.js — build Vite assets ──────────────────────────
FROM node:20-alpine AS node-builder

WORKDIR /app

COPY package.json ./
RUN npm install

COPY . .
RUN npm run build

# ── Stage 2: PHP — application runtime ────────────────────────────
FROM php:8.3-cli

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# Copy pre-built Vite assets from the Node stage
COPY --from=node-builder /app/public/build ./public/build

RUN composer install --optimize-autoloader --no-scripts --no-interaction

EXPOSE 8000

CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]