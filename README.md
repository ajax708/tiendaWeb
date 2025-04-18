<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>


# Instalación

Para ejecutar un proyecto de Laravel que has descargado de GitHub, sigue estos pasos:

## 1. Clonar el repositorio
Si aún no lo has hecho, clona el repositorio en tu máquina:

```bash
git clone https://github.com/usuario/repositorio.git
```
cd repositorio
## 2. Instalar dependencias con Composer
Ejecuta el siguiente comando para instalar las dependencias del proyecto:

```bash
composer install
```
## 3. Copiar el archivo de entorno (.env)
Si el proyecto no tiene un archivo .env, crea uno copiando el ejemplo:

```bash
cp .env.example .env
```

## 4. Configurar las variables de entorno
Edita el archivo .env y asegúrate de configurar correctamente la conexión a la base de datos:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nombre_de_tu_base
DB_USERNAME=usuario
DB_PASSWORD=contraseña
```
### 4.1. Crear las carpetas necesarias
Ejecuta los siguientes comandos en la raíz del proyecto para asegurarte de que las carpetas de almacenamiento existen:

```bash
mkdir -p storage/framework/cache
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
```
### 4.2. Asignar permisos correctos (Linux/macOS)
Si estás en Linux o macOS, asegúrate de que el servidor web tenga permisos de escritura:

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```
## 5. Generar la clave de la aplicación
Ejecuta el siguiente comando para generar la clave de aplicación de Laravel:

```bash
php artisan key:generate
```
## 6. Ejecutar migraciones y seeders (opcional)
Si el proyecto usa base de datos, ejecuta las migraciones para crear las tablas:

```bash
php artisan migrate --seed
```
## 7. Para mostrar las imagenes guardadas en el storage
Si guardaste las imágenes en storage/app/public, debes crear un enlace a public/storage:

```bash
php artisan storage:link
```
Si hay errores de permisos en MySQL, revisa los datos en .env.

## 8. Iniciar el servidor local de Laravel
Ejecuta el siguiente comando para iniciar el servidor de desarrollo:

```bash
php artisan serve
```
El proyecto estará disponible en: ```http://127.0.0.1:8000```🚀

# Extras:
Si el proyecto usa npm o Vite para frontend, instala las dependencias y compila los assets:

```bash
npm install
npm run dev
```
Si usas Docker, revisa si el proyecto tiene un docker-compose.yml y levántalo con:

```bash
docker-compose up -d
```
#   t i e n d a W e b  
 