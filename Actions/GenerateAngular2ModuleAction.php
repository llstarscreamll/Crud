<?php

namespace App\Containers\Crud\Actions;

use Illuminate\Support\Collection;
use App\Containers\Crud\Tasks\CreateAngular2DirsTask;
use App\Containers\Crud\Tasks\CreateNgModulesTask;
use App\Containers\Crud\Tasks\CreateNgContainersTask;
use App\Containers\Crud\Tasks\CreateNgComponentsTask;
use App\Containers\Crud\Tasks\CreateNgTranslationsTask;
use App\Containers\Crud\Tasks\CreateNgModelTask;
use App\Containers\Crud\Tasks\CreateNgActionsTask;
use App\Containers\Crud\Tasks\CreateNgReducerTask;
use App\Containers\Crud\Tasks\CreateNgEffectsTask;
use App\Containers\Crud\Tasks\CreateNgServiceTask;
use App\Containers\Crud\Tasks\CreateNgRoutesTask;
use App\Containers\Crud\Tasks\CreateNgUtilsTask;
use App\Containers\Crud\Tasks\CreateNgConfigsTask;

/**
 * GenerateAngular2ModuleAction Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class GenerateAngular2ModuleAction
{
    public function run(Collection $request)
    {
        // prevent persist data generated from factories
        \DB::beginTransaction();

        // generate the base folders
        $createAngular2DirsTask = new CreateAngular2DirsTask($request);
        $createAngular2DirsTask->run();

        // generate module and routing module
        $createNgModulesTask = new CreateNgModulesTask($request);
        $createNgModulesTask->run();

        // generate translations
        $createNgTranslationsTask = new CreateNgTranslationsTask($request);
        $createNgTranslationsTask->run();

        // generate containers
        $createNgContainersTask = new CreateNgContainersTask($request);
        $createNgContainersTask->run();

        // generate components
        $createNgComponentsTask = new CreateNgComponentsTask($request);
        $createNgComponentsTask->run();

        // generate model
        $createNgModelTask = new CreateNgModelTask($request);
        $createNgModelTask->run();

        // generate actions
        $createNgActionsTask = new CreateNgActionsTask($request);
        $createNgActionsTask->run();

        // generate reducer
        $createNgReducerTask = new CreateNgReducerTask($request);
        $createNgReducerTask->run();

        // generate effects
        $createNgEffectsTask = new CreateNgEffectsTask($request);
        $createNgEffectsTask->run();

        // generate service
        $createNgServiceTask = new CreateNgServiceTask($request);
        $createNgServiceTask->run();

        // generate routes
        $createNgRoutesTask = new CreateNgRoutesTask($request);
        $createNgRoutesTask->run();

        // generate utils
        $createNgUtilsTask = new CreateNgUtilsTask($request);
        $createNgUtilsTask->run();

        // generate configs
        $createNgConfigsTask = new CreateNgConfigsTask($request);
        $createNgConfigsTask->run();

        \DB::rollback();
    }
}
