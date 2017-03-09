<?php

namespace llstarscreamll\Crud\Actions;

use Illuminate\Http\Request;
use llstarscreamll\Crud\Providers\ModelGenerator;
use llstarscreamll\Crud\Providers\RouteGenerator;
use llstarscreamll\Crud\Providers\ControllerGenerator;
use llstarscreamll\Crud\Providers\ViewsGenerator;
use llstarscreamll\Crud\Providers\TestsGenerator;
use llstarscreamll\Crud\Providers\ModelFactoryGenerator;
use llstarscreamll\Crud\Providers\FormRequestGenerator;
use llstarscreamll\Crud\Providers\ServiceGenerator;
use llstarscreamll\Crud\Providers\RepositoryGenerator;
use llstarscreamll\Crud\Providers\LangGenerator;
use llstarscreamll\Crud\Providers\SeedersGenerator;
use llstarscreamll\Crud\Providers\FurtherTasks;

/**
* GenerateStandardLaravelApp Class.
*
* @author Johan Alvarez <llstarscreamll@hotmail.com>
*/
class GenerateStandardLaravelApp
{
    public function run(Request $request)
    {
        $modelGenerator = new ModelGenerator($request);
        $controllerGenerator = new ControllerGenerator($request);
        $routeGenerator = new RouteGenerator($request);
        $viewsGenerator = new ViewsGenerator($request);
        $testsGenerator = new TestsGenerator($request);
        $modelFactoryGenerator = new ModelFactoryGenerator($request);
        $formRequestGenerator = new FormRequestGenerator($request);
        $serviceGenerator = new ServiceGenerator($request);
        $reposGenerator = new RepositoryGenerator($request);
        $langGenerator = new LangGenerator($request);
        $seedersGenerator = new SeedersGenerator($request);
        $furtherTasks = new FurtherTasks();

        $seedersGenerator->run();
        $langGenerator->run();
        $reposGenerator->run();
        $serviceGenerator->run();
        $formRequestGenerator->run();
        $modelFactoryGenerator->run();
        $testsGenerator->run();
        $modelGenerator->run();
        $controllerGenerator->run();
        $routeGenerator->run();
        $viewsGenerator->run();
        $furtherTasks->run();

        return true;
    }
}