<?php
namespace LaravelCli\Bootstrappers;

use LaravelCli\Application;

class Factory
{
    private $bootstrappers = [
        Bindings::class,
        Config::class,
        Commands::class,
    ];

    public function make()
    {
        return array_map(function ($bootstrapper) {
            return function (Application $application) use ($bootstrapper) {
                return (new $bootstrapper($application))->bootstrap();
            };
        }, $this->bootstrappers);
    }
}