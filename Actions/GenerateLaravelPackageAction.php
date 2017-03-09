<?php

namespace App\Containers\Crud\Actions;

use Illuminate\Http\Request;
use App\Containers\Crud\Tasks\CreatePackageFoldersTask;
use App\Containers\Crud\Tasks\CreateComposerFileTask;
use App\Containers\Crud\Tasks\CreateActionsTask;
use App\Containers\Crud\Tasks\CreateTasksTask;
use App\Containers\Crud\Tasks\CreateApiRoutesTask;
use App\Containers\Crud\Tasks\CreateApiRequestsTask;
use App\Containers\Crud\Tasks\CreateCodeceptionTestsTask;
use App\Containers\Crud\Tasks\CreateModelFactoryTask;
use App\Containers\Crud\Tasks\CreateModelTask;
use App\Containers\Crud\Tasks\CreateRepositoryTask;
use App\Containers\Crud\Tasks\CreateApiControllerTask;
use App\Containers\Crud\Tasks\RunPhpCsFixerOnDirTask;
use App\Containers\Crud\Tasks\CreateTransformerTask;
use App\Containers\Crud\Tasks\CreateExceptionsTask;
use App\Containers\Crud\Tasks\CreateFormModelConfigTask;

/**
 * GenerateLaravelPackageAction Class.
 *
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

        // generate exceptions classes
        $createExceptionsTask = new CreateExceptionsTask($request);
        $createExceptionsTask->run();

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

        // generate entity repository
        $createRepositoryTask = new CreateRepositoryTask($request);
        $createRepositoryTask->run();

        // generate entity transformer
        $createTransformerTask = new CreateTransformerTask($request);
        $createTransformerTask->run();

        // generate entity form model
        $createFormModelConfigTask = new CreateFormModelConfigTask($request);
        $createFormModelConfigTask->run();

        // generate Codeception tests files
        $createCodeceptionTestsTask = new CreateCodeceptionTestsTask($request);
        $createCodeceptionTestsTask->run();

        // execute php-cs-fixer on generated folder
        $runPhpCsFixerOnDirTask = new RunPhpCsFixerOnDirTask($request);
        $runPhpCsFixerOnDirTask->run();
    }
}
