<?php

namespace llstarscreamll\CrudGenerator\Providers;

use llstarscreamll\CrudGenerator\Providers\BaseGenerator;

/**
*
*/
class ControllerGenerator extends BaseGenerator
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
     * Los datos del usuario.
     *
     * @var Object
     */
    public $request;

    /**
     *
     */
    public function __construct($request)
    {
        $this->table_name = $request->get('table_name');
        $this->request = $request;
    }

    /**
     * Genera el controlador.
     *
     * @return void
     */
    public function generate()
    {
        // el archivo del controlador
        $controllerFile = $this->controllersDir().'/'.$this->controllerClassName().".php";

        $content = view(
            $this->templatesDir().'.controller',
            [
            'gen' => $this,
            'fields' => $this->advanceFields($this->request),
            'foreign_keys'  => $this->getForeignKeys($this->table_name)
            ]
        );

        return file_put_contents($controllerFile, $content);
    }
}
