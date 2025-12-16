FROM node:18-alpine AS builder
WORKDIR /app
COPY package.json yarn.lock ./
RUN yarn install --frozen-lockfile
COPY . .
RUN yarn build

FROM nginx:alpine
# Nginx берёт файлы из dist
COPY --from=builder /app/dist /usr/share/nginx/html

# Если хотите менять конфиг Nginx (опционально)
# COPY nginx.conf /etc/nginx/conf.d/default.conf