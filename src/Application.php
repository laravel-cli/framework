<?php
namespace LaravelCli;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Contracts\Container\Container as ContainerContract;
use Illuminate\Contracts\Console\Application as ApplicationContract;
use Illuminate\Console\Application as BaseApplication;
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
use LaravelCli\Bootstrappers\Factory;

class Application extends BaseApplication implements ApplicationContract
{
    /**
     * @var ContainerContract
     */
    protected $container;

    /**
     * @var DispatcherContract
     */
    protected $dispatcher;

    public function __construct(
        ContainerContract $container = null,
        DispatcherContract $dispatcher = null,
        Factory $factory = null
    ) {
        $this->container = $container ?: new Container;
        $this->dispatcher = $dispatcher ?: new Dispatcher($this->container);
        static::$bootstrappers = $factory ?: (new Factory)->make();
        parent::__construct($this->container, $this->dispatcher, '');

        $this->setCatchExceptions(true);

        $this->commandsAutoload();
    }

    protected function commandsAutoload()
    {
        if (!env('AUTOLOAD_COMMANDS', false)) {
            return;
        }

        $handle = opendir($this->commandsPath());
        while ($file = readdir($handle)) {
            if (in_array($file, ['.', '..'])) {
                continue;
            }

            if (preg_match('~\w+Command~', $file)) {
                $commandName = 'App\Commands\\'.basename($file, '.php');
                $this->add(new $commandName);
            }
        }
        closedir($handle);
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function commandsPath()
    {
        return BASE_PATH.DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'Commands';
    }
}
