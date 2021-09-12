# Aplicación

[TOC]

## Instalación (Basado en Ubuntu 20.04)

### Preparación

Actualizar librerias y dependencias del sistema operativo

```bash
sudo apt update
sudo apt upgrade
```



### Instalación de docker y docker-compose

Es necesario docker y docker-compose para el despliegue de la base de datos asociada a la aplicación.

#### Instalación de docker engine

Docker docs [[1]](https://docs.docker.com/engine/install/ubuntu/#install-using-the-convenience-script) ofrece la descarga de un `conenienve script` para la instalación del motor de contenedores

```
curl -fsSL https://get.docker.com -o get-docker.sh
sudo sh get-docker.sh
```

#### Agregar al usuario al grupo de usuario de docker

```bash
#la instrucción $(whoami) devuelve el usuario activo, puede reemplazarse directamente con el nombre de usuario
sudo usermod -aG docker $(whoami)
```

#### Instalación de docker-compose

Docker-compose es utilizado para el despliegue de contenedores de forma sencilla, desde un único archivo de configuración, en ésta aplicación, el archivo se encuentra en el directorio `docker` y despliega la base de datos y la aplicación web "phpMyAdmin" para la gestión de la base de datos

```bash
sudo curl -L "https://github.com/docker/compose/releases/download/1.29.2/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose
sudo chmod +x /usr/local/bin/docker-compose
```

### Instalación de las librerias php

La aplicación está desarrollada en base al framework Laravel, escrito en lenguaje php. Para su correcta ejecución es necesaria la instalación de librerias requeridas por la aplicación.

```bash
sudo apt install php-fpm php-curl php-gd php-dev php-zip php-mbstring php-mysql php-xml
```

### Instalación de gestor de paquetes Composer

La aplicación usa el gestor de paquetes Composer, para las dependencias usadas en el backend de la aplicación, por tanto, su instalación es requerida

```bash
wget -O composer-setup.php https://getcomposer.org/installer
sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
```

#### Comprobar la instalación (opcional)

Se puede comprobar la instalación de composer ejecutando la instrucción a continuación

```bash
composer --version
```

### Instalación del gestor de paquetes NPM

Para la capa de presentación de la aplicación, se usan dependencias de nodejs, instaladas mediante el gestor de dependencias npm, su instalación es mandatoria

```bash
wget https://nodejs.org/dist/v14.17.6/node-v14.17.6-linux-x64.tar.xz
tar xf node-v14.17.6-linux-x64.tar.xz
sudo cp -r node-v14.17.6-linux-x64/* /usr/local/
```

#### Comprobar la instalación (opcional)

Se puede comprobar la instalación de composer ejecutando la instrucción a continuación

```bash
npm -v
```

### Instalación de  paquetes de aplicación

Usando los gestores de paquetes instalados, se procede con la instalación de dependencias usadas en la aplicación

```bash
composer install
npm install
```

## Configuración de ambiente de la aplicación

### Configuración de la base de datos

En el archivo `docker-compose.yml` ubicado en la carpeta `docker` se encuentra la configuración de la base de datos a desplegar en forma de contenedor. Es necesario configurar la contraseña, usuario, nombre de la base de datos y la contraseña del usuario root para su correcto despliegue. Por defecto se encuentran las credenciales básicas usadas en la demostración de la aplicación.

```yaml
environment:
            MYSQL_ROOT_PASSWORD: <contraseña_usuario_root>
            MYSQL_DATABASE: <nombre_de_la_base_de_datos>
            MYSQL_USER: <nombre_de_usuario>
            MYSQL_PASSWORD: <contraseña>
```

### Configuración del archivo de ambiente

Las principales configuraciones de la aplicación se almacenan en el archivo ambiente `.env` , es necesaria su correcta configuración

#### Configuración de aplicación

En el archivo ambiente, existen las variables de ambientes asociadas a la configuración de la aplicación

```bash
APP_NAME=<nombre_de_la_aplicacion>
#Ambiente donde se despliega la aplicacion
APP_ENV=local
#Clave de encriptación de la aplicación, se configura más adelante
APP_KEY=<clave>
#Bandera de verbose
APP_DEBUG=<true|false>
APP_URL=<url_aplicacion>
```

#### Configuración de la base de datos

Configuraciones que se deben hacer para conectar con la base de datos

```bash	
#Driver de base de datos (mantener en mysql para el contenedor a desplegar)
DB_CONNECTION=mysql
#Url de la base de datos (si se expone la base de datos entonces localhost, sino, configurar)
DB_HOST=<url_base_de_datos>
DB_PORT=<puerto_db>
DB_DATABASE=<base_de_datos_a_modificar>
DB_USERNAME=<usuario>
DB_PASSWORD=<contraseña>
```

#### Configuración de servicios en segundo plano

La aplicación provee de servicios en segundo plano que se ejecutan para comprobar el estado de los videos y para realizar la ingesta de los videos.

```bash
BROADCAST_DRIVER=log
#caché de la aplicación, se puede usar redis como caché rápido
CACHE_DRIVER=file
#sistema de archivos utilizado por el storage (local por defecto)
FILESYSTEM_DRIVER=local
#sistema de colas utilizado, en este caso, se usa la base de datos para la gestión de trabajos en cola
QUEUE_CONNECTION=database
SESSION_DRIVER=file
SESSION_LIFETIME=120
```

#### Configuración del Opencast Backend

La aplicación utiliza Opencast como servicio de almacenamiento y distribución de videos, por lo cual, es necesario configurar las variables de ambiente asociadas.

```bash
#url del servicio
OPENCAST_URL="https://opencast.europa.lan"
#usuario externo
OPENCAST_USER="opencast_api"
#contraseña del usuario externo
OPENCAST_PASSWORD="api_password"
#rol del usuario (al generar el usuario, se crea un rol del tipo ROLE_<username>)
OPENCAST_ROLE_USER="ROLE_USER_API_EXTERNA"
```

#### Modificación de directivas

La aplicación require la modificiación de las directivas php, en el archivo php.ini, de modo de permitir la ingesta de archivos. Por defecto, el servidor backend de Opencast acepta archivos de un tamaño máximo de 1GB, por lo cuál se configurará de la misma forma para la aplicación

```bash
upload_max_filesize=1024MB
post_max_size=0
```

## Preparación de la base de datos

### Despliegue de la base de datos

```bash
docker-compose up -d
```

### Configurar la base de datos en el archivo .env

```bash
#obtener la direccion del contenedor
docker inspect app_db
```

### Migrar esquemas de aplicación

```bash
#en el directorio raíz de la aplicación
php artisan migrate
```

#### (Opcional) Poblar con usuarios iniciales

Genera tres usuarios con los roles de la aplicación: administrador (admin@email.com), profesor (profesor@email.com) y estudiante (estudiante@email.com)

```bash
#en el directorio raíz de la aplicación
php artisan db:seed
```

## Preparación de la aplicación

### Generar la llave de seguridad de la aplicación

Generar la llave de seguridad de la aplicación

```bash
php artisan key:generate
```

## Despliegue de la aplicación

### Opción 1: Auto-host mediante servidor integrado

```
php artisan serve --host <direccion-ip-servidor> --port <puerto>
```

### Opción 2: Agregar al proxy reverso

//TODO
