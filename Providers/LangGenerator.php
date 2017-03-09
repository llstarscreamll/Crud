<?php

namespace llstarscreamll\Crud\Providers;

use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class LangGenerator extends BaseGenerator
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
     * Crea nueva instancia de LangGenerator.
     */
    public function __construct($request)
    {
        $this->table_name = $request->get('table_name');
        $this->request = $request;
    }

    /**
     * Genera los tests o pruebas funcionales de la CRUD app.
     *
     * @return bool
     */
    public function run()
    {
        // no se ha creado la carpeta para los archivos de idioma?
        if (!file_exists($this->langDir())) {
            // entonces la creo
            mkdir($this->langDir(), 0755, true);
        }

        $this->generateLangFiles() === false
            ? session()->push('error', 'Ocurrió un error generando el archivo de idioma.')
            : session()->push('success', 'Archivo de idioma generado correctamente.');

        return true;
    }

    /**
     * Devuleve string del path de los archivos de idioma.
     *
     * @return string
     */
    public function langDir()
    {
        return base_path('resources/lang/es/');
    }

    /**
     * Genera el archivo de idioma del paquete.
     *
     * @return int|bool
     */
    public function generateLangFiles()
    {
        $langFile = $this->langDir()."/{$this->modelVariableName()}.php";

        $content = view(
            $this->templatesDir().'.lang',
            [
            'gen' => $this,
            'fields' => $this->advanceFields($this->request),
            'request' => $this->request,
            ]
        );

        return file_put_contents($langFile, $content);
    }
}
