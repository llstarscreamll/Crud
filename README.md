# CRUD Generator

CrudGenerator es un paquete de laravel para la generación de aplicaciones CRUD a partir de una tabla de una base de datos.

## TODO

- Añadir funciones de exportación de información de los modelos en los formatos:
	- CSV
	- Excel
	- PDF
	- Print (vista para impresión)
- Añadir botón de cancelar en las vistas de crear y actualizar que redirijan al index del módulo.
- Añadir botón volver en vista de detalles (show).
- Añadir opción para crear el archivo de migración, en este caso lógicamente no se tendrá en cuenta la tabla en la base de datos.
- Hacer uso de los FormRequest de Laravel para la validación de formularios para cada método (store, update, delete, tal vez index).
- Añadir opción para que el usuario eleja que tipo de buscador se desea en el index del módulo:
	- Un sólo elemento de formulario de búsqueda para todos los campos, formulario de búsqueda sencilla.
	- Elementos de formulario para cada campo del modelo, formulario de búsqueda avanzada.
- Se debe preguntar para los campos o atributos del modelo:
	- El tipo de campo para la base de datos
	- El tipo de campo para el formulario HTML
	- Si el campo es escondido o protegido en el modelo (guard)
	- Configurar si el campo es llaveforánea de otra tabla en la base de datos.
- Dar opción para crear el CRUD con estructura modular, como si fuera un paquete de Laravel.
- Crear habilidad para que el usuario elija que campos desea mostrar en la tabla del index.
- Crear función de restablecimiento de registros en la papelera en la tabla del index y show.
- Crear habilidad para dejar decirdir al usuario si quiere o no las ediciones inline en la tabla con el componente x-edit de javascript.
- Las búsquedas por fechas en el formulario de búsqueda avanzado debe ser por rangos de fecha y no sólo por una fecha específica.
- Añadir opción para habilidad protección de datos de registros al crear los ficheros.
- Añadir colores a la filas de la tabla del index dependiendo del estado del registro, rojo para registros eliminados, amarillos para registros protegidos, etc... y añadir notas de estos colores al final de la vista.

## Configuraciones óptimas para Laravel en servidor Nginx

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
