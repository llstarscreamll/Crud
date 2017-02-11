<?php

namespace llstarscreamll\Crud\Actions;

use llstarscreamll\Crud\Traits\FolderNamesResolver;

/**
* PortoFoldersGeneration Class.
*
* @author Johan Alvarez <llstarscreamll@hotmail.com>
*/
class PortoFoldersGenerationAction
{
    use FolderNamesResolver;

    /**
     * Container name to generate.
     *
     * @var string
     */
    private $container = '';

    /**
     * @param  string $container Contaner name.
     * @return bool
     */
    public function run(string $container)
    {
        $this->container = studly_case($container);

        // Generate Containers folder
        if (!file_exists($this->portoContainersFolder())) {
            mkdir($this->portoContainersFolder());
        }

        // Generate Porto package container folder
        if (!file_exists($this->containerFolder($this->container))) {
            mkdir($this->containerFolder($this->container));
        }

        // Generate Actions folder
        if (!file_exists($this->actionsFolder())) {
            mkdir($this->actionsFolder());
        }

        // Generate Data folder
        if (!file_exists($this->dataFolder())) {
            mkdir($this->dataFolder());
        }

        // Generate Criterias folder
        if (!file_exists($this->criteriasFolder())) {
            mkdir($this->criteriasFolder());
        }

        // Generate factories folder
        if (!file_exists($this->factoriesFolder())) {
            mkdir($this->factoriesFolder());
        }

        // Generate migrations folder
        if (!file_exists($this->migrationsFolder())) {
            mkdir($this->migrationsFolder());
        }

        // Generate repositories folder
        if (!file_exists($this->repositoriesFolder())) {
            mkdir($this->repositoriesFolder());
        }

        // Generate seeders folder
        if (!file_exists($this->seedersFolder())) {
            mkdir($this->seedersFolder());
        }

        // Generate Models folder
        if (!file_exists($this->modelsFolder())) {
            mkdir($this->modelsFolder());
        }

        // Generate Tasks folder
        if (!file_exists($this->tasksFolder())) {
            mkdir($this->tasksFolder());
        }

        // Generate Tests folder
        if (!file_exists($this->testsFolder())) {
            mkdir($this->testsFolder());
        }

        // Generate UI/
        if (!file_exists($this->uiFolder())) {
            mkdir($this->uiFolder());
        }

        // Generate UI/API
        if (!file_exists($this->apiFolder())) {
            mkdir($this->apiFolder());
        }

        // Generate UI/API/Controllers folder
        if (!file_exists($this->apiControllersFolder())) {
            mkdir($this->apiControllersFolder());
        }

        // Generate UI/API/Requests folder
        if (!file_exists($this->apiRequestsFolder())) {
            mkdir($this->apiRequestsFolder());
        }

        // Generate UI/API/Routes folder
        if (!file_exists($this->apiRoutesFolder())) {
            mkdir($this->apiRoutesFolder());
        }

        // Generate UI/API/Transformers folder
        if (!file_exists($this->apiTransformersFolder())) {
            mkdir($this->apiTransformersFolder());
        }

        // Generate UI/CLI
        if (!file_exists($this->cliFolder())) {
            mkdir($this->cliFolder());
        }

        // Generate UI/WEB folder
        if (!file_exists($this->webFolder())) {
            mkdir($this->webFolder());
        }

        // Generate UI/WEB/Controllers folder
        if (!file_exists($this->webControllersFolder())) {
            mkdir($this->webControllersFolder());
        }

        // Generate UI/WEB/Requests folder
        if (!file_exists($this->webRequestsFolder())) {
            mkdir($this->webRequestsFolder());
        }

        // Generate UI/WEB/Routes folder
        if (!file_exists($this->webRoutesFolder())) {
            mkdir($this->webRoutesFolder());
        }

        // Generate UI/WEB/Views folder
        if (!file_exists($this->webViewsFolder())) {
            mkdir($this->webViewsFolder());
        }

        return true;
    }
}
