<?php

require __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Console\Kernel;

if (env('APP_ENV') === 'production')
{
    try
    {
        echo "migrate database for production\n";

        /** @var Application $app */
        $app = require __DIR__ . '/bootstrap/app.php';
        $app->loadEnvironmentFrom('.env.production');

        /** @var Kernel $kernel */
        $kernel = $app->make(Kernel::class);
        $kernel->call('config:clear');
        $kernel->call('migrate:fresh', ['--seed' => true, '--force' => true]);
        // echo $kernel->call('migrate', ['--force' => true]);

        echo "migrate databse for production done\n";
    } catch (\Throwable $th)
    {
        echo "gagal menjalankan migrasi database\n";
        echo $th->getMessage();
    }
}