<?php

namespace llstarscreamll\CrudGenerator\Providers;

/**
 *
 */
class RepositoryGenerator extends BaseGenerator
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
     *
     */
    public function __construct($request)
    {
        $this->table_name = $request->get('table_name');
        $this->request = $request;
    }

    /**
     * Genera clases repositorio para la entidad.
     *
     * @return int|bool
     */
    public function generate()
    {
        $this->buildContract();
        $this->buildImplementation();
        $this->buildCriteria();
        $this->generateAppBinding();

        return true;
    }

    /**
     * Contruye el contrato del repositorio.
     *
     * @return int|false
     */
    public function buildContract()
    {
        // no se ha creado la carpeta para los contratos de los repositorios?
        if (!file_exists($this->reposContractDir())) {
            // entonces la creo
            mkdir($this->reposContractDir(), 0755, true);
        }

        $repoContractFile = $this->reposContractDir().'/'.$this->getRepositoryInterfaceName().'.php';

        $content = view(
            $this->templatesDir().'.repositoryInterface',
            [
            'gen' => $this,
            'fields' => $this->advanceFields($this->request),
            'request' => $this->request,
            ]
        );

        return file_put_contents($repoContractFile, $content);
    }

    /**
     * Contruye la implementación del repositorio.
     *
     * @return int|false
     */
    public function buildImplementation()
    {
        // no se ha creado la carpeta para los contratos de los repositorios?
        if (!file_exists($this->repoImplementationsDir())) {
            // entonces la creo
            mkdir($this->repoImplementationsDir(), 0755, true);
        }

        $repoContractFile = $this->repoImplementationsDir().'/'.$this->getRepositoryImplementationName().'.php';

        $content = view(
            $this->templatesDir().'.repositoryEloquentImplementation',
            [
            'gen' => $this,
            'fields' => $this->advanceFields($this->request),
            'request' => $this->request,
            ]
        );

        return file_put_contents($repoContractFile, $content);
    }

    /**
     * Contruye criterio de búsqueda para el repositorio.
     *
     * @return int|false
     */
    public function buildCriteria()
    {
        // no se ha creado la carpeta para los contratos de los repositorios?
        if (!file_exists($this->repoCriteriasDir())) {
            // entonces la creo
            mkdir($this->repoCriteriasDir(), 0755, true);
        }

        $repoContractFile = $this->repoCriteriasDir().'/'.$this->getRepositoryCriteriaName().'.php';

        $content = view(
            $this->templatesDir().'.repositoryCriteria',
            [
            'gen' => $this,
            'fields' => $this->advanceFields($this->request),
            'request' => $this->request,
            ]
        );

        return file_put_contents($repoContractFile, $content);
    }

    public function generateAppBinding()
    {
        $appServiceProviderFile = app_path('Providers/AppServiceProvider.php');
        $appServiceProviderFileContents = file_get_contents(
            app_path('Providers/AppServiceProvider.php')
        );

        // generamos el string del binding
        $contract = config('modules.CrudGenerator.config.parent-app-namespace').
            '\\Repositories\\Contracts\\'.
            $this->getRepositoryInterfaceName();
        $implementation = config('modules.CrudGenerator.config.parent-app-namespace').
            '\\Repositories\\'.
            $this->getRepositoryImplementationName();
        $binding = "\$this->app->bind('$contract', '$implementation');";

        // se ha generado ya el binding de los repositorios?
        if (str_contains($appServiceProviderFileContents, $binding)) {
            // el binding ya se ha generado, salimos
            return false;
        }

        // encontramos primero la función en donde vamos a registrar el bind de
        // los repositorios
        $functionStr = "public function register()\n".
            "    {";

        if (str_contains($appServiceProviderFileContents, $functionStr)) {
            $binding = $functionStr."\n".
                "        ".
                $binding;
            $content = str_replace($functionStr, $binding, $appServiceProviderFileContents);

            return file_put_contents($appServiceProviderFile, $content);
        }

        return false;
    }

    /**
     * Devuelve el path donde se guardan los contratos de los repositorios.
     *
     * @return string
     */
    public function reposContractDir()
    {
        return $this->repostDir().'/Contracts';
    }

    /**
     * Devuelve el path donde se guardan las implementaciones de los contratos
     * de los repositorios.
     *
     * @return string
     */
    public function repoImplementationsDir()
    {
        return $this->repostDir().'';
    }

    /**
     * Devuelve el path donde se guardan los repositorios.
     *
     * @return string
     */
    public function repostDir()
    {
        return app_path().'/Repositories';
    }

    /**
     * Devuelve path donde se guardan las clases los criterios para búsqueda de
     * en los repositorios.
     *
     * @return string
     */
    public function repoCriteriasDir()
    {
        return $this->repostDir().'/Criterias';
    }

    /**
     * Obtiene el nombre de la clase que implementa el contrato del repositorio.
     *
     * @return string
     */
    public function getRepositoryImplementationName()
    {
        return $this->modelClassName().'EloquentRepository';
    }

    /**
     * Obtiene el nombre de la interface del repositorio.
     *
     * @return string
     */
    public function getRepositoryInterfaceName()
    {
        return $this->modelClassName().'Repository';
    }

    /**
     * Devuelve string con clausula para el Query Builder de Eloquent.
     *
     * @param stdClass $field
     * @param string   $value
     *
     * @return string
     */
    public function getConditionStr($field, $value = null)
    {
        $columnName = $field->name == 'id' ? 'ids' : $field->name;

        // cláusula por defecto
        $string = "'{$field->name}', \$this->input->get('{$columnName}')";

        // para búsquedas de tipo texto
        if (in_array($field->type, ['varchar', 'text'])) {
            $string = "'{$field->name}', 'like', '%'.\$this->input->get('{$columnName}').'%'";
        }

        // para búsquedas en campos de tipo enum
        if ($field->type == 'enum') {
            $string = "'{$field->name}', \$this->input->get('$columnName')";
        }

        // para búsqueda en campos de tipo boolean
        if ($field->type == 'tinyint') {
            $string = "'{$field->name}', $value";
        }

        return $string;
    }
}
