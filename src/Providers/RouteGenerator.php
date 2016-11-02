<?php

namespace llstarscreamll\CrudGenerator\Providers;

use llstarscreamll\CrudGenerator\Providers\BaseGenerator;

/**
*
*/
class RouteGenerator extends BaseGenerator
{
    /**
     * El nombre de la tabla en la base de datos.
     *
     * @var string
     */
    public $table_name;

    /**
     * Los mensajes de alerta en la operación.
     *
     * @var string
     */
    public $msg_warning;

    /**
     * Los mensajes de info en la operación.
     *
     * @var string
     */
    public $msg_info;

    /**
     *
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

            $restore_route = "Route::put(\n\t'/{$this->route()}/restore/{{$this->table_name}}',\n\t[\n\t'as' => '{$this->route()}.restore',\n\t'uses' => '{$this->controllerClassName()}@restore'\n\t]\n);\n";
            $route = $restore_route.$route;

        }

        // el fichero de las rutas
        $routesFile = base_path('routes/web.php');
        // obtengo el contenido del fichero de rutas
        $routesFileContent = file_get_contents($routesFile);

        // no está el nombre del recurso ($route) puesto en el fichero?
        if (strpos($routesFileContent, $route) == false) {
            
            $routesFileContent = $this->getUpdatedContent($routesFileContent, $route);
            return file_put_contents($routesFile, $routesFileContent);
        }

        $this->msg_info = "La ruta: '".$route."' ya existe, tarea omitida.";

        return false;
    }

    /**
     * Obtiene el contenido a actualizar para el fichero de rutas.
     *
     * @param  string $existingContent
     * @param  string $route
     * @return string
     */
    public function getUpdatedContent($existingContent, $route)
    {
        // check if the user has directed to add routes
        $str = "generated routes go here";
        if (strpos($existingContent, $str) !== false) {
            return str_replace($str, "{$str}\n\t".$route, $existingContent);
        }

        // check for 'web' middleware group
        $regex = "/(Route\s*\:\:\s*group\s*\(\s*\[\s*\'middleware\'\s*\=\>\s*\[\s*\'web\'\s*\]\s*\]\s*\,\s*function\s*\(\s*\)\s*\{)/";
        if (preg_match($regex, $existingContent)) {
            return preg_replace($regex, "$1\n\t".$route, $existingContent);
        }

        // if there is no 'web' middleware group
        return $existingContent."\n".$route;
    }
}
