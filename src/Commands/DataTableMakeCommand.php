<?php

namespace Stianscholtz\LaravelDataTable\Commands;

use Illuminate\Console\GeneratorCommand;

class DataTableMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:data-table {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a Laravel Data Table in the DataTables directory';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Data Table';

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub(): string
    {
        return $this->resolveStubPath('/stubs/data-table-provider.stub');
    }

    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath(string $stub): string
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__.$stub;
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\DataTables';
    }
}