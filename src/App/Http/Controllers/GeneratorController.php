<?php

namespace llstarscreamll\CrudGenerator\App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use llstarscreamll\CrudGenerator\Providers\ModelGenerator;
use llstarscreamll\CrudGenerator\Providers\RouteGenerator;
use llstarscreamll\CrudGenerator\Providers\ControllerGenerator;
use llstarscreamll\CrudGenerator\Providers\ViewsGenerator;
use llstarscreamll\CrudGenerator\Providers\TestsGenerator;

class GeneratorController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        // el usuario debe estar autenticado para acceder al controlador
        $this->middleware('auth');
        // el usuario debe tener permisos para acceder al controlador
        //$this->middleware('checkPermissions', ['except' => ['store', 'update']]);
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index()
    {
        return view('CrudGenerator::wizard.index');
    }

    /**
     * [generate description]
     * @return [type] [description]
     */
    public function generate(Request $request)
    {
        // TODO:
        // - Validar los campos que vienen del usuario

        // para flashear los mensajes
        $msg_success = array();
        $msg_error = array();
        $msg_warning = array();
        $msg_info = array();
        
        // verifico que la tabla especificada existe en la base de datos
        if (! $this->tableExists($request->get('table_name'))) {
            return redirect()->back()->with('error', "La tabla ".$request->get('table_name')." no existe en la base de datos.");
        }

        // el generador de los archivos de modelos
        $modelGenerator = new ModelGenerator($request);
        $controllerGenerator = new ControllerGenerator($request);
        $routeGenerator = new RouteGenerator($request);
        $viewsGenerator = new ViewsGenerator($request);
        $testsGenerator = new TestsGenerator($request);

        ////////////////////////////////////
        // genero las pruebas funcionales //
        ////////////////////////////////////
        if ($testsGenerator->generate() === false) {
            return redirect()->back()->with('error', "Ocurrió un error generando los tests funcionales.");
        }
        // el modelo se generó correctamente
        $msg_success[] = 'Los tests se han generado correctamente.';

        //////////////////////
        // genero el modelo //
        //////////////////////
        if ($modelGenerator->generate() === false) {
            return redirect()->back()->with('error', "Ocurrió un error generando el modelo.");
        }
        // el modelo se generó correctamente
        $msg_success[] = 'Modelo generado correctamente.';

        ///////////////////////////
        // genero el controlador //
        ///////////////////////////
        if ($controllerGenerator->generate() === false) {
            return redirect()->back()->with('error', "Ocurrió un error generando el controlador.");
        }
        // el modelo se generó correctamente
        $msg_success[] = 'Controlador generado correctamente.';

        //////////////////////////////////////////
        // genero el model binding para la ruta //
        //////////////////////////////////////////
        if ($routeGenerator->generateRouteModelBinding() === false) {
            $msg_warning[] = $routeGenerator->msg_warning;
            $msg_info[] = $routeGenerator->msg_info;
        } else {
            // el controlador se generó correctamente
            $msg_success[] = 'Model Binding para el Controlador generado correctamente.';
        }

        ////////////////////
        // genero la ruta //
        ////////////////////
        if ($routeGenerator->generateRoute() === false) {
            $msg_warning[] = $routeGenerator->msg_warning;
            $msg_info[] = $routeGenerator->msg_info;
        } else {
            // la ruta se generó correctamente
            $msg_success[] = 'La ruta se ha generado correctamente.';
        }

        ///////////////////////
        // genero las vistas //
        ///////////////////////
        if (! $viewsGenerator->generate()) {
            $msg_error = array_merge($msg_error, $viewsGenerator->msg_error);
        } else {
            // el controlador se generó correctamente
            $msg_success = array_merge($msg_success, $viewsGenerator->msg_success);
        }

        //////////////////////////
        // flasheo los mensajes //
        //////////////////////////
        $request->session()->flash('success', $msg_success);
        $request->session()->flash('error', $msg_error);
        $request->session()->flash('info', $msg_info);
        $request->session()->flash('warning', $msg_warning);

        dd($request->session()->get('success'), $request->session()->get('error'), $request->all(), $routeGenerator->advanceFields($request));

        return redirect()->back();
    }

    /**
     * [tableExists description]
     * @return [type] [description]
     */
    private function tableExists($table)
    {
        return \Schema::hasTable($table);
    }

    /**
     * [showOptions description]
     * @return view
     */
    public function showOptions(Request $request)
    {
        // verifico que la tabla especificada existe en la base de datos
        if (! $this->tableExists($request->get('table_name', 'null'))) {
            return redirect()->back()->with('error', "La tabla ".$request->get('table_name')." no existe en la base de datos.");
        }

        $modelGenerator = new ModelGenerator($request);

        $data['fields'] = array_values($modelGenerator->fields($request->get('table_name')));
        $data['table_name'] = $request->get('table_name');

        return view('CrudGenerator::wizard.options', $data);
    }
}
