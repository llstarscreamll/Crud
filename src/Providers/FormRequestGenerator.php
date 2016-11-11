<?php

namespace llstarscreamll\Crud\Providers;

use llstarscreamll\Crud\Providers\BaseGenerator;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class FormRequestGenerator extends BaseGenerator
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
     * Genera los tests o pruebas funcionales del CRUD a crear.
     *
     * @return integer|bool
     */
    public function generate()
    {
        // no se ha creado la carpeta para los archivos de idioma?
        if (! file_exists($this->formRequestsDir())) {
            // entonces la creo
            mkdir($this->formRequestsDir(), 0755, true);
        }

        $formRequestFile = $this->formRequestsDir()."/".$this->modelClassName()."Request.php";

        $content = view(
            $this->templatesDir().'.formRequests.create-form-request',
            [
            'gen' => $this,
            'fields' => $this->advanceFields($this->request),
            'request' => $this->request
            ]
        );

        //dd($content, $formRequestFile);

        if (file_put_contents($formRequestFile, $content) === false) {
            $this->msg_error[] = 'Error generando Form Request';
            return false;
        }

        $this->msg_success[] = "Form Request generado correctamente.";
        
        return true;
    }

    /**
     * Devuleve string del path de los page objects para los tests.
     *
     * @return string
     */
    public function formRequestsDir()
    {
        return app_path('Http/Requests');
    }
}
