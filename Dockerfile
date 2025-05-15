# Usa PHP con Apache
FROM php:8.2-apache

# Instala extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Copia el proyecto al contenedor
COPY . /var/www/html

# Ajusta permisos
RUN chown -R www-data:www-data /var/www/html

# Expone el puerto 80
EXPOSE 80
