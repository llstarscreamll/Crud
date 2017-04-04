<?php

namespace App\Containers\Crud\Traits;

use stdClass;

/**
* FolderNamesResolver Trait.
*/
trait FolderNamesResolver
{
    public function templatesDir()
    {
        return config('crudconfig.templates');
    }

    public function outputDir()
    {
        return config('crudconfig.output_folder');
    }

    public function codeOutputDir()
    {
        return $this->outputDir().'code/';
    }

    public function optionsOutputDir()
    {
        return $this->outputDir().'options/';
    }

    /**
     * Entity Names
     */

    public function entityName()
    {
        return studly_case(str_singular($this->tableName));
    }

    /**
     * TODO: duplicated method!! is on AngularFolderNamesResolver too... clean!!
     */
    public function slugEntityName($plural = false)
    {
        $entity = $plural
            ? str_plural($this->tableName)
            : str_singular($this->tableName);

        return str_slug($entity, '-');
    }

    public function containerName()
    {
        return studly_case(str_singular($this->container));
    }

    /**
     * Container base folders
     */
    
    public function portoContainersFolder()
    {
        return $this->codeOutputDir().'PortoContainers';
    }

    public function containerFolder()
    {
        $container = $this->containerName();
        return $this->portoContainersFolder().'/'.$container;
    }

    public function actionsFolder()
    {
        return $this->containerFolder().'/Actions';
    }

    public function configsFolder()
    {
        return $this->containerFolder().'/Configs';
    }

    public function exceptionsFolder()
    {
        return $this->containerFolder().'/Exceptions';
    }

    /**
     * Data folders.
     */

    public function dataFolder()
    {
        return $this->containerFolder().'/Data';
    }

    public function entityModelNamespace()
    {
        return 'App\\Containers\\'.
            $this->containerName().'\\'.
            'Models\\'.$this->entityName();
    }

    public function variableFromNamespace(string $namespace, bool $singular = true)
    {
        $variable = $this->camelCaseClass($namespace);
        
        if (!$singular) {
            $variable = str_plural($variable);
        }

        return '$'.$variable;
    }

    public function camelCaseClass(string $namespace)
    {
        return camel_case(class_basename($namespace));
    }

    public function relationNameFromField(stdClass $field)
    {
        $functionName = camel_case(str_replace('_id', '', $field->name));

        // singular name
        if (in_array($field->relation, ['belongsTo', 'hasOne'])) {
            $functionName = str_singular($functionName);
        }

        // plural name
        if (in_array($field->relation, ['hasMany', 'belongsToMany'])) {
            $functionName = str_plural($functionName);
        }

        return $functionName;
    }

    public function criteriasFolder()
    {
        return $this->dataFolder().'/Criterias';
    }

    public function factoriesFolder()
    {
        return $this->dataFolder().'/Factories';
    }

    public function migrationsFolder()
    {
        return $this->dataFolder().'/Migrations';
    }

    /**
     * Repositories.
     */
    
    public function namespacedRepoFromModelNamespace(string $namespace)
    {
        $repo = str_replace('Models', 'Data\Repositories', $namespace).'Repository';

        return $repo;
    }
    
    public function repositoriesFolder()
    {
        return $this->dataFolder().'/Repositories';
    }
    
    public function entityRepoClass()
    {
        return $this->entityName()."Repository";
    }

    public function seedersFolder()
    {
        return $this->dataFolder().'/Seeders';
    }

    public function modelsFolder()
    {
        return $this->containerFolder().'/Models';
    }

    public function uiFolder()
    {
        return $this->containerFolder().'/UI';
    }

    /**
     * Tests
     */

    public function testsFolder()
    {
        return $this->containerFolder().'/tests';
    }

    public function apiTestsFolder()
    {
        return $this->containerFolder().'/tests/api';
    }

    public function apiTestFile(string $test, bool $plural = false, $atStart)
    {
        $entity = $plural
            ? str_plural($this->entityName())
            : $this->entityName();

        $baseName = $atStart
            ? $entity.$test
            : $test.$entity;

        return $baseName.'Cest.php';
    }

    /**
     * API
     */

    public function apiFolder()
    {
        return $this->uiFolder().'/API';
    }

    public function apiControllersFolder()
    {
        return $this->apiFolder().'/Controllers';
    }

    public function apiRequestsFolder()
    {
        return $this->apiFolder().'/Requests';
    }

    public function apiRoutesFolder()
    {
        return $this->apiFolder().'/Routes';
    }

    public function apiTransformersFolder()
    {
        return $this->apiFolder().'/Transformers';
    }

    public function apiRouteFile(string $route, bool $plural = false, bool $atStart = false)
    {
        $entity = $plural
            ? str_plural($this->entityName())
            : $this->entityName();

        $baseName = $atStart === true
            ? $entity.$route
            : $route.$entity;

        return $baseName.'.v1.private.php';
    }

    public function apiRequestFile(string $request, bool $plural = false)
    {
        $entity = $plural
            ? str_plural($this->entityName())
            : $this->entityName();

        return $request.$entity.'Request.php';
    }

    /**
     * CLI
     */

    public function cliFolder()
    {
        return $this->uiFolder().'/CLI';
    }

    /**
     * WEB
     */

    public function webFolder()
    {
        return $this->uiFolder().'/WEB';
    }

    public function webControllersFolder()
    {
        return $this->webFolder().'/Controllers';
    }

    public function webRequestsFolder()
    {
        return $this->webFolder().'/Requests';
    }

    public function webRoutesFolder()
    {
        return $this->webFolder().'/Routes';
    }

    public function webViewsFolder()
    {
        return $this->webFolder().'/Views';
    }

    /**
     * Actions
     */

    public function actionFile(string $action, bool $plural = false, bool $atStart = false)
    {
        $entity = $plural
            ? str_plural($this->entityName())
            : $this->entityName();

        $baseName = $atStart === true
            ? $entity.$action
            : $action.$entity;

        return $baseName.'Action.php';
    }

    public function criteriaFile(string $criteria, bool $plural = false) {
        $entity = $plural
            ? str_plural($this->entityName())
            : $this->entityName();

        $baseName = str_replace(':entity:', $this->entityName(), $criteria);

        return $baseName.'Criteria.php';
    }

    public function actionClass(string $action, bool $plural = false, bool $atStart = false)
    {
        $actionFile = $this->actionFile($action, $plural, $atStart);
        $actionClass = str_replace('.php', '', $actionFile);

        return $actionClass;
    }

    /**
     * Tasks
     */

    public function taskFile(string $task, bool $plural = false)
    {
        $entity = $plural
            ? str_plural($this->entityName())
            : $this->entityName();

        return $task.$entity.'Task.php';
    }

    public function tasksFolder()
    {
        return $this->containerFolder().'/Tasks';
    }

    public function taskClass(string $task, bool $plural = false)
    {
        $taskFile = $this->taskFile($task, $plural);
        $taskClass = str_replace('.php', '', $taskFile);

        return $taskClass;
    }
}
