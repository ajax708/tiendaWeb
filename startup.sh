#!/bin/bash
# Copia tu config personalizada sobre la que usa nginx por defecto
cp /home/site/nginx-default /etc/nginx/sites-available/default
cp /home/site/nginx-default /etc/nginx/sites-enabled/default

# Recarga nginx para aplicar los cambios
service nginx reload
