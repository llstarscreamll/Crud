<?php

namespace llstarscreamll\Crud\Providers;

class ControllerGenerator extends BaseGenerator
{
    /**
     * El nombre de la tabla en la base de datos.
     *
     * @var string
     */
    public $table_name;

    /**
     * Los datos del usuario.
     *
     * @var object
     */
    public $request;

    /**
     * Crea nueva instancia de ControllerGenerator.
     */
    public function __construct($request)
    {
        $this->table_name = $request->get('table_name');
        $this->request = $request;
    }

    /**
     * Genera el controlador.
     */
    public function generate()
    {
        // el archivo del controlador
        $controllerFile = $this->controllersDir().'/'.$this->controllerClassName().'.php';

        $content = view(
            $this->templatesDir().'.controller',
            [
            'gen' => $this,
            'fields' => $this->advanceFields($this->request),
            'foreign_keys' => $this->getForeignKeys($this->table_name),
            'request' => $this->request,
            ]
        );

        file_put_contents($controllerFile, $content) === false
        ? session()->push('error', 'Error generando controlador')
        : session()->push('success', 'Controlador generado correctamente');

        return true;
    }
}
