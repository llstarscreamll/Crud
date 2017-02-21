<?php

namespace llstarscreamll\Crud\Http\Controllers;

use Illuminate\Http\Request;
use llstarscreamll\Crud\Providers\ModelGenerator;
use llstarscreamll\Crud\Actions\GenerateLaravelPackageAction;
use llstarscreamll\Crud\Actions\GenerateStandardLaravelApp;

class GeneratorController extends Controller
{
    /**
     * Generate Laravel Packages Action.
     *
     * @var llstarscreamll\Crud\Actions\GenerateLaravelPackageAction
     */
    private $generateLaravelPackageAction;

    /**
     * Generate Standard Laravel App Action.
     * @var llstarscreamll\Crud\Actions\GenerateStandardLaravelApp
     */
    private $generateStandardLaravelApp;

    /**
     * Create a new controller instance.
     */
    public function __construct(
        GenerateLaravelPackageAction $generateLaravelPackageAction,
        GenerateStandardLaravelApp $generateStandardLaravelApp
    ) {
        $this->generateLaravelPackageAction = $generateLaravelPackageAction;
        $this->generateStandardLaravelApp = $generateStandardLaravelApp;
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
        // store the given data for remember this settings in future
        $this->generateOptionsArray($request);

        // check if the given table exists
        if (!$this->tableExists($request->get('table_name'))) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'La tabla '.$request->get('table_name').' no existe en la base de datos.'
                );
        }

        // switch over what type of CRUD app the user wants to generate
        switch ($request->get('app_type')) {
            case 'laravel_package':
                $this->generateLaravelPackageAction->run($request);
                break;
            case 'standard_laravel_app':
                $this->generateStandardLaravelApp->run($request);
                break;
            default:
                session('warning', 'Nothing to generate...');
                break;
        }

        // go to the CRUD settings page
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
            return redirect()
                ->back()
                ->with('error', $request->get('table_name').' table doesn\'t exists');
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
