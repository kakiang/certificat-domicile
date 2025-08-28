# ---- Stage 1: build frontend assets (Vite/Tailwind) ----
FROM node:20-alpine AS assets
WORKDIR /app

# Install JS deps
COPY package*.json ./
RUN npm ci

# install puppeteer here
RUN npm install puppeteer --save

# Copy only what Vite needs (adjust if you import elsewhere)
COPY vite.config.* ./
COPY tailwind.config.* postcss.config.* ./
COPY resources/ resources/
# If you reference other frontend files (e.g., in public/), copy them too.

# Build production assets -> public/build
RUN npm run build

# ---- Stage 2: runtime (Nginx + PHP-FPM in one image) ----
FROM richarvey/nginx-php-fpm:latest

# Install Node.js + Chromium on Alpine
RUN apk add --no-cache \
    nodejs \
    npm \
    chromium \
    nss \
    freetype \
    harfbuzz \
    ca-certificates \
    ttf-freefont

# App files
WORKDIR /var/www/html
COPY . .
# Bring in compiled Vite assets
COPY --from=assets /app/public/build ./public/build
# Copy node_modules (contains puppeteer)
COPY --from=assets /app/node_modules ./node_modules

# Image/env config (Render pattern)
ENV WEBROOT=/var/www/html/public \
    PHP_ERRORS_STDERR=1 \
    RUN_SCRIPTS=1 \
    REAL_IP_HEADER=1 \
    APP_ENV=production \
    APP_DEBUG=false \
    LOG_CHANNEL=stderr \
    COMPOSER_ALLOW_SUPERUSER=1 \
    BROWSERSHOT_NODE_BINARY=/usr/bin/node \
    BROWSERSHOT_CHROME_PATH=/usr/bin/chromium

# Nginx site
COPY conf/nginx/nginx-site.conf /etc/nginx/sites-enabled/default

# Permissions for caches
RUN chown -R www-data:www-data storage bootstrap/cache \
    && mkdir -p /home/www-data/.cache/puppeteer \
    && chown -R www-data:www-data /home/www-data

# Start Nginx + PHP-FPM via base image init
CMD ["/start.sh"]
