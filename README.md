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