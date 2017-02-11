<?php

namespace llstarscreamll\Crud\Traits;

/**
* FolderNamesResolver Trait.
*/
trait FolderNamesResolver
{
    public function containerName()
    {
        return studly_case(str_singular($this->container));
    }

    public function templatesDir()
    {
        return config('modules.crud.config.templates');
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

    public function testsFolder()
    {
        return $this->containerFolder().'/Tests';
    }

    public function uiFolder()
    {
        return $this->containerFolder().'/UI';
    }

    /**
     * API folders.
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

    /**
     * CLI folders.
     */

    public function cliFolder()
    {
        return $this->uiFolder().'/CLI';
    }

    /**
     * WEB folders.
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
     * Actions files.
     */

    public function actionFile(string $action, bool $plural = false)
    {
        $entity = $plural
            ? str_plural($this->containerName())
            : $this->containerName();

        return $action.$entity.'Action.php';
    }

    /**
     * Tasks files.
     */

    public function taskFile(string $task, bool $plural = false)
    {
        $entity = $plural
            ? str_plural($this->containerName())
            : $this->containerName();

        return $task.$entity.'Task.php';
    }

    public function apiRouteFile(string $route, bool $plural = false)
    {
        $entity = $plural
            ? str_plural($this->containerName())
            : $this->containerName();

        return $route.$entity.'.v1.private.php';
    }

    public function apiRequestFile(string $request, bool $plural = false)
    {
        $entity = $plural
            ? str_plural($this->containerName())
            : $this->containerName();

        return $request.$entity.'Request.php';
    }
}
