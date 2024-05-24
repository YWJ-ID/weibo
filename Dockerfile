FROM webdevops/php-nginx:8.2-alpine

ENV WEB_DOCUMENT_ROOT /data/webroot/public

COPY . ./data/webroot

WORKDIR /data/webroot

RUN composer install --no-interaction --optimize-autoloader \
    # 跑完测试后剔除dev依赖包
    && composer install --no-interaction --optimize-autoloader --no-dev \
    # 更改当前文件夹下所有者
    && chown -R application:application . \
    # 容器启动运行应用脚本 \
    && echo "php /data/webroot/artisan migrate --force" >> /opt/docker/provision/entrypoint.d/app.sh \
    && echo "php /data/webroot/artisan config:cache" >> /opt/docker/provision/entrypoint.d/app.sh \
    && echo "php /data/webroot/artisan route:cache" >> /opt/docker/provision/entrypoint.d/app.sh
