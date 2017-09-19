# Release Notes

## 3.7.2 (2017-09-19)

### Fixed

- API:
	- fix form model tests assertions

### Changed

- Angular:
	- move constructor to end of effect class, attrs first (to satisfy tslint)
	- move constructor to end of effect class, attrs first (to satisfy tslint)
	- many code cleanings

## 3.7.1 (2017-06-18)

### Fixed

- Prevent persist data when Angular module test utils are generated from Laravel models factories.

### Changed

- Rename templates variable `$gen` to `$crud`.
- Rename changelog, lisence and readme files.
- Rename test folder to Tests.

## 3.7 (2017-06-14)

### Added

- Add example code generated from the functional tests on the **CrudExample** folder.

### Fixed

- Fix conflictive template names, closes [#2](https://github.com/llstarscreamll/Crud/issues/2).

### Changed

- Use own layout, no external layout needed now.
- Add GUI to regenerate several apps from existing config files with one click.
- Real paths are now used to generate de Angular and apiato container, nothing to move or copy. This improves the app performance.
- [Angular]:
	- use acl directives from Hello-Angular.
	- more detailed and descriptive tests generated.
	- add loader component while getting data from API on table list and form components.
	- API msgs state are now isolated per module instead of the global approeach.
	- make components more decupled and reusable, not need to recreate the entire store selector stuff for use a simple compenent.
	- components and pages uses abstract classes to share common logic.
	- rename many class methods.
	- other improvements setting up ngrx actions and effects.
	- add a few more stuff for mockbackend on tests.
	- rename containers folder to pages.
	- add dockBlock to generated classes/files, developer should make an IDE search and replace to set the desired values.
	- many improvements, fixes and clean up on generated module.
- [API]:
	- remove action to bootstrap Codeception test suit, the developer **must** do it after generate de container, this improves the app performance.
	- remove action to format generated code with **php-cs-fixer**, the developer **should** do it manually, this improves the app performance.
	- add option on GUI to decide if group main container classes like actions, tasks, tests, etc...
	- append real id attr on transformer if current user is admin.
	- update permissions names to fit the format **plural.action**, e.g. **books.list_and_seacrch**
	- improvements on generated factories for testing stuff
	- use one main container helper class on tests instead of having one per entity.
	- add db assertions on generated tests.
	- rename tests class methods.
	- add classes docBlock whit author tag, developer should make an IDE search and replace to set the desired values.
- Rename **readme** and **changelog** files.

### Removed

- [Angular]:
	- remove empty generated files, like the css components files.
- [API]:
	- remove empty **UI/CLI** generated folder.

## 2.0 (2016-11-11)

### Nuevo

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

### Actualizado

- En los controladores se deja activado por defecto el middleware de acceso.
- Los modelos ya no tienen los dos propiedades "$fillable" y "$guarded" atendiendo a lo recomendado en la documentación de Laravel.
- Los page objects generados eredan del Index page object.
- Los tests generados tienen untag "@group" para agrupar los tests generados.
- Se redujo el código generado en las vistas
- Se redujo el código generado en los fichero de idioma.
- Actualizado a versión 5.3 de Laravel
- Refactor de las vistas generadas, se evitó tanto código repetido.
