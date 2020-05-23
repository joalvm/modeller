<?php

namespace Modeller;

use Modeller\ModellerCommand;
use Illuminate\Support\ServiceProvider;

class ModellerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([ModellerCommand::class]);
        }
    }
}
