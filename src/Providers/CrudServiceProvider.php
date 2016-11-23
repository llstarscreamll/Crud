<?php

namespace llstarscreamll\Crud\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;

class CrudServiceProvider extends ServiceProvider
{
    /**
     * La versión del paquete.
     *
     * @var string
     */
    const CRUD_VERSION = "2.0";

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Package Service Providers.
     *
     * @var array
     */
    protected $providers = [];

    /**
     * Package Aliases.
     *
     * @var array
     */
    protected $aliases = [];

    /**
     * Package Services.
     *
     * @var array
     */
    protected $services = [];

    /**
     * Package interfaces implementations.
     *
     * @var array
     */
    protected $interfacesImplementations = [];

    /**
     * Package Middlewares.
     *
     * @var array
     */
    protected $middleware = [];

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        // registramos las rutas
        if (!$this->app->routesAreCached()) {
            include __DIR__.'/../Routes/web.php';
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
                __DIR__.'/../Resources/Views/GeneratorTemplates' => base_path('resources/views/vendor/crud/templates'),
                ],
                'views'
            );

            // publica los archivos de configuración
            $this->publishes([__DIR__.'/../Config' => config_path()], 'config');
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        // registramos los servicios
        foreach ($this->services as $key => $value) {
            $this->app->bindIf($key, $value);
        }

        // registramos las implementaciones de los contratos de paquete
        foreach ($this->interfacesImplementations as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }

        // registramos los service providers
        foreach ($this->providers as $key => $value) {
            $this->app->register($value);
        }

        // registramos los alias
        $loader = AliasLoader::getInstance();
        foreach ($this->aliases as $key => $alias) {
            $loader->alias($key, $alias);
        }

        // registramos los middleware
        foreach ($this->middleware as $key => $value) {
            $this->app['router']->middleware($key, $value);
        }
    }
}
