<?php
namespace LaravelCli\Bootstrappers;

use Dotenv\Dotenv;

class Config extends Bootstrapper
{
    public function bootstrap()
    {
        (new Dotenv(BASE_PATH))->load();

        date_default_timezone_set(env('APP_TIMEZONE', 'PRC'));
        mb_internal_encoding('UTF-8');
    }
}
