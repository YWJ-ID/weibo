FROM webdevops/php-nginx:8.2-alpine

ENV WEB_DOCUMENT_ROOT /data/webroot/public

COPY . ./data/webroot

WORKDIR /data/webroot

RUN composer install --no-interaction --optimize-autoloader \
    # passport密钥生成
    && php artisan passport:keys --force \
    # 运行测试
    && php artisan test --teamcity \
    # 跑完测试后剔除dev依赖包
    && composer install --no-interaction --optimize-autoloader --no-dev \
    # 更改当前文件夹下所有者
    && chown -R application:application . \
    # cron配置项
    && echo "* * * * * php /data/webroot/artisan schedule:run >> /dev/null 2>&1" >> /var/spool/cron/crontabs/root \
    # 容器启动运行应用脚本 \
    && echo "php /data/webroot/artisan migrate --force" >> /opt/docker/provision/entrypoint.d/app.sh \
    && echo "php /data/webroot/artisan db:seed --class=PermissionSeeder" >> /opt/docker/provision/entrypoint.d/app.sh \
    && echo "php /data/webroot/artisan config:cache" >> /opt/docker/provision/entrypoint.d/app.sh \
    && echo "php /data/webroot/artisan route:cache" >> /opt/docker/provision/entrypoint.d/app.sh
