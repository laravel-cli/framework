<?php
namespace LaravelCli\Bootstrappers;

class Commands extends Bootstrapper
{
    protected $commands = [
        \LaravelCli\Commands\MakeCommand::class,
    ];

    public function bootstrap()
    {
        foreach ($this->commands as $command) {
            $this->application->add(new $command);
        }
    }

    private function autoloadCommands()
    {

    }
}
