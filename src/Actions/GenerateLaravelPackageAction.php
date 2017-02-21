<?php

namespace llstarscreamll\Crud\Actions;

use Illuminate\Http\Request;
use llstarscreamll\Crud\Tasks\CreatePackageFoldersTask;
use llstarscreamll\Crud\Tasks\CreateComposerFileTask;
use llstarscreamll\Crud\Tasks\CreateActionsTask;
use llstarscreamll\Crud\Tasks\CreateTasksTask;
use llstarscreamll\Crud\Tasks\CreateApiRoutesTask;
use llstarscreamll\Crud\Tasks\CreateApiRequestsTask;
use llstarscreamll\Crud\Tasks\CreateCodeceptionTestsTask;
use llstarscreamll\Crud\Tasks\CreateModelFactoryTask;
use llstarscreamll\Crud\Tasks\CreateModelTask;
use llstarscreamll\Crud\Tasks\CreateApiControllerTask;

/**
* GenerateLaravelPackageAction Class.
* @author Johan Alvarez <llstarscreamll@hotmail.com>
*/
class GenerateLaravelPackageAction
{
    
    public function run(Request $request)
    {
        // generate the base folders
        $createPackageFoldersTask = new CreatePackageFoldersTask();
        $createPackageFoldersTask->run($request->get('is_part_of_package'));

        // generate composer file
        $createComposerFileTask = new CreateComposerFileTask();
        $createComposerFileTask->run($request->get('is_part_of_package'));

        // generate actions classes
        $createActionsTask = new CreateActionsTask($request);
        $createActionsTask->run();

        // generate tasks classes
        $createTasksTask = new CreateTasksTask($request);
        $createTasksTask->run();

        // generate API routes files
        $createApiRoutesTask = new CreateApiRoutesTask($request);
        $createApiRoutesTask->run();

        // generate API request files
        $createApiRequestsTask = new CreateApiRequestsTask($request);
        $createApiRequestsTask->run();

        // generate API controller
        $createApiControllerTask = new CreateApiControllerTask($request);
        $createApiControllerTask->run();

        // generate entity model factory files
        $createModelFactoryTask = new CreateModelFactoryTask($request);
        $createModelFactoryTask->run();

        // generate entity model
        $createModelTask = new CreateModelTask($request);
        $createModelTask->run();

        // generate Codeception tests files
        $createCodeceptionTestsTask = new CreateCodeceptionTestsTask($request);
        $createCodeceptionTestsTask->run();
    }
}
