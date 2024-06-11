# Utilisez une image de base contenant Apache et PHP
FROM php:8.3-apache

# Définition du répertoire de travail
WORKDIR /var/www/html

COPY . .

RUN a2enmod rewrite

EXPOSE 80

# Commande pour démarrer Apache en mode démon
CMD ["apache2-foreground"]
