#!/bin/bash
# 1) Elimina la página por defecto que vuelve a crearse
rm -f /home/site/wwwroot/hostingstart.html
rm -f /home/site/wwwroot/hostingstart.html.bk

# 2) Copia tu nginx-default apuntando a public/
cp /home/site/wwwroot/nginx-default /etc/nginx/sites-available/default
cp /home/site/wwwroot/nginx-default /etc/nginx/sites-enabled/default

# 3) Recarga nginx
service nginx reload
