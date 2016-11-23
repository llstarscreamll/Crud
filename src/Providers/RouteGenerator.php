<?php

namespace llstarscreamll\Crud\Providers;

class RouteGenerator extends BaseGenerator
{
    /**
     * El nombre de la tabla en la base de datos.
     *
     * @var string
     */
    public $table_name;

    /**
     * La iformación dada por el usuario.
     *
     * @var object
     */
    public $request;

    /**
     * Los campos parseados.
     *
     * @var stdClass
     */
    public $fields;

    /**
     * Crea nueva instancia de RouteGenerator.
     */
    public function __construct($request)
    {
        $this->table_name = $request->get('table_name');
        $this->request = $request;
        $this->fields = $this->advanceFields($this->request);
    }

    /**
     * Añade la ruta al fichero de rutas.
     *
     * @return bool
     */
    public function generateRoute()
    {
        // el nombre del recurso
        $route = "Route::resource('{$this->route()}','{$this->controllerClassName()}');";

        // si la tabla tienen la columna deleted_at, genero la ruta para
        // restaurar archivos de papelera
        if ($this->hasDeletedAtColumn($this->fields)) {
            $restore_route = "Route::put(\n\t'/{$this->route()}/restore/{{$this->table_name}}',".
                             "\n\t[\n\t'as' => '{$this->route()}.restore',".
                             "\n\t'uses' => '{$this->controllerClassName()}@restore'".
                             "\n\t]\n);\n";
            $route = $restore_route.$route;
        }

        // el fichero de las rutas
        $routesFile = base_path('routes/web.php');
        // obtengo el contenido del fichero de rutas
        $routesFileContent = file_get_contents($routesFile);

        // no está el nombre del recurso ($route) puesto en el fichero?
        if (strpos($routesFileContent, $route) == false) {
            $routesFileContent .= $route;

            file_put_contents($routesFile, $routesFileContent) === false
            ? session()->push('error', 'Error generando la ruta')
            : session()->push('success', 'Ruta generada correctamente');

            return true;
        }

        session()->push('warning', "La ruta: '".$route."' ya existe, tarea omitida.");

        return false;
    }
}
