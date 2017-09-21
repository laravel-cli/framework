<?php
namespace LaravelCli\Commands;

use Illuminate\Console\Command;

class MakeCommand extends Command
{
    protected $signature = 'make:command {name : The name of the command} {--F|force : force create }';

    protected $description = 'Create a new command class';

    public function handle()
    {
        $commandName = $this->argument('name');
        $commandName = ucfirst($commandName).'Command';

        $fileName = BASE_PATH.'/app/Commands/'.$commandName.'.php';
        if (!$this->option('force') && file_exists($fileName)) {
            $this->warn($commandName.' has exist.');
            return;
        }

        $template = <<<STR
<?php
namespace App\Commands;

use Illuminate\Console\Command;

class {$commandName} extends Command
{
    protected \$signature = '{$this->argument('name')}';
    
    protected \$description = 'Default description';
    
    public function handle()
    {
        \$this->line('{$commandName} generate by tool');
    }
}

STR;
        file_put_contents($fileName, $template);

        $this->info($commandName.' create successful.');
    }
}
