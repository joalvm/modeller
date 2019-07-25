<?php

namespace Joalvm\Modeller;

use Joalvm\Modeller\ModellerCommand;
use Illuminate\Support\ServiceProvider;

class ModellerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ModellerCommand::class
            ]);
        }
    }
}
