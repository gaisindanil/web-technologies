FROM nginx:1.21-alpine

COPY ./docker/production/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf

WORKDIR /app

COPY ./public ./public

#HEALTHCHECK --interval=5s --timeout=3s --start-period=1s CMD curl --fail http://127.0.0.1/health || exit 1
