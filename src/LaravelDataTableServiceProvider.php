<?php

namespace Stianscholtz\LaravelDataTable;

use Illuminate\Support\ServiceProvider;
use Stianscholtz\LaravelDataTable\Commands\DataTableMakeCommand;

class LaravelDataTableServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                DataTableMakeCommand::class
            ]);
        }
    }
}