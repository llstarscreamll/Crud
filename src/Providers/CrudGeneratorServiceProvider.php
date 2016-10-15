<?php

namespace llstarscreamll\CrudGenerator\Providers;

use Illuminate\Support\ServiceProvider;

class CrudGeneratorServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // registramos las rutas
        if (!$this->app->routesAreCached()) {
            include __DIR__.'/../App/Http/routes.php';
        }

        $this->loadResources();
        $this->publishResources();
    }

    /**
     * Loads the application resources.
     */
    public function loadResources()
    {
        // carga las vistas
        $this->loadViewsFrom(__DIR__.'/../Resources/Views', 'crud');

        // cargamos las migraciones del paquete
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }

    /**
     * Publishes the application resources.
     */
    private function publishResources()
    {
        if ($this->app->runningInConsole()) {
            // publica las vistas para generar los archivos
            $this->publishes(
                [
                __DIR__.'/../Resources/Views/GeneratorTemplates' => base_path('resources/views/vendor/CrudGenerator/templates'),
                ],
                'views'
            );

            // publica los archivos de configuración
            $this->publishes([__DIR__.'/../Config' => config_path('')], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
    }
}
