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
     * Añade el "Route Model Binding" al archivo RouteServiceProvider.php dentro del método
     * boot, inyecta el una instancia del modelo a la ruta.
     *
     * @return bool
     */
    public function generateRouteModelBinding()
    {
        // si la entidad tiene softDeletes no creo el Model Binding
        if ($this->hasDeletedAtColumn($this->fields)) {
            $this->msg_info = "La entidad posee atributo SoftDeleted, Model Binding para la ruta: '".$this->route()."' no creado, tarea omitida.";
            return false;
        }

        $declaration = "\$router->model('".$this->route()."', '".config('llstarscreamll.CrudGenerator.config.parent-app-namespace')."\\Models\\".$this->modelClassName()."');";
        $providerFile = app_path('Providers/RouteServiceProvider.php');
        $fileContent = file_get_contents($providerFile);

        if (strpos($fileContent, $declaration) == false) {
            $regex = "/(public\s*function\s*boot\s*\(\s*Router\s*.router\s*\)\s*\{)/";

            if (preg_match($regex, $fileContent)) {
                $fileContent = preg_replace($regex, "$1\n\t\t".$declaration, $fileContent);
                return file_put_contents($providerFile, $fileContent)  && chmod($providerFile, 664);
            }

            // no se encontró la linea en donde se debe añadir al Route Model Binding
            $this->msg_warning = "No se pudo añadir el enlace al modelo para la ruta '".$this->route()."'. ";
            $this->msg_warning .= "Por favor añada el enlace manualmente en el archivo {$providerFile}:\n";
            $this->msg_warning .= $declaration;
            return false;
        }

        // ya se ha añadido antes el enlace
        $this->msg_info = "Model Binding para la ruta: '".$this->route()."' ya existe, tarea omitida.";
        return false;
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

            $restore_route = "Route::put(\n\t'/{$this->route()}/restore/{{$this->route()}}',\n\t[\n\t'as'    =>  '{$this->route()}.restore',\n\t'uses'  =>  '{$this->controllerClassName()}@restore'\n\t]\n);\n";
            $route = $restore_route.$route;

        }

        // el fichero de las rutas
        $routesFile = app_path('Http/routes.php');
        // obtengo el contenido del fichero de rutas
        $routesFileContent = file_get_contents($routesFile);

        // no está el nombre del recurso ($route) puesto en el fichero?
        if (strpos($routesFileContent, $route) == false) {
            
            $routesFileContent = $this->getUpdatedContent($routesFileContent, $route);
            return file_put_contents($routesFile, $routesFileContent)  && chmod($routesFile, 664);
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
