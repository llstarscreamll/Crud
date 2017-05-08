<?php

namespace App\Containers\Crud\Providers;

use App\Ship\Parents\Providers\MainProvider;
use Collective\Html\HtmlServiceProvider;

/**
 * Class MainServiceProvider.
 *
 * @author  Johan Alvarez <llstarscreamll@hotmail.com>
 */
class MainServiceProvider extends MainProvider
{

    /**
     * Container Service Providers.
     *
     * @var array
     */
    public $serviceProviders = [
        HtmlServiceProvider::class
    ];

    /**
     * Container Aliases
     *
     * @var  array
     */
    public $aliases = [
        'Form' => \Collective\Html\FormFacade::class,
        'Html' => \Collective\Html\HtmlFacade::class,
    ];

    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        parent::boot();

        if ($this->app->runningInConsole()) {
            $stubs = __DIR__.'/../Stubs';
            // stubs
            $this->publishes(
                [
                    $stubs => base_path(),
                ],
                'classes'
            );
        }
    }
}
