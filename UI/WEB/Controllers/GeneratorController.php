<?php

namespace App\Containers\Crud\UI\WEB\Controllers;

use Illuminate\Http\Request;
use App\Containers\Crud\Providers\ModelGenerator;
use App\Containers\Crud\Actions\GeneratePortoContainerAction;
use App\Containers\Crud\Actions\GenerateStandardLaravelApp;
use App\Containers\Crud\Actions\GenerateAngular2ModuleAction;
use App\Containers\Crud\Actions\GenerateConfigFileAction;
use App\Containers\Crud\Actions\LoadOptionsAction;
use App\Containers\Crud\Actions\CopyDirsAction;
use App\Ship\Parents\Controllers\WebController;

class GeneratorController extends WebController
{
    /**
     * Generate Laravel Packages Action.
     *
     * @var App\Containers\Crud\Actions\GeneratePortoContainerAction
     */
    private $generatePortoContainerAction;

    /**
     * Generate Standard Laravel App Action.
     *
     * @var App\Containers\Crud\Actions\GenerateStandardLaravelApp
     */
    private $generateStandardLaravelApp;

    /**
     * Generate Angular 2 Module Action.
     *
     * @var App\Containers\Crud\Actions\GenerateAngular2ModuleAction
     */
    private $generateAngular2ModuleAction;

    /**
     * Generate Config File Action.
     *
     * @var App\Containers\Crud\Actions\GenerateConfigFileAction
     */
    private $generateConfigFileAction;
    
    /**
     * Copy Generated Dirs Action.
     *
     * @var App\Containers\Crud\Actions\CopyDirsAction
     */
    private $copyDirsAction;

    /**
     * Create a new controller instance.
     */
    public function __construct(
        GeneratePortoContainerAction $generatePortoContainerAction,
        GenerateStandardLaravelApp $generateStandardLaravelApp,
        GenerateAngular2ModuleAction $generateAngular2ModuleAction,
        GenerateConfigFileAction $generateConfigFileAction,
        CopyDirsAction $copyDirsAction
    ) {
        $this->generatePortoContainerAction = $generatePortoContainerAction;
        $this->generateStandardLaravelApp = $generateStandardLaravelApp;
        $this->generateAngular2ModuleAction = $generateAngular2ModuleAction;
        $this->generateConfigFileAction = $generateConfigFileAction;
        $this->copyDirsAction = $copyDirsAction;
    }

    /**
     * Muestra el formulario donde se debe dar la tabla de la base de datos a la
     * cual crearemos la CRUD app.
     *
     * @return Illuminate\Http\Response
     */
    public function index(Request $request)
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
        $this->generateConfigFileAction->run($request->except(['_token']));

        // check if the given table exists
        if (!$this->tableExists($request->get('table_name'))) {
            return redirect()
                ->back()
                ->with(
                    'error',
                    'La tabla '.$request->get('table_name').' no existe en la base de datos.'
                );
        }

        //switch over what type of CRUD app the user wants to generate
        switch ($request->get('app_type')) {
            case 'porto_container':
                $this->generatePortoContainerAction->run($request);
                break;
            case 'standard_laravel_app':
                $this->generateStandardLaravelApp->run($request);
                break;
            default:
                session('warning', 'Nothing to generate...');
                break;
        }

        if ($request->get('create_angular_2_module', false)) {
            $this->generateAngular2ModuleAction->run($request);
        }

        $this->copyDirsAction->run($request);

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

        // try to retrieve the last given CRUD config options for this table
        $loadOptionsAction = new LoadOptionsAction();
        $data['options'] = $loadOptionsAction->run($request->get('table_name'));

        $modelGenerator = new ModelGenerator($request);

        $data['fields'] = array_values($modelGenerator->fields($request->get('table_name')));
        $data['table_name'] = $request->get('table_name');
        $data['UI_themes'] = [];

        return view('crud::wizard.options', $data);
    }
}
