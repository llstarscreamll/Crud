<?php

namespace llstarscreamll\Crud\Http\Controllers;

use Illuminate\Http\Request;
use llstarscreamll\Crud\Providers\ModelGenerator;
use llstarscreamll\Crud\Providers\RouteGenerator;
use llstarscreamll\Crud\Providers\ControllerGenerator;
use llstarscreamll\Crud\Providers\ViewsGenerator;
use llstarscreamll\Crud\Providers\TestsGenerator;
use llstarscreamll\Crud\Providers\ModelFactoryGenerator;
use llstarscreamll\Crud\Providers\FormRequestGenerator;
use llstarscreamll\Crud\Providers\ServiceGenerator;
use llstarscreamll\Crud\Providers\RepositoryGenerator;
use llstarscreamll\Crud\Providers\LangGenerator;
use llstarscreamll\Crud\Providers\SeedersGenerator;
use llstarscreamll\Crud\Providers\FurtherTasks;

use llstarscreamll\Crud\Actions\PortoFoldersGenerationAction;
use llstarscreamll\Crud\Actions\CreateComposerFileAction;
use llstarscreamll\Crud\Actions\CreateActionsFilesAction;
use llstarscreamll\Crud\Actions\CreateTasksFilesAction;
use llstarscreamll\Crud\Actions\CreateApiRoutesFilesAction;

class GeneratorController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // el usuario debe tener permisos para acceder al controlador
        // $this->middleware('checkPermissions', ['except' => ['store', 'update']]);
        // para evitar problemas con los permisos de ficheros y directorios
        umask(0);
    }

    /**
     * Muestra el formulario donde se debe dar la tabla de la base de datos a la
     * cual crearemos la CRUD app.
     *
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        return view('crud::wizard.index');
    }

    public function generatePortoContainer(Request $request)
    {
        // generate the base folders
        $portoFoldersGenerationAction = new PortoFoldersGenerationAction();
        $portoFoldersGenerationAction->run($request->get('is_part_of_package'));

        // generate composer file
        $createComposerFileAction = new CreateComposerFileAction();
        $createComposerFileAction->run($request->get('is_part_of_package'));

        // generate actions classes
        $createActionsFilesAction = new CreateActionsFilesAction();
        $createActionsFilesAction->run($request->get('is_part_of_package'));

        // generate tasks classes
        $createTasksFilesAction = new CreateTasksFilesAction();
        $createTasksFilesAction->run($request->get('is_part_of_package'));

        // generate API routes files
        $createApiRoutesFilesAction = new CreateApiRoutesFilesAction();
        $createApiRoutesFilesAction->run($request->get('is_part_of_package'));

        return 'success!!';
    }

    /**
     * Ejecuta los scripts para generar los ficheros necesarios para la CRUD app
     * de la tabla de la base de datos elegida.
     *
     * @return Illuminate\Http\Response
     */
    public function generate(Request $request)
    {
        // hago que las opciones dadas por el usuario persistan en un archivo de configuración
        // que luego se cargará automaticamente en caso de que se repita el proceso con la
        // misma tabla.
        $this->generateOptionsArray($request);

        // verifico que la tabla especificada existe en la base de datos
        if (!$this->tableExists($request->get('table_name'))) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'La tabla '.$request->get('table_name').' no existe en la base de datos.'
                );
        }

        // si el usuario quiere generar Container de Porto
        if ($request->get('app_type', 'laravel_app') !== 'laravel_app') {
            return $this->generatePortoContainer($request);
        }

        // las clases que generan la CRUD app
        $modelGenerator = new ModelGenerator($request);
        $controllerGenerator = new ControllerGenerator($request);
        $routeGenerator = new RouteGenerator($request);
        $viewsGenerator = new ViewsGenerator($request);
        $testsGenerator = new TestsGenerator($request);
        $modelFactoryGenerator = new ModelFactoryGenerator($request);
        $formRequestGenerator = new FormRequestGenerator($request);
        $serviceGenerator = new ServiceGenerator($request);
        $reposGenerator = new RepositoryGenerator($request);
        $langGenerator = new LangGenerator($request);
        $seedersGenerator = new SeedersGenerator($request);
        $furtherTasks = new FurtherTasks();

        $seedersGenerator->run();
        $langGenerator->run();
        $reposGenerator->run();
        $serviceGenerator->run();
        $formRequestGenerator->run();
        $modelFactoryGenerator->run();
        $testsGenerator->run();
        $modelGenerator->run();
        $controllerGenerator->run();
        $routeGenerator->run();
        $viewsGenerator->run();
        $furtherTasks->run();

        return redirect()->route(
            'crud.showOptions',
            ['table_name' => $request->get('table_name')]
        );
    }

    /**
     * Comprueba si existe o no una tabla en la base de datos.
     *
     * @return bool
     */
    private function tableExists($table)
    {
        return \Schema::hasTable($table);
    }

    /**
     * Genera un archivo con las opciones dadas para generar una CRUD aplicación.
     *
     * @return int|bool
     */
    private function generateOptionsArray($request)
    {
        // no se ha creado la carpeta donde guardo las opciones de los CRUD generados?
        if (!file_exists($path = base_path().'/config/modules/crud/generated')) {
            // entonces la creo
            mkdir($path, 0755, true);
        }

        $modelFile = $path.'/'.$request->get('table_name').'.php';

        $generator = new ModelGenerator($request);

        $content = view(
            $generator->templatesDir().'.options',
            [
            'request' => $request->except(['_token']),
            'gen' => $generator,
            ]
        );

        return file_put_contents($modelFile, $content);
    }

    /**
     * Muestra formulario con las opciones de la CRUD app a generar.
     *
     * @return view
     */
    public function showOptions(Request $request)
    {
        // verifico que la tabla especificada existe en la base de datos
        if (!$this->tableExists($request->get('table_name', 'null'))) {
            return redirect()->back()->with('error', 'La tabla '.$request->get('table_name').' no existe en la base de datos.');
        }

        // si ya he trabajado con la tabla en cuestion, cargo las opciones
        // de la última ves en que se genero el CRUD para esa taba
        if (file_exists(base_path().'/config/modules/crud/generated/'.$request->get('table_name').'.php')) {
            $data['options'] = config('modules.crud.generated.'.$request->get('table_name'));
        } else {
            $data['options'] = [];
        }

        $modelGenerator = new ModelGenerator($request);

        $data['fields'] = array_values($modelGenerator->fields($request->get('table_name')));
        $data['table_name'] = $request->get('table_name');
        $data['UI_themes'] = array_combine(
            config('modules.crud.config.supported_ui_themes'),
            config('modules.crud.config.supported_ui_themes')
        );

        return view('crud::wizard.options', $data);
    }
}
