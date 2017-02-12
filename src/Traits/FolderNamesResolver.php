<?php

namespace llstarscreamll\Crud\Traits;

/**
* FolderNamesResolver Trait.
*/
trait FolderNamesResolver
{
    public function templatesDir()
    {
        return config('modules.crud.config.templates');
    }

    /**
     * Entity Names
     */

    public function entityName()
    {
        return studly_case(str_singular($this->tableName));
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
        return app_path('Containers');
    }

    public function containerFolder()
    {
        $container = $this->containerName();
        return app_path('Containers/'.$container);
    }

    public function actionsFolder()
    {
        return $this->containerFolder().'/Actions';
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
            $variable = str_plural(class_basename($namespace));
        }

        return '$'.$variable;
    }

    public function camelCaseClass(string $namespace)
    {
        return camel_case(class_basename($namespace));
    }

    public function relationNameFromColumnName($fieldName)
    {
        $functionName = camel_case(str_replace('_id', '', $fieldName));

        // singular name
        if (in_array($functionName, ['belongsTo', 'hasOne'])) {
            $functionName = str_singular($functionName);
        }

        // plural name
        if (in_array($functionName, ['hasMany', 'belongsToMany'])) {
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

    public function repositoriesFolder()
    {
        return $this->dataFolder().'/Repositories';
    }

    public function seedersFolder()
    {
        return $this->dataFolder().'/Seeders';
    }

    public function modelsFolder()
    {
        return $this->containerFolder().'/Models';
    }

    public function tasksFolder()
    {
        return $this->containerFolder().'/Tasks';
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

    public function apiTestFile(string $test, bool $plural = false)
    {
        $entity = $plural
            ? str_plural($this->entityName())
            : $this->entityName();

        return $test.$entity.'Cest.php';
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

    public function apiRouteFile(string $route, bool $plural = false)
    {
        $entity = $plural
            ? str_plural($this->entityName())
            : $this->entityName();

        return $route.$entity.'.v1.private.php';
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

    public function actionFile(string $action, bool $plural = false)
    {
        $entity = $plural
            ? str_plural($this->entityName())
            : $this->entityName();

        return $action.$entity.'Action.php';
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
}
