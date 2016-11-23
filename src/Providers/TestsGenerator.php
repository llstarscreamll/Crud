<?php

namespace llstarscreamll\Crud\Providers;

class TestsGenerator extends BaseGenerator
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
     * Crea nueva instancia de TestsGenerator.
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
    public function generate()
    {
        // no se ha creado la carpeta para los pageObjects?
        if (!file_exists($this->pageObjectsDir())) {
            // entonces la creo
            mkdir($this->pageObjectsDir(), 0755, true);
        }

        // no se ha creado la carpeta para los tests funcionales?
        if (!file_exists($this->testsDir())) {
            // entonces la creo
            mkdir($this->testsDir(), 0755, true);
        }

        // recorro el array de tests que debo crear
        foreach (config('modules.crud.config.tests') as $test) {
            // genero los tests funcionales
            if (!$this->generateFunctionalTests($test)) {
                session()->push('error', 'Ocurrió un error generando el Test '.$test.'.');
            }

            // no creamos Page Object Permissions
            if ($test == 'Permissions') {
                continue;
            }

            // genero los page objects
            if (!$this->generatePageObject($test)) {
                session()->push('error', 'Ocurrió un error generando el PageObject '.$test.'.');
            }
        }

        session()->push('success', 'Los tests se han generado correctamente.');

        return true;
    }

    /**
     * Devuleve string del path de los page objects para los tests.
     *
     * @return string
     */
    public function pageObjectsDir()
    {
        return base_path('tests/_support/Page/Functional/'.$this->pageObjectsDirName());
    }

    /**
     * Devuelve el nombre de la carpeta que contiene los page objects de los tests
     * funcionales.
     *
     * @return string
     */
    public function pageObjectsDirName()
    {
        return ucwords(camel_case(str_plural($this->table_name)));
    }

    /**
     * Devuleve string del path de los tests funcionales.
     *
     * @return string
     */
    public function testsDir()
    {
        return base_path('tests/functional/'.$this->pageObjectsDirName());
    }

    /**
     * Genera los achivos de los page objects.
     *
     * @return int|bool
     */
    public function generatePageObject($test)
    {
        $pageObjectFile = $this->pageObjectsDir().'/'.$test.'.php';

        $content = view(
            $this->templatesDir().'.pageObjects.'.$test,
            [
            'gen' => $this,
            'fields' => $this->advanceFields($this->request),
            'test' => $test,
            'request' => $this->request,
            ]
        );

        return file_put_contents($pageObjectFile, $content);
    }

    /**
     * Genera los archivos de test del CRUD.
     *
     * @return int|bool
     */
    public function generateFunctionalTests($test)
    {
        $testFile = $this->testsDir().'/'.$test.'Cest.php';

        $content = view(
            $this->templatesDir().'.tests.'.$test,
            [
            'gen' => $this,
            'fields' => $this->advanceFields($this->request),
            'test' => $test,
            'request' => $this->request,
            ]
        );

        return file_put_contents($testFile, $content);
    }
}
