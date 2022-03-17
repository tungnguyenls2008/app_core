FROM thangnv1995/base-php:v1.0.0

# # Clear cache
# RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www

# Add user for laravel application
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Copy code to /var/www
COPY --chown=www:www-data . /var/www

# Copy nginx/php/supervisor configs
RUN cp docker/supervisor.conf /etc/supervisord.conf
RUN cp docker/php.ini /usr/local/etc/php/conf.d/app.ini
RUN cp docker/nginx.conf /etc/nginx/sites-enabled/default
RUN cp docker/favicon.ico /favicon.ico

# PHP Error Log Files
RUN mkdir /var/log/php
RUN touch /var/log/php/errors.log && chmod 777 /var/log/php/errors.log

# Deployment steps
RUN composer install --optimize-autoloader --no-dev
RUN chmod +x /var/www/docker/run.sh

# #run scrip
RUN npm install
# RUN npm audit fix --force
RUN npm run dev


EXPOSE 80
ENTRYPOINT ["/var/www/docker/run.sh"]