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

    /**
     * Ejecuta los scripts para generar los ficheros necesarios para la CRUD app
     * de la tabla de la base de datos elegida.
     *
     * @return Illuminate\Http\Response
     */
    public function generate(Request $request)
    {
        // para flashear los mensajes
        $msg_success = array();
        $msg_error = array();
        $msg_warning = array();
        $msg_info = array();

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

        $seedersGenerator->generate();
        $langGenerator->generate();
        $reposGenerator->generate();
        $serviceGenerator->generate();
        $formRequestGenerator->generate();
        $modelFactoryGenerator->generate();
        $testsGenerator->generate();
        $modelGenerator->generate();
        $controllerGenerator->generate();
        $routeGenerator->generateRoute();
        $furtherTasks->run();

        ///////////////////////
        // genero las vistas //
        ///////////////////////
        if (!$viewsGenerator->generate()) {
            $msg_error = array_merge($msg_error, $viewsGenerator->msg_error);
        } else {
            // el controlador se generó correctamente
            $msg_success = array_merge($msg_success, $viewsGenerator->msg_success);
        }

        return redirect()->route(
            'crud.showOptions',
            ['table_name' => $request->get('table_name')]
        );
    }

    /**
     * [tableExists description].
     *
     * @return [type] [description]
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
     * [showOptions description].
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
