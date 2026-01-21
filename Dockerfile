FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html
COPY . /var/www/html

# Habilitar módulos necesarios
RUN a2enmod rewrite
RUN a2enmod headers

# Configurar permisos
RUN chmod 755 /var/www/html
RUN find /var/www/html -type d -exec chmod 755 {} \;
RUN find /var/www/html -type f -exec chmod 644 {} \;

# Configurar Apache DocumentRoot a app/
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/app|g' /etc/apache2/sites-available/000-default.conf

# Configurar Directory para app/
RUN sed -i 's|<Directory /var/www/>|<Directory /var/www/html/>|g' /etc/apache2/apache2.conf

# Permitir .htaccess
RUN sed -i '/<Directory \/var\/www\/html>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf

EXPOSE 80
CMD ["apache2-foreground"]
