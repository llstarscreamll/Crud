# CRUD Generator #

TODO: Update the readme file!!

CrudGenerator es un paquete de laravel para la generación de aplicaciones CRUD básicas a partir de una tabla de una base de datos, sevirá como un buen punto de partida para el gestor de una entidad o tabla en la base de datos.

## Instalación ##

Debes tener instalado PHP_CodeSniffer:

```bash
sudo pear install PHP_CodeSniffer
```

Clonar el repositorio donde se desee, para este ejemplo estando en el directorio raíz de la instalación de Laravel:

```bash
git clone git@github.com:llstarscreamll/CrudGenerator.git llstarscreamll/Crud
```

Añadir el service provider en `config/app.php`:

```php
'providers' => [
        App\Containers\Crud\Providers\CrudServiceProvider::class,
    ],
```

Ejecutar migraciones, publicar configuraciones, vistas, etc..

```bash
php artisan vendor:publish --provider="App\Containers\Crud\Providers\CrudServiceProvider" --force
php artisan migrate # para tablas de prueba
```

Prestar mucha atención a los archivos de configuración publicados en la carpeta `config/llstarscreamll/CrudGenerator`, dar valores a las variables que allí hay acorde a las necesidades.

## Clases/Archivos Generados: ##

Esta app genera los siguientes archivos, según la configuración deseada:

- Añade las respectivas rutas al fichero `routes/web.php`
- Controlador
- Modelo
- Contrato del repositiorio para el modelo
- Implementación del contrato del repositorio del modelo
- Search Criteria, para búsqueda de registros del repositorio generado
- Clase Servicio, la cual guarda la lógica de negocio de la app, es usada en el controlador
- Archivo de idioma español
- Vistas:
    - partials/
        - form-scripts
        - form-assets
        - heading
        - index-assets
        - index-buttons
        - form-fields
        - hidden-form-fields
        - index-create-form
        - index-table
        - index-table-header
        - index-table-search
        - index-table-body
    - index
    - create
    - show
    - edit
- Codeception Tests, cada uno con su pageObject y tag de grupo si así se desea:
    - Index, tiene algunos tests más de restairación de registros en papelera si es que se usa la columna `deleted_at` en la tabla de la base de datos
    - Create
    - Edit
    - Show
    - Destroy
    - Permissions

# Tests #

Las pruebas automatizadas están hechas con el Framework **Codeception**. El paquete no está incluido dentro de las dependencias del paquete en el archivo `composer.json`, así que Codeception se debe instalar globalmente para un hacer mas fluido el desarrollo de mas paquetes:

```bash
composer global require "codeception/codeception=*"
composer global require "codeception/specify=*"
composer global require "codeception/verify=*"
sudo ln -s ~/global/composer/vendor/bin/codecept /usr/local/bin/codecept
```

> Reemplazar `~/global/composer/vendor/bin/codecept`con la ruta donde se encuentra el direcotio bin global de composer, ejecutar el comando `composer config --list --global | grep home``y copiar la ruta correcta.

Para correr las pruebas funcionales del paquete ir a la carpeta donde se ha clonado el proyecto y ejecutar el comando:

```bash
codecept run
```

## Extra, configuraciones óptimas para Laravel en servidor Nginx

Cuando se crea un host virtual en Nginx, es recomendable dejar estas configuraciones para un mejor desempeño del servidor, eso si teniendo en cuenta que deben ser ajustadas a las necesidades de cada proyecto, muy importante correr el script que arregla los permisos de los ficheros y carpetas luego de correr estas configuraciones; el código acontinuaciòn mostrado está pensado para para un servidor local y con un host virtual llamado *testing.dev* con PHP7, se debe ajustar el `root` que apunte a la instalación de Laravel:

```nginx
server {
	listen 80; # poner aquí 'default_server' si es necesario
	listen [::]:80 ipv6only=on; # poner aquí 'default_server' si es necesario

	root /var/www/testing/public;
	index index.php index.html index.htm;

	server_name testing.dev www.testing.dev;
	charset   utf-8;

	gzip on;
	gzip_vary on;
	gzip_disable "msie6";
	gzip_comp_level 6;
	gzip_min_length 1100;
	gzip_buffers 16 8k;
	gzip_proxied any;
	gzip_types
		text/plain
		text/css
		text/js
		text/xml
		text/javascript
		application/javascript
		application/x-javascript
		application/json
		application/xml
		application/xml+rss;

	location / {
		try_files $uri $uri/ /index.php?$query_string;
	}

	location ~ \.php$ {
		try_files $uri /index.php =404;
		fastcgi_split_path_info ^(.+\.php)(/.+)$;
		#fastcgi_pass unix:/var/run/php5-fpm.sock; # Descomentar esta lìnea y comentar la siguiente si usas PHP5
		fastcgi_pass unix:/run/php/php7.0-fpm.sock;
		fastcgi_index index.php;
		fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
		include fastcgi_params;
	}

	location ~ /\.ht {
		deny all;
	}

	location ~* \.(?:jpg|jpeg|gif|png|ico|cur|gz|svg|svgz|mp4|ogg|ogv|webm|htc|svg|woff|woff2|ttf)$ {
		expires 1M;
		access_log off;
		add_header Cache-Control "public";
	}

	location ~* \.(?:css|js)$ {
		expires 7d;
		access_log off;
		add_header Cache-Control "public";
	}

}
```

Some data to test the Angular create/update component:

```javascript
this.bookForm.patchValue({
  reason_id: 1,
  name: 'Johan',
  author: 'Cristian',
  genre: 'thriller',
  stars: 3,
  published_year: '2012-12-12',
  enabled: true,
  status: 'waiting_confirmation',
  unlocking_word: 'foo',
  unlocking_word_confirmation: 'foo',
  synopsis: 'text'
});
```