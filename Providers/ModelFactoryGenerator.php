<?php

namespace llstarscreamll\Crud\Providers;

class ModelFactoryGenerator extends BaseGenerator
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
     * @var object
     */
    public $request;

    /**
     * Crea nueva instancia de ModelFactoryGenerator.
     */
    public function __construct($request)
    {
        $this->table_name = $request->get('table_name');
        $this->request = $request;
    }

    /**
     * Genera los tests o pruebas funcionales del CRUD a crear.
     *
     * @return bool
     */
    public function run()
    {
        // no se ha creado la carpeta para los archivos de idioma?
        if (!file_exists($this->modelFactoriesDir())) {
            // entonces la creo
            mkdir($this->modelFactoriesDir(), 0755, true);
        }

        $seederFile = $this->modelFactoriesDir().'/'.$this->modelClassName().'Factory.php';

        $content = view(
            $this->templatesDir().'.model-factory',
            [
            'gen' => $this,
            'fields' => $this->advanceFields($this->request),
            'request' => $this->request,
            ]
        );

        if (file_put_contents($seederFile, $content) === false) {
            session()->push('error', 'Error generando Model Factory');

            return false;
        }

        session()->push('success', 'Model Factory generado correctamente.');

        return true;
    }

    /**
     * Devuleve string del path de los page objects para los tests.
     *
     * @return string
     */
    public function modelFactoriesDir()
    {
        return database_path('/factories');
    }
}
