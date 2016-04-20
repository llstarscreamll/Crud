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
     * @var string
     */
    public $table_name;

    /**
     * Los mensajes de alerta en la operación.
     * @var string
     */
    public $msg_warning;

    /**
     * Los mensajes de info en la operación.
     * @var string
     */
    public $msg_info;

    /**
     * 
     */
    public function __construct($table_name)
    {
        $this->table_name = $table_name;
    }

    /**
     * Añade el "Route Model Binding" al archivo RouteServiceProvider.php dentro del método
     * boot, inyecta el una instancia del modelo a la ruta.
     * @return bool
     */
    public function generateRouteModelBinding()
    {
        $declaration = "\$router->model('".$this->route()."', 'App\\".$this->modelClassName()."');";
        $providerFile = app_path('Providers/RouteServiceProvider.php');
        $fileContent = file_get_contents($providerFile);

        if (strpos($fileContent, $declaration) == false) {
            $regex = "/(public\s*function\s*boot\s*\(\s*Router\s*.router\s*\)\s*\{)/";

            if (preg_match($regex, $fileContent)) {
                $fileContent = preg_replace($regex, "$1\n\t\t".$declaration, $fileContent);
                file_put_contents($providerFile, $fileContent);
                return true;
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
     * @return bool
     */
    public function generateRoute()
    {
        // el nombre del recurso
        $route = "Route::resource('{$this->route()}','{$this->controllerClassName()}');";
        // el fichero de las rutas
        $routesFile = app_path('Http/routes.php');
        // obtengo el contenido del fichero de rutas
        $routesFileContent = file_get_contents($routesFile);

        // no está el nombre del recurso ($route) puesto en el fichero?
        if (strpos($routesFileContent, $route) == false) {
            $routesFileContent = $this->getUpdatedContent($routesFileContent, $route);
            file_put_contents($routesFile, $routesFileContent);

            return true;
        }

        $this->msg_info = "La ruta: '".$route."' ya existe, tarea omitida.";

        return false;
    }

    /**
     * Obtiene el contenido a actualizar para el fichero de rutas.
     * @param  string $existingContent
     * @param  string $route
     * @return string
     */
    public function getUpdatedContent($existingContent, $route)
    {
        // check if the user has directed to add routes
        $str = "nvd-crud routes go here";
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
