# CRUD Generator ChangeLog #

TODO: update this chage log!!

## [2.0] 2016-11-11 ##

#### Nuevo ####

- Soporte para tema Inspinia.
- Creación de ModelFactories de entidad generada.
- Creado seeders de datos a la tabla de la entidad generada (con Faker).
- Creando seeders para permisos de acceso de la entidad generada (con Faker).
- Mas tests funcionales generados para la app generada, aquí una breve lista de los que se prueba:
	- Creación de registro.
	- Actualización de registro.
	- Vista de detalles del registro.
	- Eliminación/Mover a papelera registro.
	- Eliminar varios registros a la vez.
	- Restaurar un registro de la papelera.
	- Restaurar varios registros a la vez de la papelera.
	- Comprobación de las columnas mostradas por defecto en la tabla de la vista index.
	- Visualización de registros en papelera en tabla index dependiendo del filtro realizado por el usuario. Los registros en papelera son resaltados en color rojo.
	- Comprobación de visivilidad de cada botón según los permisos del usuario.
	- Comprobación de restricciones de acceso a ciertas partes de la app generada según los permisos del usuario.
- Añadido DocBlock de Copy Right y autor a los archivos generados.
- Implementando FormRequests en controladores, los modelos ya no guardan las reglas de validación.
- Implementando "service layer" a la app generada.
- Implementando patron repositorio en al app generada, los archivos generados son:
	- Contrato del repositorio.
	- Implementación del contrato.
	- Y un "search criteria".
- Mejor organización y reutilización de código en las vistas generadas

#### Actualizado ####

- En los controladores se deja activado por defecto el middleware de acceso.
- Los modelos ya no tienen los dos propiedades "$fillable" y "$guarded" atendiendo a lo recomendado en la documentación de Laravel.
- Los page objects generados eredan del Index page object.
- Los tests generados tienen untag "@group" para agrupar los tests generados.
- Se redujo el código generado en las vistas
- Se redujo el código generado en los fichero de idioma.
- Actualizado a versión 5.3 de Laravel
- Refactor de las vistas generadas, se evitó tanto código repetido.

**NOTA:**

Este changelog trata de seguir los estándar [**Keep a CHANGELOG 0.0.3**](http://keepachangelog.com/en/0.3.0/) y [**Semantic Versioning 2.0.0**](http://semver.org/) adoptados por muchos proyectos y desarrolladores a lo largo de todo el mundo. Por favor leer la documentación para entender la estructura y contenido de este archivo.