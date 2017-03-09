<?php

namespace App\Containers\Crud\Actions;

use Illuminate\Http\Request;
use App\Containers\Crud\Providers\ModelGenerator;
use App\Containers\Crud\Providers\RouteGenerator;
use App\Containers\Crud\Providers\ControllerGenerator;
use App\Containers\Crud\Providers\ViewsGenerator;
use App\Containers\Crud\Providers\TestsGenerator;
use App\Containers\Crud\Providers\ModelFactoryGenerator;
use App\Containers\Crud\Providers\FormRequestGenerator;
use App\Containers\Crud\Providers\ServiceGenerator;
use App\Containers\Crud\Providers\RepositoryGenerator;
use App\Containers\Crud\Providers\LangGenerator;
use App\Containers\Crud\Providers\SeedersGenerator;
use App\Containers\Crud\Providers\FurtherTasks;

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