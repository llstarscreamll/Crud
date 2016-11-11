<?php

namespace llstarscreamll\Crud\Providers;

use llstarscreamll\Crud\Providers\BaseGenerator;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class ServiceGenerator extends BaseGenerator
{
    /**
     * El nombre de la tabla en la base de datos.
     *
     * @var string
     */
    public $table_name;
    
    /**
     * La iformación dada por el usuario.
     *
     * @var Object
     */
    public $request;

    public $msg_success = array();
    public $msg_error = array();

    /**
     *
     */
    public function __construct($request)
    {
        $this->table_name = $request->get('table_name');
        $this->request = $request;
    }

    /**
     * Genera el servicio del CRUD a crear.
     *
     * @return integer|bool
     */
    public function generate()
    {
        // si no existe el directorio donde crearemos el servicio, lo creamos
        if (! file_exists($this->servicesDir())) {
            // entonces la creo
            mkdir($this->servicesDir(), 0755, true);
        }

        $serviceFile = $this->servicesDir()."/".$this->modelClassName()."Service.php";

        $content = view(
            $this->templatesDir().'.service',
            [
            'gen' => $this,
            'fields' => $this->advanceFields($this->request),
            'request' => $this->request,
            'foreign_keys'  => $this->getForeignKeys($this->table_name),
            ]
        );

        if (file_put_contents($serviceFile, $content) === false) {
            $this->msg_error[] = 'Error generando service';
            return false;
        }

        $this->msg_success[] = "Service generado correctamente.";
        
        return true;
    }

    /**
     * Devuleve string del path de los page objects para los tests.
     *
     * @return string
     */
    public function servicesDir()
    {
        return app_path('/Services');
    }
}
