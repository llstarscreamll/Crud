<?php

namespace llstarscreamll\Crud\Actions;

use Illuminate\Http\Request;

use llstarscreamll\Crud\Tasks\CreateAngular2DirsTask;
use llstarscreamll\Crud\Tasks\CreateNgModulesTask;
use llstarscreamll\Crud\Tasks\CreateNgContainersTask;
use llstarscreamll\Crud\Tasks\CreateNgComponentsTask;
use llstarscreamll\Crud\Tasks\CreateNgTranslationsTask;
use llstarscreamll\Crud\Tasks\CreateNgModelTask;
use llstarscreamll\Crud\Tasks\CreateNgActionsTask;
use llstarscreamll\Crud\Tasks\CreateNgReducerTask;
use llstarscreamll\Crud\Tasks\CreateNgEffectsTask;
use llstarscreamll\Crud\Tasks\CreateNgServiceTask;

/**
 * GenerateAngular2ModuleAction Class.
 *
 * @author Johan Alvarez <llstarscreamll@hotmail.com>
 */
class GenerateAngular2ModuleAction
{
    public function run(Request $request)
    {
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
    }
}
