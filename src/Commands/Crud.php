<?php
namespace llstarscreamll\CrudGenerator\Commands;

use Illuminate\Console\Command;
use llstarscreamll\CrudGenerator\Db;

class Crud extends Command
{
    /**
     * El nombre de la tabla.
     * @var string
     */
    public $tableName;

    /**
     * La variable que guarda la decisión de generar o no un paquete o Package
     * @var bool
     */
    public $generate_package = false;

    /**
     * El nombre y descripción de uso del comando.
     * @var string
     */
    protected $signature = 'llstarscreamll:crud {tableName : The name of the table you want to generate crud for.}';

    /**
     * La descripción del comando.
     * @var string
     */
    protected $description = 'Genera una CRUD App de la tabla especificda en la base de datos';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle()
    {
        // TODO:
        // - Generar archivos de idioma
        // - Generar los test funcionales
        // - Generar seeds para creación de permisos del módulo
        // - Luego de generar archivos como controladores, modelos, etc, correr el
        //   comando php-codesnifer en psr-4 para arreglar todo el código generado
        // - Generar la sidebar
        // - Generar archivos de configuración del módulo
        // - Pensar en la creación de todos los ficheros con estructura modular
        // - En las vistas generar widget de busqueda por fechas en los campos de fechas

        $this->tableName = $this->argument('tableName');

        // le pregunto al usuario si quiere que sea generado un paquete o añadir el CRUD a la aplicación de laravel
        // existente, es decir en la que corre el comando
        if ($this->confirm('Quieres que sea generado un paquete? [y|n]')) {
            $this->generate_package = true;
        }

        //$this->generateLanguageFile();
        $this->generateModel();
        $this->generateRouteModelBinding();
        $this->generateRoute();
        $this->generateController();
        $this->generateViews();
    }

    /**
     * Genera el CRUD como un paquete de Laravel.
     * @return void
     */
    public function generatePackage()
    {
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
                $this->info("Route model binding inserted successfully in ".$providerFile);
                return true;
            }

            // match was not found for some reason
            $this->warn("Could not add route model binding for the route '".$this->route()."'.");
            $this->warn("Please add the following line manually in {$providerFile}:");
            $this->warn($declaration);
            return false;
        }

        // already exists
        $this->info("Model binding for the route: '".$this->route()."' already exists.");
        $this->info("Skipping...");
        return false;
    }

    /**
     * Añade la ruta al fichero de rutas.
     * @return bool
     */
    public function generateRoute()
    {
        $route = "Route::resource('{$this->route()}','{$this->controllerClassName()}');";
        $routesFile = app_path('Http/routes.php');
        $routesFileContent = file_get_contents($routesFile);

        if (strpos($routesFileContent, $route) == false) {
            $routesFileContent = $this->getUpdatedContent($routesFileContent, $route);
            file_put_contents($routesFile, $routesFileContent);
            $this->info("created route: ".$route);

            return true;
        }

        $this->info("Route: '".$route."' already exists.");
        $this->info("Skipping...");
        return false;
    }

    /**
     * Obtiene el contenido a actualizar para el fichero de rutas.
     * @param  string $existingContent
     * @param  string $route
     * @return string
     */
    protected function getUpdatedContent($existingContent, $route)
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

    /**
     * Genera el controlador.
     * @return void
     */
    public function generateController()
    {
        $controllerFile = $this->controllersDir().'/'.$this->controllerClassName().".php";

        if ($this->confirmOverwrite($controllerFile)) {
            $content = view($this->templatesDir().'.controller', [
                'gen' => $this,
                'fields' => Db::fields($this->tableName),
                'foreign_keys'  => Db::getForeignKeys($this->tableName)
            ]);
            file_put_contents($controllerFile, $content);
            $this->info($this->controllerClassName()." generated successfully.");
        }
    }

    /**
     * Genera el archivo para el Modelo de la tabla.
     * @return void
     */
    public function generateModel()
    {
        $modelFile = $this->modelsDir().'/'.$this->modelClassName().".php";

        if ($this->confirmOverwrite($modelFile)) {
            $content = view($this->templatesDir().'.model', [
                'gen' => $this,
                'fields' => Db::fields($this->tableName)
            ]);
            file_put_contents($modelFile, $content);
            $this->info("Model class ".$this->modelClassName()." generated successfully.");
        }
    }

    /**
     * Genera los ficheros para las vistas.
     * @return void
     */
    public function generateViews()
    {
        // no se ha creado la carpeta de las vistas?
        if (! file_exists($this->viewsDir())) {
            // entonces la creo
            mkdir($this->viewsDir());
        }

        // no se ha creado la carpeta partials de las vistas?
        if (! file_exists($this->viewsDir().'/partials')) {
            // entonces la creo
            mkdir($this->viewsDir().'/partials');
        }

        // recorro el array de vistas que debo crear
        foreach (config('llstarscreamll.CrudGenerator.config.views') as $view) {

            // TODO:
            // - Crear vista separada para la tabla del index
            // - Pasar todos los strings de las vistas a variables leidas de el
            //   archivo de idioma del paquete

            $viewFile = $this->viewsDir()."/".$view.".blade.php";

            if ($this->confirmOverwrite($viewFile)) {
                $content = view($this->templatesDir().'.views.'.$view, [
                    'gen' => $this,
                    'fields' => Db::fields($this->tableName)
                ]);

                file_put_contents($viewFile, $content);
                $this->info("View file ".$view." generated successfully.");
            }
        }
    }

    protected function confirmOverwrite($file)
    {
        // if file does not already exist, return
        if (!file_exists($file)) {
            return true;
        }

        // file exists, get confirmation
        if ($this->confirm($file.' already exists! Do you wish to overwrite this file? [y|N]')) {
            $this->info("overwriting...");
            return true;
        } else {
            $this->info("Using existing file ...");
            return false;
        }
    }

    public function route()
    {
        return str_slug(str_replace("_", " ", str_singular($this->tableName)));
    }

    public function controllerClassName()
    {
        return studly_case(str_singular($this->tableName))."Controller";
    }

    /**
     * Devuelve el path completo a la carpeta de las vistas.
     * @return string
     */
    public function viewsDir()
    {
        return base_path('resources/views/'.$this->viewsDirName());
    }

    /**
     * Devuelve el nombre de la carpeta donde serán guardadas las vistas.
     * @return string
     */
    public function viewsDirName()
    {
        return str_singular($this->tableName);
    }

    public function controllersDir()
    {
        return app_path('Http/Controllers');
    }

    public function modelsDir()
    {
        return app_path();
    }

    public function modelClassName()
    {
        return studly_case(str_singular($this->tableName));
    }

    public function modelVariableName()
    {
        return camel_case(str_singular($this->tableName));
    }

    public function titleSingular()
    {
        return ucwords(str_singular(str_replace("_", " ", $this->tableName)));
    }

    public function titlePlural()
    {
        return ucwords(str_replace("_", " ", $this->tableName));
    }

    public function templatesDir()
    {
        return config('llstarscreamll.CrudGenerator.config.templates');
    }
}
