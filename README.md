# CRUD Generator

CrudGenerator es un paquete de laravel para la generación de aplicaciones CRUD a partir de una tabla de una base de datos.

# TODO

- Añadir funciones de exportación de información de los modelos en los formatos:
	- CSV
	- Excel
	- PDF
	- Print (vista para impresión)
- Añadir opción para crear el archivo de migración, en este caso lógicamente no se tendrá en cuenta la tabla de la base de datos.
- Añadir los botones para Ver, Editar, Eliminar, etc, en la columna de acciones en la tabla del index de cada módulo.
- Añadir opción para elegir que tipo de buscador se desea en el index del módulo:
	- Un sólo elemento de formulario de búsqueda para todos los campos.
	- Elementos de formulario para cada campo del modelo.
- Se debe preguntar para los campos o atributos del modelo:
	- El tipo de campo para la base de datos
	- El tipo de campo para el formulario HTML
	- Si se debe mostrar el campo en la tabla del index
	- Si el campo es escondido o protegido en el modelo (guard)
	- Configurar si el campo es llaveforánea de otra tabla en la base de datos.
- Dar opción para crear el CRUD con estructura modular, como si fuera un paquete de Laravel