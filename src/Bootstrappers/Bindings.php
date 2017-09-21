<?php
namespace LaravelCli\Bootstrappers;

use Illuminate\Container\Container;

class Bindings extends Bootstrapper
{
    /**
     * {@inheritdoc}
     */
    public function bootstrap()
    {
        Container::setInstance($this->container);
        $this->container->instance('app', $this->container);
        $this->container->instance(Container::class, $this->container);
    }
}