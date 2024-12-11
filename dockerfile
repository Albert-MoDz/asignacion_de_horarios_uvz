# Usa la imagen base de PHP con Apache
FROM php:7.4-apache

# Instalar dependencias necesarias para compilar extensiones de PHP
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install \
    mysqli \
    intl \
    mbstring \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Configurar el DocumentRoot en Apache (opcional)
ENV APACHE_DOCUMENT_ROOT /var/www/html

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# Habilitar el módulo de reescritura en Apache (si es necesario)
RUN a2enmod rewrite

# Copiar los archivos del proyecto al contenedor
COPY . /var/www/html

# Asignar permisos para que Apache pueda acceder a los archivos
RUN chown -R www-data:www-data /var/www/html

# Exponer el puerto 80
EXPOSE 80

# Comando para iniciar Apache
CMD ["apache2-foreground"]
