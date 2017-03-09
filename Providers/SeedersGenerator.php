<?php

namespace App\Containers\Crud\Providers;

class SeedersGenerator extends BaseGenerator
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
     * Crea nueva instancia de SeedersGenerator.
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
        $this->generatePermissionSeeder() === false
        ? session()->push('error', 'Ocurrió un error generando el seeder de permisos.')
        : session()->push('success', 'Seeder de permisos generado correctamente.');

        $this->generateFakeDataSeeder() === false
        ? session()->push('error', 'Ocurrió un error generando el seeder de datos de prueba.')
        : session()->push('success', 'Seeder de datos de prueba generado correctamente.');

        return true;
    }

    /**
     * Devuleve string del path de los seeder.
     *
     * @return string
     */
    public function seedsDir()
    {
        return base_path('database/seeds');
    }

    /**
     * Genera el seeder de los permisos del módulo o entidad.
     *
     * @return int|bool
     */
    public function generatePermissionSeeder()
    {
        $seederFile = $this->seedsDir().'/'.$this->modelClassName().'PermissionsSeeder.php';

        $content = view(
            $this->templatesDir().'.seeders.module-permissions-seeder',
            [
            'gen' => $this,
            'fields' => $this->advanceFields($this->request),
            'request' => $this->request,
            ]
        );

        return file_put_contents($seederFile, $content);
    }

    /**
     * Genera el seeder de datos de prueba del módulo o entidad.
     *
     * @return int|bool
     */
    public function generateFakeDataSeeder()
    {
        $seederFile = $this->seedsDir().'/'.$this->studlyCasePlural().'TableSeeder.php';

        $content = view(
            $this->templatesDir().'.seeders.module-fake-data-seeder',
            [
            'gen' => $this,
            'fields' => $this->advanceFields($this->request),
            'request' => $this->request,
            ]
        );

        return file_put_contents($seederFile, $content);
    }
}
