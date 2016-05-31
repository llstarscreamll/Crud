<?php

namespace llstarscreamll\CrudGenerator\Providers;

use Illuminate\Support\ServiceProvider;
use llstarscreamll\CrudGenerator\Commands\Crud;

class CrudGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // referencia a los comandos del paquete
        $this->commands([Crud::class]);

        // carga las vistas
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'CrudGenerator');

        // publica las vistas para generar los archivos
        // $this->publishes([__DIR__.'/../Resources/Views/GeneratorTemplates/single-page-templates' => base_path('resources/views/vendor/CrudGenerator/single-page-templates')], 'views');

        // publica los archivos de configuración
        $this->publishes([__DIR__.'/../Config' => config_path('')], 'config');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        if (! $this->app->routesAreCached()) {
            include __DIR__.'/../App/Http/routes.php';
        }

        $this->app->make('llstarscreamll\CrudGenerator\App\Http\Controllers\GeneratorController');
    }
}
