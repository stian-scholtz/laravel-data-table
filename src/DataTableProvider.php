<?php

namespace Stianscholtz\LaravelDataTable;

use Illuminate\Contracts\Database\Query\Builder;

abstract class DataTableProvider
{
    /**
     * @return Builder
     */
    abstract public function query(): Builder;

    /**
     * @param  DataTableBuilder  $builder
     * @return void
     */
    abstract public function columns(DataTableBuilder $builder): void;

    /**
     * @param  array  $pageParameters
     * @return array
     */
    public static function get(array $pageParameters = []): array
    {
        return [
            ...DataTable::forProvider(new static)->get(),
            ...$pageParameters,
        ];
    }
}
